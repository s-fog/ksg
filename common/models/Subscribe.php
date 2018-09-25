<?php

namespace common\models;

use Yii;
use \common\models\base\Subscribe as BaseSubscribe;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subscribe".
 */
class Subscribe extends BaseSubscribe
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
