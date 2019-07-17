<?php

namespace frontend\models;

use backend\models\UML;
use common\models\Product;
use common\models\ProductParam;
use common\models\Supplier;
use Exception;
use Yii;
use yii\base\Model;

class Xml extends Model
{
    public function loadXml($supplierName, $data, $supplierId, $notAvailableIfExists = false) {
        $str = "type;artikul;message\r\n";
        $currentProducts = Product::findAll(['supplier' => $supplierId]);
        $currentArray = [];
        $supplier = Supplier::findOne($supplierId);

        foreach($currentProducts as $product) {
            $productParams = $product->getParams();

            foreach($productParams as $pp) {
                $ppArtikul = trim($pp->artikul);

                if (!empty($ppArtikul)) {
                    if (!array_key_exists($ppArtikul, $data)) {
                        $currentArray[] = $ppArtikul;

                        if ($notAvailableIfExists) {
                            $pp->available = 0;
                        }

                        $pp->save();
                    }
                }
            }
        }

        foreach($data as $artikul => $item) {
            $artikul = trim($artikul);

            if (!empty($artikul)) {
                if ($productParam = ProductParam::findOne(['artikul' => $artikul])) {
                    $message = [];
                    $product = Product::findOne($productParam->product_id);
                    $old_price = $product->price;
                    
                    if (
                        $item['available'] === 'Отсутствует'
                        ||
                        $item['available'] === 'Ожидается'
                        ||
                        $item['available'] === 'false'
                        ||
                        (is_numeric($item['available']) && $item['available'] == 0)
                        ||
                        ((int) $item['available'] < 0)
                        ||
                        stristr($item['available'], 'Под заказ')
                        ||
                        stristr($item['available'], 'жидается')
                    ) {
                        $available = 0;
                    } else if (is_numeric($item['available'])) {
                        $available = (int) $item['available'];
                        $available = 10;
                    } else if (
                        $item['available'] == 'более 10'
                        ||
                        $item['available'] == 'true'
                        ||
                        stristr($item['available'], 'В наличии')
                    ) {
                        $available = 10;
                    } else {
                        $available = 10;
                    }

                    if ($product->supplier == $supplierId) {
                        if ($product->price != $item['price']) {
                            $message[] = "Изменена цена";
                        }

                        if ($productParam->available != $available) {
                            $message[] = "Наличие изменено";
                        }

                        if ($item['price'] > 0) {
                            $product->price = $item['price'];
                        }

                        $productParam->available = $available;
                    } else {
                        if ($product->price > $item['price']) {
                            $str .= "attention;$artikul; Есть цена ниже у {$supplier->name}\r\n";
                            $this->sendMessage("Для $artikul есть цена ниже у {$supplier->name}", '');
                        }

                        if ($available > 0 && $productParam->available == 0) {
                            $str .= "attention;$artikul; У {$supplier->name} товар есть в наличии\r\n";
                            $this->sendMessage("Для $artikul у {$supplier->name} товар есть в наличии", '');
                        }
                    }

                    if ($product->price > $old_price) {
                        $product->price_old = $old_price;
                    } else {
                        $product->price_old = NULL;
                    }

                    $product->updated_at = time();

                    if ($product->save() && $productParam->save()) {
                        $message[] = 'Всё сохранено успешно';
                    } else {
                        $message[] = 'Не сохранено';
                    }

                    $str .= "success;$artikul;".implode(' && ', $message)."\r\n";
                } else {
                    $str .= "error;$artikul;Такого артикула нет\r\n";
                }
            }
        }

        if (!empty($currentArray)) {
            $str .= "error;".implode(',', $currentArray).";Этих артикулов нет у поставщика\r\n";
        }

        file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/www/logs/$supplierName.log", $str);
    }

    public function sendMessage($subject, $message) {
        Yii::$app->mailer
            ->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setTextBody($message)
            ->setSubject($subject)
            ->send();
    }

