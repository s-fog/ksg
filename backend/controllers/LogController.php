<?php

namespace backend\controllers;

use common\models\Feature;
use common\models\FeatureValue;
use common\models\Image;
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
                $array[$index]['artikul'] = $arr[1];
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
