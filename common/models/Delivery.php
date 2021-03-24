<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "present".
 */
class Delivery extends \common\models\base\Delivery
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

    public static function getDeliveryPrice($price) {
        $deliveries = Delivery::find()->asArray()->all();
        $moscowPrice = 0;
        $otherPrice = 0;

        foreach($deliveries as $delivery) {
            if ($price >= (int) $delivery['gte']  && $price < (int) $delivery['lt']) {
                $moscowPrice = $delivery['moscow_price'];
                $otherPrice = $delivery['other_price'];
                break;
            }
        }

        return [$moscowPrice, $otherPrice];
    }
}
