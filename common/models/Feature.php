<?php

namespace common\models;

use Yii;
use \common\models\base\Feature as BaseFeature;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "feature".
 */
class Feature extends BaseFeature
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
        return [
            [['category_id', 'product_id', 'sort_order'], 'integer'],
            [['header'], 'string', 'max' => 255]
        ];
    }

    public function getFeaturevalues() {
        return FeatureValue::find()
            ->where(['feature_id' => $this->id])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }
}
