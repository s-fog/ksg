<?php

namespace common\models;

use Yii;
use \common\models\base\FilterFeature as BaseFilterFeature;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "filter_feature".
 */
class FilterFeature extends BaseFilterFeature
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
            ]
        );
    }

    public function getFilterFeatureValues() {
        return $this->hasMany(FilterFeatureValue::className(), ['filter_feature_id' => 'id'])->orderBy(['name' => SORT_ASC]);
    }
}
