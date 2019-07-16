<?php

namespace backend\controllers;

use backend\models\ChangerForm;
use common\models\Changer;
use common\models\ChangerSearch;
use dmstr\bootstrap\Tabs;
use HttpException;
use yii\helpers\Url;
use yii\web\Controller;

/**
* This is the class for controller "ChangerController".
*/
class ChangerController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        $searchModel  = new ChangerSearch;
        $changerForm  = new ChangerForm;
        $dataProvider = $searchModel->search($_GET);

        if ($changerForm->load($_POST)) {
            $changerForm->changePrices();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'changerForm' => $changerForm,
        ]);
    }
}
