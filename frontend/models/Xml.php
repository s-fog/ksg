<?php

namespace frontend\models;

use common\models\Product;
use common\models\ProductParam;
use Yii;
use yii\base\Model;

class Xml extends Model
{
    public function loadXml($supplierName, $data, $supplierId) {
        $str = "type;artikul;message\r\n";
        $currentProducts = Product::findAll(['supplier' => $supplierId]);
        $currentArray = [];

        foreach($currentProducts as $product) {
            $productParams = $product->getParams();

            foreach($productParams as $pp) {
                if (!array_key_exists($pp->artikul, $data)) {
                    $currentArray[] = $pp->artikul;
                }
            }
        }

        foreach($data as $artikul => $item) {
            if ($productParam = ProductParam::findOne(['artikul' => $artikul])) {
                $message = [];
                $product = Product::findOne($productParam->product_id);

                if (
                    $item['available'] === 'Отсутствует'
                    ||
                    $item['available'] === 'Ожидается'
                    ||
                    (is_numeric($item['available']) && $item['available'] == 0)
                    ||
                    ((int) $item['available'] < 0)
                ) {
                    $available = 0;
                } else if (is_numeric($item['available'])) {
                    $available = (int) $item['available'];
                } else if ($item['available'] == 'более 10') {
                    $available = 10;
                } else {
                    $available = 10;
                }

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