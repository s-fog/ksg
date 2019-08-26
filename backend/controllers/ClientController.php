<?php

namespace backend\controllers;

use yii\filters\AccessControl;

/**
* This is the class for controller "ClientController".
*/
class ClientController extends \backend\controllers\base\ClientController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
        ];
    }


}
