<?php

namespace backend\models;

use common\models\Product;
use common\models\ProductParam;
use common\models\Supplier;
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
}