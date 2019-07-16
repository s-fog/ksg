<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\models;


use common\models\Changer;
use common\models\Product;
use common\models\Supplier;
use Yii;

class ChangerForm extends \yii\db\ActiveRecord
{
    public $supplier_id;
    public $brand_id;
    public $price_from;
    public $price_to;
    public $percent;
    public $count;

    public function rules()
    {
        return [
            [['supplier_id', 'brand_id', 'percent', 'price_from', 'price_to'], 'required'],
            [['supplier_id', 'brand_id', 'count', 'percent'], 'integer'],
            [['price_from', 'price_to'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'percent' => 'Процент(например, 1 или 101)',
            'supplier_id' => 'Поставщик',
            'brand_id' => 'Бренд',
        ];
    }

    public function changePrices() {
        $products = Product::find()
            ->joinWith(['supplier', 'brand'])
            ->andWhere(['>=', 'updated_at', time() - 172800])
            ->andWhere(['>=', 'price', $this->price_from])
            ->andWhere(['<=', 'price', $this->price_to]);

        if ($this->supplier_id !== 0) {
            $products->andWhere(['supplier' => $this->supplier_id]);
        }

        if ($this->brand_id !== 0) {
            $products->andWhere(['brand_id' => $this->brand_id]);
        }

        $k = 1 + ($this->percent / 100);

        foreach($products->all() as $product) {
            $oldPrice = $product->price;
            $product->price = ceil($product->price * $k);
            
            if ($product->save()) {
                $changer = new Changer();
                $changer->product_id = $product->id;
                $changer->old_price = (float) $oldPrice;
                $changer->new_price = (float) $product->price;
                $changer->percent = (float) $this->percent;
                $changer->supplier_id = $this->supplier_id;
                $changer->brand_id = $this->brand_id;
                
                if ($changer->save()) {
                    $this->count++;
                }
            }
        }
    }
}
