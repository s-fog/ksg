<?php

namespace backend\models;

use common\models\Product;
use common\models\ProductParam;
use Yii;


class SimpleExcel extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Файл(.xlsx)',
        ];
    }

    public function doIt()
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($_SERVER['DOCUMENT_ROOT'] . '/www/simple-xls.xlsx');
        $activeSheet = $spreadsheet->getActiveSheet();
        $cells = $activeSheet->getCellCollection();
        $cols = ['A', 'B', 'C'];
        $result = [];
        $changedCount = 0;

        for ($row = 1; $row <= $cells->getHighestRow(); $row++) {
            $j = 0;

            while (isset($cols[$j])) {
                $value = $activeSheet->getCell($cols[$j] . $row)->getValue();
                $result[$row][$j] = $value;
                $j++;
            }
        }

        foreach ($result as $row => $cells) {
            $artikul = $cells[0];
            $price = $cells[1];
            $available = $cells[2];

            if (!empty($artikul)) {
                $price = (int) str_replace([' ', 'р', 'p', ',', '.'], ['', '', '', '', ''], $price);

                if (!empty($available)) {
                    if ($available == 'В наличии') {
                        $available = 10;
                    } else if ($available == 'ДЕМО') {
                        $available = 10;
                    } else if ($available == 'В наличии') {
                        $available = 10;
                    } else if ($available == 'Уточняйте') {
                        $available = 10;
                    } else if (preg_match('#([^-]+)-шт#siU', $available, $match)) {
                        $available = $match[1];
                    } else if ($available == 'нет') {
                        $available = 0;
                    } else if ($available == 'есть') {
                        $available = 10;
                    } else if ($available == 'ожидается') {
                        $available = 0;
                    } else if (preg_match('#Менее ([^-]+) шт.#siU', $available, $match)) {
                        $available = $match[1];
                    } else if ((int)$available < 0) {
                        $available = 0;
                    } else if ((int)$available > 1) {
                        $available = 0;
                    } else {
                        $available = 0;
                    }
                } else {
                    $available = 0;
                }


                if ($pp = ProductParam::findOne(['artikul' => $artikul])) {
                    $product = Product::findOne($pp->product_id);
                    $product->price = $price;
                    $product->updated_at = time();
                    $product->save();

                    $pp->available = $available;
                    $pp->save();

                    $changedCount++;
                }
            }
        }

        UML::doIt();

        return $changedCount;
    }
}
