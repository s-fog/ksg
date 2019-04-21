<?php

namespace frontend\models;

use common\models\Brand;
use common\models\FilterFeatureValue;
use common\models\Product;
use common\models\ProductHasFilterFeatureValue;
use Yii;

class Filter
{
    public static function filter($query, $get) {
        $filterFeaturesValue = [];
        $filterBrandsIds = [];

        if (isset($get['priceFrom']) && isset($get['priceTo'])) {
            $priceFrom = (int) str_replace(' ', '', $_GET['priceFrom']);
            $priceTo = (int) str_replace(' ', '', $_GET['priceTo']);
            
            foreach($get as $index => $value) {
                ////////////////////////////////////////////////////////////////////
                preg_match('#^feature(.+)_(.+)$#siU', $index, $match);

                if (!empty($match)) {
                    $a1 = (int) $match[1];//$filterFeature->id
                    $a2 = (int) $match[2];//$filterFeatureValue->id
                    $query->joinWith(['productHasFilterFeatureValue']);
                    $query->andWhere([ProductHasFilterFeatureValue::tableName().'.filter_feature_value_id' => $a2]);
                    //$filterFeaturesValue[] = ProductHasFilterFeatureValue::tableName().'.filter_feature_value_id = '.$a2;
                }
                ////////////////////////////////////////////////////////////////////
                if ($index == 'cats') {
                    $query->andWhere([Product::tableName().'.parent_id' => explode(',', $value)]);
                }
            }
        } else {
            $priceFrom = 0;
            $priceTo = 100000000;
        }

        /*if (!empty($filterFeaturesValue)) {
            $query->joinWith(['productHasFilterFeatureValue'])
                ->andWhere(implode(' AND ', $filterFeaturesValue));
        }*/

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