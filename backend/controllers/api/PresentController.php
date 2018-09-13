<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "PresentController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class PresentController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Present';
}
