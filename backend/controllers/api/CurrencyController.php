<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "CurrencyController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CurrencyController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Currency';
}
