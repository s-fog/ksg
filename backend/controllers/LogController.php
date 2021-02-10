<?php

namespace backend\controllers;

use common\models\Feature;
use common\models\FeatureValue;
use common\models\Image;
use common\models\Product;
use common\models\ProductParam;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
* This is the class for controller "TextpageController".
*/
class LogController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($name) {
        $array = [];
        $folder = Yii::getAlias('@backend').'/web/logs';
        $str = file_get_contents("$folder/$name.log");

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
