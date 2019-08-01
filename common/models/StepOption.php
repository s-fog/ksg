<?php

namespace common\models;

use Yii;
use \common\models\base\StepOption as BaseStepOption;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "step_option".
 */
class StepOption extends BaseStepOption
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
                [['sort_order'], 'default', 'value' => 0]
            ]
        );
    }
}
