<?php

namespace backend\controllers;

use common\models\Feature;
use common\models\FeatureValue;
use common\models\Image;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
* This is the class for controller "TextpageController".
*/
class SortController extends Controller
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

    public function actionFvUpdate() {
        if ($items = $_POST['items']) {
            $items = str_replace(['[', ']'], ['', ''], $items);
            
            foreach(explode(',', $items) as $order => $id) {
                $model = FeatureValue::findOne($id);
                $model->sort_order = $order;
                $model->save();
            }
        }
    }

    public function actionFeatureUpdate() {
        if ($items = $_POST['items']) {
            $items = str_replace(['[', ']'], ['', ''], $items);

            foreach(explode(',', $items) as $order => $id) {
                $model = Feature::findOne($id);
                $model->sort_order = $order;
                $model->save();
            }
        }
    }

    public function actionImageUpdate() {
        if ($items = $_POST['items']) {
            $items = str_replace(['[', ']'], ['', ''], $items);

            foreach(explode(',', $items) as $order => $id) {
                $model = Image::findOne($id);
                $model->sort_order = $order;
                $model->save();
            }
        }
    }
}
