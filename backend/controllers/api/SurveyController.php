<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "SurveyController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SurveyController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Survey';
}
