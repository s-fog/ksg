<?php

namespace backend\controllers;

use common\models\Feature;
use common\models\FeatureValue;
use common\models\Image;
use common\models\Product;
use common\models\ProductParam;
use yii\helpers\Url;
use yii\web\Controller;

/**
* This is the class for controller "TextpageController".
*/
class LogController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($name) {
        $array = [];
        $str = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/www/logs/$name.log");

        foreach(explode("\r\n", $str) as $index => $item) {
            if ($index != 0 && !empty($item)) {
                $arr = explode(';', $item);
                $array[$index]['type'] = $arr[0];
                $arts = [];

                foreach(explode(',', $arr[1]) as $art) {
                    if ($pp = ProductParam::findOne(['artikul' => $art])) {
                        if ($pp->product) {
                            $link = Url::to(['product/update', 'id' => $pp->product->id]);
                            $arts[] = '<a href="'.$link.'" target="_blank">'.$art.'</a>';
                        } else {
                            $arts[] = $art;
                        }
                    } else {
                        $arts[] = $art;
                    }
                }

                $array[$index]['artikul'] = implode(',', $arts);
                $array[$index]['message'] = $arr[2];
            }
        }

        uasort($array, function ($a, $b) {
            return ($a['type'] > $b['type']);
        });

        return $this->render('view', [
            'name' => $name,
            'array' => $array,
        ]);
    }
}
