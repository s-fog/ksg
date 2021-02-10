<?php

namespace backend\models;

use common\models\Product;
use yii\queue\JobInterface;


class ProductCaching extends Model implements JobInterface
{
    public $product_id;

    public function execute($queue) {
        $product = Product::findOne($this->product_id);
        $product->getMainFeatures(true);
        $product->getCompilationCategoryIds(true);
    }
}
