<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "SupplierController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SupplierController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Supplier';
}
