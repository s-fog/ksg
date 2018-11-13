<?php

namespace frontend\models;

use common\models\Product;
use common\models\ProductParam;
use common\models\Supplier;
use Yii;
use yii\base\Model;

class Xml extends Model
{
    public function loadXml($supplierName, $data, $supplierId, $notAvailableIfExists = false) {
        $str = "type;artikul;message\r\n";
        $currentProducts = Product::findAll(['supplier' => $supplierId]);
        $currentArray = [];

        foreach($currentProducts as $product) {
            $productParams = $product->getParams();

            foreach($productParams as $pp) {
                if (!array_key_exists(trim($pp->artikul), $data)) {
                    $currentArray[] = trim($pp->artikul);

                    if ($notAvailableIfExists) {
                        $pp->available = 0;
                        $pp->save();
                    }
                }
            }
        }

        foreach($data as $artikul => $item) {
            $artikul = trim($artikul);

            if ($productParam = ProductParam::findOne(['artikul' => $artikul])) {
                $message = [];
                $product = Product::findOne($productParam->product_id);

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
                ) {
                    $available = 0;
                } else if (is_numeric($item['available'])) {
                    $available = (int) $item['available'];
                } else if (
                    $item['available'] == 'более 10'
                    ||
                    $item['available'] == 'true'
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
                        $str .= "attention;$artikul; Есть цена ниже у ".Supplier::findOne($supplierId)->name."\r\n";
                    }
                }

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

        if (!empty($currentArray)) {
            $str .= "error;".implode(',', $currentArray).";Этих артикулов нет у поставщика\r\n";
        }

        file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/www/logs/$supplierName.log", $str);
    }
}