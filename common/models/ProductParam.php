<?php

namespace common\models;

use Yii;
use \common\models\base\ProductParam as BaseProductParam;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_param".
 */
class ProductParam extends BaseProductParam
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
            [['artikul', 'available', 'image_number'], 'required'],
            [['available', 'product_id', 'sort_order', 'image_number'], 'integer'],
            [['params'], 'safe'],
            [['artikul'], 'string', 'max' => 255],
            [['artikul'], 'unique']
        ];
    }

    public function afterFind()
    {
        if (!empty($this->params)) {
            $this->params = explode('|', $this->params);
        }

        parent::afterFind(); // TODO: Change the autogenerated stub
    }

    public function beforeValidate()
    {
        if (!empty($this->params)) {
            $this->params = implode('|', $this->params);
        }

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getParamsv() {
        return empty($this->params) ? '' : implode('|', $this->params);
    }
}
