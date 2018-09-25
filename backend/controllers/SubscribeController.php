<?php

namespace backend\controllers;

use common\models\Subscribe;
use common\models\SubscribeSearch;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;

/**
* This is the class for controller "SubscribeController".
*/
class SubscribeController extends \backend\controllers\base\SubscribeController
{
    public function actionIndex()
    {
        $searchModel  = new SubscribeSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;


        if (isset($_GET['csv']) && $_GET['csv'] == 1) {
            $ff = [];
            $filename = $_SERVER['DOCUMENT_ROOT'].'/export-csv.csv';
            file_put_contents($filename, '');
            $f = fopen($filename, 'w');
            fputs($f, chr(0xEF) . chr(0xBB) . chr(0xBF));
            $headers = [
                'Время',
                'E-mail',
            ];
            fputcsv($f, $headers, ';');

            foreach (Subscribe::find()->all() as $model) {
                $line = [];
                $line[] = $model->created_at;
                $line[] = $model->email;
                $ff[] = $line;
                fputcsv($f, $line, ';');
            }

            header("Content-Type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Content-Length: ".filesize($filename));
            header("Content-Disposition: attachment; filename=export-csv.csv");
            ob_clean();
            flush();
            readfile($filename);
            die();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
