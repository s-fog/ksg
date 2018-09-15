<?php

namespace common\models;

use Yii;
use \common\models\base\Waranty as BaseWaranty;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "waranty".
 */
class Waranty extends BaseWaranty
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
            [['category_id', 'text', 'prices'], 'required'],
            [['seo_description', 'text'], 'string'],
            [['sort_order', 'category_id'], 'integer'],
            [['name', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['prices'], 'safe'],
            [['category_id'], 'unique']
        ];
    }
    public function thisPrice($price) {
        foreach(json_decode($this->prices, true) as $prices) {
            if ($price >= $prices['min_price'] && $price < $prices['max_price']) {
                return $prices['price'];
            }
        }

        return false;
    }
}
