<?php

namespace frontend\models;

use common\models\Brand;
use common\models\FilterFeatureValue;
use common\models\Product;
use common\models\ProductHasFilterFeatureValue;
use Yii;
use yii\helpers\ArrayHelper;

class Filter
{
    public static function filter($query, $get) {
        $filterFeaturesValue = [];

        if (isset($get['priceFrom'])) {
            $priceFrom = intval(str_replace(' ', '', $get['priceFrom']));
            $query->andWhere(['>=', 'price', $priceFrom]);
        }

        if (isset($get['priceTo'])) {
            $priceTo = intval(str_replace(' ', '', $get['priceTo']));
            $query->andWhere(['<=', 'price', $priceTo]);
        }

        $featuresOn = false;

        foreach($get as $index => $value) {
            preg_match('#^feature(.+)_(.+)$#siU', $index, $match);

            if (!empty($match)) {
                $featuresOn = true;
                $a1 = (int) $match[1];//$filterFeature->id
                $a2 = (int) $match[2];//$filterFeatureValue->id
                $filterFeaturesValue[] = $a2;
            }

            if ($index == 'cats') {
                $query->andWhere([Product::tableName().'.parent_id' => explode(',', $value)]);
            }
        }

        if ($featuresOn) {
            $fQuery = ProductHasFilterFeatureValue::find()
                ->select('product_id, COUNT( * ) AS c')
                ->where(['filter_feature_value_id' => $filterFeaturesValue])
                ->groupBy('product_id')
                ->having(['c' => count($filterFeaturesValue)]);
            /*$fQuery = ProductHasFilterFeatureValue::find()
                ->select('product_id')
                ->where(['filter_feature_value_id' => $filterFeaturesValue]);*/
            $query->andWhere([Product::tableName().'.id' => ArrayHelper::getColumn($fQuery->asArray()->all(), 'product_id')]);
        }

        if (isset($get['brands'])) {
            $query->joinWith(['brand'])
                ->andWhere([Brand::tableName().'.id' => $get['brands']]);
        }

        return $query;
    }
}