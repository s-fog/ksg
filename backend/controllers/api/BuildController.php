<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "BuildController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class BuildController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Build';
}
