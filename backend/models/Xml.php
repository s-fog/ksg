<?php

namespace backend\models;

use common\models\Product;
use common\models\ProductParam;
use common\models\Supplier;
use Exception;
use Yii;
use yii\base\Model;
use yii\queue\JobInterface;

class Xml extends Model implements JobInterface
{
    public $supplierName,
        $data,
        $supplierId,
        $notAvailableIfExists = false;

    public function execute($queue) {
        $folder = Yii::getAlias('@backend')."/web/logs";

        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $str = "type;artikul;message\r\n";
        $currentProducts = Product::findAll(['supplier' => $this->supplierId]);
        $currentArray = [];
        $supplier = Supplier::findOne($this->supplierId);

        foreach($currentProducts as $product) {
            $productParams = $product->getParams();

            foreach($productParams as $pp) {
                $ppArtikul = trim($pp->artikul);

                if (!empty($ppArtikul)) {
                    if (!array_key_exists($ppArtikul, $this->data)) {
                        $currentArray[] = $ppArtikul;

                        if ($this->notAvailableIfExists) {
                            $pp->available = 0;
                        }

                        $pp->save();
                    }
                }
            }
        }

        foreach($this->data as $artikul => $item) {
            $artikul = trim($artikul);

            if (!empty($artikul)) {
                if ($productParam = ProductParam::findOne(['artikul' => $artikul])) {
                    $message = [];
                    $product = Product::findOne($productParam->product_id);
                    if (!$product) continue;
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
                        stristr($item['available'], 'Под заказ') !== false
                        ||
                        stristr($item['available'], 'жидается') !== false
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

                    if ($product->supplier == $this->supplierId) {
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
                        /*if ($product->price > $item['price']) {
                            $str .= "attention;$artikul; Есть цена ниже у {$supplier->name}\r\n";
                            $this->sendMessage("Для $artikul есть цена ниже у {$supplier->name}", '');
                        }*/

                        if ($available > 0 && $productParam->available == 0) {
                            $str .= "attention;$artikul; У {$supplier->name} товар есть в наличии\r\n";
                            $this->sendMessage("Для $artikul у {$supplier->name} товар есть в наличии", '');
                        }
                    }

                    if ($product->price < $old_price) {
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

        file_put_contents("$folder/$this->supplierName.log", $str);
    }

    public static function sendMessage($subject, $message) {
        Yii::$app->mailer
            ->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setTextBody($message)
            ->setSubject($subject)
            ->send();
    }

    public static function doIt() {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://victoryfit.ru/wp-content/uploads/market-exporter/ym-export.yml');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);

            $victoryFit = simplexml_load_string($result);
            $victoryFitArray = [];

            foreach($victoryFit->shop->offers->offer as $offer) {
                $available = (string) $offer->attributes()->{'available'};
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $victoryFitArray[$artikul]['price'] = $price;
                $victoryFitArray[$artikul]['available'] = $available;
            }

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'VictoryFit',
                'data' => $victoryFitArray,
                'supplierId' => 24,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
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

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'wellFitness',
                'data' => $wellFitnessArray,
                'supplierId' => 9,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
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

                $artikul = str_replace('  ', ' ', (string) $offer->marking);
                $price = (int) $offer->price;

                $hasttingsArray[$artikul]['price'] = $price;
                $hasttingsArray[$artikul]['available'] = $available;
            }

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'hasttings',
                'data' => $hasttingsArray,
                'supplierId' => 3,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $unixfit = simplexml_load_file('http://unixfit.ru/bitrix/catalog_export/catalog.php');
            $unixfitArray = [];

            foreach($unixfit->shop->offers->offer as $offer) {
                $available = (string) $offer['available'] === 'false' ? 0 : 10;
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $unixfitArray[$artikul]['price'] = $price;
                $unixfitArray[$artikul]['available'] = $available;
            }

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'unixfit',
                'data' => $unixfitArray,
                'supplierId' => 7,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
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

            var_dump($neotrenArray);

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'neotren',
                'data' => $neotrenArray,
                'supplierId' => 5,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $fitnessBoutique = simplexml_load_file('https://www.fitness-boutique.ru/system/files/dealer/stock_fitness-boutique_xml.xml');
            $fitnessBoutiqueArray = [];

            foreach($fitnessBoutique->shop->offers->offer as $offer) {
                $available = (string) $offer->attributes()->{'available'};
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $fitnessBoutiqueArray[$artikul]['price'] = $price;
                $fitnessBoutiqueArray[$artikul]['available'] = $available;
            }

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'fitnessBoutique',
                'data' => $fitnessBoutiqueArray,
                'supplierId' => 8,
                'notAvailableIfExists' => true,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
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

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'soulfit',
                'data' => $soulfitArray,
                'supplierId' => 4,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $stark = simplexml_load_file('http://xn----dtbgdaodln4afhyim1m.com/price/?sklad=moscow');
            $starkArray = [];

            foreach($stark->shop->offers->offer as $offer) {
                $available = (string) $offer->attributes()->{'available'};
                $artikul = (string) $offer->articul;
                $price = (int) $offer->price;

                $starkArray[$artikul]['price'] = $price;
                $starkArray[$artikul]['available'] = $available;
            }

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'stark',
                'data' => $starkArray,
                'supplierId' => 6,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        /*try {
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
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }*/
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

            Yii::$app->queue_default->push(new Xml([
                'supplierName' => 'driada',
                'data' => $driadaArray,
                'supplierId' => 2,
                'notAvailableIfExists' => false,
            ]));
        } catch(Exception $e) {
            Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }

        Yii::$app->queue_default->push(new UML());
    }
}