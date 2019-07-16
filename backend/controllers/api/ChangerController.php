<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "ChangerController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ChangerController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Changer';
}
