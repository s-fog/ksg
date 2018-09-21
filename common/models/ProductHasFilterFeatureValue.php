<?php

namespace common\models;

use Yii;
use \common\models\base\ProductHasFilterFeatureValue as BaseProductHasFilterFeatureValue;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_has_filter_feature_value".
 */
class ProductHasFilterFeatureValue extends BaseProductHasFilterFeatureValue
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
