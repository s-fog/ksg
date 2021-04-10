<?php

namespace backend\models;

use common\models\Product;
use common\models\ProductParam;
use common\models\Supplier;
use Exception;
use Yii;
use yii\base\BaseObject;
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
        $currentProducts = Product::find()->where(['supplier' => $this->supplierId])->all();
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
                $productParam = ProductParam::findOne(['artikul' => $artikul]);

                if ($productParam !== null) {
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
        $suppliers = Supplier::find()->indexBy('id')->all();

        Xml::xmlYandex([$suppliers[24], $suppliers[9], $suppliers[13], $suppliers[27], $suppliers[7], $suppliers[8], $suppliers[4], $suppliers[6]]);
        ////////////////////////////////////////////////////////////////////////////////


        Yii::$app->queue_default->push(new UML());
    }

    public static function xmlYandex($suppliers) {
        foreach($suppliers as $supplier) {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $supplier->xml_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);

                $data = simplexml_load_string($result);
                $dataArray = [];

                foreach($data->shop->offers->offer as $offer) {
                    $available = (string) $offer->attributes()->{'available'};
                    $artikul = (string) $offer->vendorCode;
                    $price = (int) $offer->price;

                    $dataArray[$artikul]['price'] = $price;
                    $dataArray[$artikul]['available'] = $available;
                }

                Yii::$app->queue_default->push(new Xml([
                    'data' => $dataArray,
                    'supplierId' => $supplier->id,
                    'notAvailableIfExists' => false,
                ]));
            } catch(Exception $e) {
                Xml::sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
            }
        }
    }
}