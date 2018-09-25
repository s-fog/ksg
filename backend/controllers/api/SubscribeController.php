<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "SubscribeController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SubscribeController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Subscribe';
}
