<?php

namespace console\controllers;

use common\models\Product;
use sfog\image\Image as Simage;
use Yii;
use yii\console\Controller;

class ConsoleController extends Controller {

    public function actionGenerateMoreThumbs() {
        $simage = new SImage;

        foreach(Product::find()->select('id')
                    ->with(['images' => function ($q) {
            $q->select(['image', 'product_id']);
        }])->asArray()->all() as $product) {
            foreach($product['images'] as $image) {
                $simage->addMoreThumbs($image['image'], ['270x230']);
            }
        }
    }
}