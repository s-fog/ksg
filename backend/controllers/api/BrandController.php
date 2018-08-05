<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "BrandController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class BrandController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Brand';
}
