<?php

namespace backend\controllers;

use backend\models\SimpleExcel;
use common\models\Subscribe;
use common\models\SubscribeSearch;
use dmstr\bootstrap\Tabs;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
* This is the class for controller "SubscribeController".
*/
class SimpleexcelController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new SimpleExcel();

        if ($model->load($_POST)) {
            $file = UploadedFile::getInstance($model, 'file');
            $success = false;

            if ($file->saveAs($_SERVER['DOCUMENT_ROOT'] . '/www/simple-xls.xlsx', false)) {
                $success = $model->doIt();
            }

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
