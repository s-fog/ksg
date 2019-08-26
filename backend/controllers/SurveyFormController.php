<?php

namespace backend\controllers;

use yii\filters\AccessControl;

/**
* This is the class for controller "SurveyFormController".
*/
class SurveyFormController extends \backend\controllers\base\SurveyFormController
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
