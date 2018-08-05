<?php

namespace common\models;

use Yii;
use \common\models\base\Callback as BaseCallback;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "callback".
 */
class Callback extends BaseCallback
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
