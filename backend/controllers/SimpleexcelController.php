<?php

namespace backend\controllers;

use backend\models\SimpleExcel;
use backend\models\UML;
use common\models\Subscribe;
use common\models\SubscribeSearch;
use dmstr\bootstrap\Tabs;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
* This is the class for controller "SubscribeController".
*/
class SimpleexcelController extends \yii\web\Controller
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
        $model = new SimpleExcel();

        if ($model->load($_POST)) {
            $file = UploadedFile::getInstance($model, 'file');
            $success = false;

            if ($file->saveAs($_SERVER['DOCUMENT_ROOT'] . '/www/simple-xls.xlsx', false)) {
                $success = $model->doIt();
            }

            Yii::$app->queue_default->push(new UML());

            return $this->render('index', [//
                'model' => $model,
                'success' => $success,
                'load' => true
            ]);
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}
