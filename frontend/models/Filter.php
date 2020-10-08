<?php

namespace frontend\models;

use common\models\Brand;
use common\models\Category;
use common\models\FilterFeature;
use common\models\FilterFeatureValue;
use common\models\Product;
use common\models\ProductHasFilterFeatureValue;
use Yii;
use yii\helpers\ArrayHelper;

class Filter
{
    public static function filter($query, $get) {
        $filterFeaturesValue = [];

        if (isset($get['priceFrom']) && !empty($get['priceFrom'])) {
            $priceFrom = intval(str_replace(' ', '', $get['priceFrom']));
            $query->andWhere(['>=', 'price', $priceFrom]);
        }

        if (isset($get['priceTo']) && !empty($get['priceTo'])) {
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
                $filterFeaturesValue[$a1][] = $a2;
            }

            if ($index == 'cats') {
                $query->andWhere([Product::tableName().'.parent_id' => explode(',', $value)]);
            }
        }

        if ($featuresOn) {
            foreach($filterFeaturesValue as $featureId => $featureValues) {
                $query->leftJoin('`'.ProductHasFilterFeatureValue::tableName().'` as `fv'.$featureId.'`',
                    '`fv'.$featureId.'`.`product_id` = `product`.`id`')
                    ->andWhere(['`fv'.$featureId.'`.`filter_feature_value_id`' => $featureValues]);
            }
            /*$query->leftJoin(ProductHasFilterFeatureValue::tableName(),
                ProductHasFilterFeatureValue::tableName().'.product_id = product.id')
                //->andWhere([ProductHasFilterFeatureValue::tableName().'.filter_feature_value_id' => $finalFilterFeaturesValue])
                ->groupBy('product.id')
                ->having(['COUNT(`product`.`id`)' => count($filterFeaturesValue)]);

            foreach($filterFeaturesValue as $featureId => $featureValues) {
                if (count($featureValues) == 1) {
                    $query->andWhere(['`'.ProductHasFilterFeatureValue::tableName().'`.`filter_feature_value_id`' => $featureValues]);
                } else {
                    foreach($featureValues as $index => $fv) {
                        $featureValues[$index] = '`'.ProductHasFilterFeatureValue::tableName().'`.`filter_feature_value_id` = '.$fv;
                    }

                    $query->andWhere(implode(' OR ', $featureValues));
                }
            }*/
        }

        if (isset($get['brands'])) {
            $query->joinWith(['brand'])
                ->andWhere([Brand::tableName().'.id' => $get['brands']]);
        }

        return [$get, $query];
    }
}