<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "AdviserController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class AdviserController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Adviser';
}
