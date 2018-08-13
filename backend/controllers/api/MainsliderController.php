<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "MainsliderController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class MainsliderController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Mainslider';
}
