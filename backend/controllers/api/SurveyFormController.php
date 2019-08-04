<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "SurveyFormController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SurveyFormController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\SurveyForm';
}
