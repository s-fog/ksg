<?php

namespace console\controllers;

use common\models\Category;
use common\models\Product;
use frontend\models\Xml;
use sfog\image\Image as Simage;
use Yii;
use yii\console\Controller;

class ConsoleController extends Controller {

    public function actionServer() {
        var_dump($_SERVER);
    }

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

    public function actionGetRedirects() {
        $categories = Category::find()->all();

        foreach($categories as $category) {
            $url = '/';

            if (in_array($category->type, [1, 2, 4])) {
                $url .= Category::findOne(['id' => $category->parent_id])->alias.'/'.$category->alias;
            } else if ($category->type === 3) {
                $parentBrand = Category::findOne(['id' => $category->parent_id]);

                $url .= Category::findOne(['id' => $parentBrand->parent_id])->alias.'/'.$category->alias;
            } else {
                $url .= $category->alias;
            }

            echo 'Redirect 301 '.$category->url.' '.$url."\n";
        }
        die();
    }

    public function actionTest() {
        $xml = new Xml();
        $fitnessBoutique = simplexml_load_file('https://www.fitness-boutique.ru/system/files/dealer/stock_fitness-boutique_xml.xml');
        $fitnessBoutiqueArray = [];

        foreach($fitnessBoutique->shop->offers->offer as $offer) {
            $available = (string) $offer->attributes()->{'available'};
            $artikul = (string) $offer->param;
            $price = (int) $offer->price;

            $fitnessBoutiqueArray[$artikul]['price'] = $price;
            $fitnessBoutiqueArray[$artikul]['available'] = $available;
        }

        $xml->loadXml('fitnessBoutique', $fitnessBoutiqueArray, 8, true);
    }
}