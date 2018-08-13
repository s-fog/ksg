<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "TextpageController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TextpageController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Textpage';
}
