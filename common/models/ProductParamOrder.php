<?php

namespace common\models;

use Yii;
use \common\models\base\ProductParam as BaseProductParam;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_param".
 */
class ProductParamOrder extends BaseProductParam
{
    public $quantity;

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
            [['artikul'], 'required'],
            [['quantity'], 'integer'],
        ];
    }
}
