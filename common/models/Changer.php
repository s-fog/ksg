<?php

namespace common\models;

use Yii;
use \common\models\base\Changer as BaseChanger;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "changer".
 */
class Changer extends BaseChanger
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
            [['product_id', 'supplier_id', 'brand_id'], 'integer'],
            [['old_price', 'new_price', 'percent'], 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'product_id' => 'Товар',
            'old_price' => 'Была цена',
            'new_price' => 'Стала цена',
            'percent' => 'Процент',
            'supplier_id' => 'Поставщик',
            'brand_id' => 'Бренд',
        ];
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getSupplier() {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}
