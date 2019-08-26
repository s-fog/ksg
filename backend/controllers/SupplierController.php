<?php

namespace backend\controllers;

use yii\filters\AccessControl;

/**
* This is the class for controller "SupplierController".
*/
class SupplierController extends \backend\controllers\base\SupplierController
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
