<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "ParamController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ParamController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Param';
}
