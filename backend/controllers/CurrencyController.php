<?php

namespace backend\controllers;

use yii\filters\AccessControl;

/**
* This is the class for controller "CurrencyController".
*/
class CurrencyController extends \backend\controllers\base\CurrencyController
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
}
