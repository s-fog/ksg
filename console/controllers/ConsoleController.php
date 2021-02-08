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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://victoryfit.ru/wp-content/uploads/market-exporter/ym-export.yml');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        $victoryFit = simplexml_load_string($result);
        $victoryFitArray = [];

        foreach($victoryFit->shop->offers->offer as $offer) {
            $available = (string) $offer->attributes()->{'available'};
            $artikul = (string) $offer->vendorCode;
            $price = (int) $offer->price;

            $unixfitArray[$artikul]['price'] = $price;
            $unixfitArray[$artikul]['available'] = $available;
        }
        var_dump($victoryFitArray);die();

        $xml->loadXml('VictoryFit', $victoryFitArray, 24, false);
    }
}