<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "CallbackController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CallbackController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Callback';
}