    public static function parseAll() {
        $xml = new Xml();
        try {
            $wellFitness = simplexml_load_file('http://www.wellfitness.ru/system/storage/download/export.xml');
            $wellFitnessArray = [];

            foreach($wellFitness->catalog->items->item as $offer) {
                $available = (int) $offer->QUANTITY;
                $artikul = (string) trim($offer->article);
                $price = (int) $offer->price;

                $wellFitnessArray[$artikul]['price'] = $price;
                $wellFitnessArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('wellFitness', $wellFitnessArray, 9, false);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://hasttings.ru/diler/login/');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "site_user_login=ksg&site_user_password=qwertydas123&remember_me=1&apply=Войти");
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIEJAR, Yii::getAlias('@www').'/cookie.txt');
            curl_exec($ch);

            curl_setopt($ch, CURLOPT_COOKIEFILE, Yii::getAlias('@www').'/cookie.txt');
            curl_setopt($ch, CURLOPT_URL, 'https://hasttings.ru/diler/fast.yml');
            $result = curl_exec($ch);

            $hasttings = simplexml_load_string($result);
            $hasttingsArray = [];

            foreach($hasttings->shop->offers->offer as $offer) {
                if ($offer->available == 'true') {
                    $available = 10;
                } else {
                    $available = 0;
                }

                $artikul = (string) $offer->marking;
                $price = (int) $offer->price;

                $hasttingsArray[$artikul]['price'] = $price;
                $hasttingsArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('hasttings', $hasttingsArray, 3, false);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $unixfit = simplexml_load_file('http://unixfit.ru/bitrix/catalog_export/catalog.php');
            $unixfitArray = [];

            foreach($unixfit->shop->offers->offer as $offer) {
                $available = (int) $offer->quantity;
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $unixfitArray[$artikul]['price'] = $price;
                $unixfitArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('unixfit', $unixfitArray, 7, false);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $neotren = simplexml_load_file('https://neotren.ru/yml.php');
            $neotrenArray = [];

            foreach($neotren->shop->offers->offer as $offer) {
                $offerXml = $offer->asXml();

                if (strstr($offerXml, '<param name="status"/>')) {
                    $available = 0;
                } else {
                    preg_match('#<param name="status">([^<]+)</param>#siU', $offerXml, $match);
                    $available = $match[1];
                }

                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $neotrenArray[$artikul]['price'] = $price;
                $neotrenArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('neotren', $neotrenArray, 5, false);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $fitnessBoutique = simplexml_load_file('https://www.fitness-boutique.ru/system/files/dealer/stock_fitness-boutique_xml_0.xml');
            $fitnessBoutiqueArray = [];

            foreach($fitnessBoutique->shop->offers->offer as $offer) {
                $available = 10;
                $artikul = (string) $offer->param;
                $price = (int) $offer->price;

                $fitnessBoutiqueArray[$artikul]['price'] = $price;
                $fitnessBoutiqueArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('fitnessBoutique', $fitnessBoutiqueArray, 8, true);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $soulfit = simplexml_load_file('http://soulfitnes.ru/wp-content/plugins/saphali-export-yml2/export.yml');
            $soulfitArray = [];

            foreach($soulfit->shop->offers->offer as $offer) {
                $available = (string) $offer->attributes()->{'available'};
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $soulfitArray[$artikul]['price'] = $price;
                $soulfitArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('soulfit', $soulfitArray, 4);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $stark = simplexml_load_file('http://xn----dtbgdaodln4afhyim1m.com/price/?sklad=moscow');
            $starkArray = [];

            foreach($stark->products->product as $product) {
                foreach($product->offers->offer as $offer) {
                    $available = (string) $offer->amount;
                    $artikul = (string) $offer->id;
                    $price = (int) $product->price;

                    $starkArray[$artikul]['price'] = $price;
                    $starkArray[$artikul]['available'] = $available;
                }
            }

            $xml->loadXml('stark', $starkArray, 6);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $svenson = simplexml_load_file('https://jorgen-svensson.com/ru/data.yml');
            $svensonArray = [];

            foreach($svenson->shop->offers->offer as $offer) {
                $available = (string) $offer->param;
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $svensonArray[$artikul]['price'] = $price;
                $svensonArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('jorgen-svensson', $svensonArray, 2);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $driada = simplexml_load_file('http://driada-sport.ru/data/files/XML_prise_s.xml');
            $driadaArray = [];

            foreach($driada->price as $offer) {
                $values = $offer->attributes();
                $available = (string) $values['Остаток'];
                $artikul = (string) $values['Артикул'];
                $price = (int) $values['Цена'];

                $driadaArray[$artikul]['price'] = $price;
                $driadaArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('driada', $driadaArray, 1);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }

        UML::doIt();
    }
}