<?php

namespace backend\models;

use common\models\Category;
use common\models\Product;
use Yii;
use yii\queue\JobInterface;


class CategoryCaching extends Model implements JobInterface
{
    public $category_id;

    public function execute($queue) {
        $category = Category::findOne($this->category_id);
        $category->getCategoriesNestedToThisCategoryIds(true);

        foreach($category->getProducts()->all() as $product) {
            Yii::$app->queue_default->push(new ProductCaching([
                'product_id' => $product->id
            ]));
        }
    }
}
