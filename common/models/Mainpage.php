<?php

namespace common\models;

use Yii;
use \common\models\base\Mainpage as BaseMainpage;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mainpage".
 */
class Mainpage extends BaseMainpage
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
