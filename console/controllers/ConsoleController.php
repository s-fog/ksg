<?php

namespace console\controllers;

use backend\controllers\XmlController;
use backend\models\CategoryCaching;
use backend\models\UML;
use backend\models\Xml;
use common\models\Category;
use common\models\Product;
use common\models\ProductParam;
use Yii;
use yii\console\Controller;
use yii\imagine\Image;

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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.wellfitness.ru/index.php?route=feed/yandex_market');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $wellFitness = simplexml_load_string($result);
        $wellFitnessArray = [];

        foreach($wellFitness->shop->offers->offer as $offer) {
            $available = (string) $offer->attributes()->{'available'};
            $artikul = (string) $offer->vendorCode;
            $price = (int) $offer->price;

            $wellFitnessArray[$artikul]['price'] = $price;
            $wellFitnessArray[$artikul]['available'] = $available;
        }


        var_dump($wellFitnessArray);die();
    }

    public function actionXmlImport() {
        Xml::doIt();
    }

    public function actionUml() {
        UML::doIt();
    }

    public function actionClearEmptyElementsInDb() {
        $productParams = ProductParam::find()->with('product')->all();

        foreach($productParams as $pp) {
            if ($pp->product === null) {
                $pp->delete();
            }
        }
    }
}