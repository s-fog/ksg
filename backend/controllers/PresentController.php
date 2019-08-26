<?php

namespace backend\controllers;

use yii\filters\AccessControl;

/**
* This is the class for controller "PresentController".
*/
class PresentController extends \backend\controllers\base\PresentController
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
