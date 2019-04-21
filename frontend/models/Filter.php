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
        $filterBrandsIds = [];

        if (isset($get['priceFrom']) && isset($get['priceTo'])) {
            $priceFrom = (int) str_replace(' ', '', $get['priceFrom']);
            $priceTo = (int) str_replace(' ', '', $get['priceTo']);
            unset($get['priceFrom']);
            unset($get['priceTo']);
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
                    ->where(['IN', 'filter_feature_value_id', $filterFeaturesValue])
                    ->groupBy('product_id')
                    ->having(['c' => count($filterFeaturesValue)]);
                $query->andWhere([Product::tableName().'.id' => ArrayHelper::getColumn($fQuery->asArray()->all(), 'product_id')]);
            }


        } else {
            $priceFrom = 0;
            $priceTo = 100000000;
        }

        if (isset($get['brand'])) {
            if ($get['brand'] != 0) {
                $query->joinWith(['brand'])
                    ->andWhere([Brand::tableName().'.id' => $get['brand']]);
            }
        }

        $query->andWhere(['>=', 'price', $priceFrom])
            ->andWhere(['<=', 'price', $priceTo]);
        
        return $query;
    }
}