<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "WarantyController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class WarantyController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Waranty';
}
