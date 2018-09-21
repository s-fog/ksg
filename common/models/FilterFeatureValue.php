<?php

namespace common\models;

use Yii;
use \common\models\base\FilterFeatureValue as BaseFilterFeatureValue;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "filter_feature_value".
 */
class FilterFeatureValue extends BaseFilterFeatureValue
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
