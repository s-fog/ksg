<?php

namespace console\controllers;

use common\models\Category;
use common\models\Product;
use sfog\image\Image as Simage;
use Yii;
use yii\console\Controller;

class ProductController extends Controller {

    public function actionCacheProductMainFeatures() {
        $products = Product::find()->all();

        foreach($products as $product) {
            $product->getMainFeatures(true);
        }
    }

    public function actionCacheProductCompilations() {
        $products = Product::find()->all();

        foreach($products as $product) {
            $product->getCompilationCategoryIds(true);
        }
    }
}