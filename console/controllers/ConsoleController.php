<?php

namespace console\controllers;

use backend\controllers\XmlController;
use backend\models\CategoryCaching;
use backend\models\Xml;
use common\models\Category;
use common\models\Product;
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
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, 'https://hasttings.ru/diler/login/');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "site_user_login=ksg&site_user_password=qwertydas123&remember_me=1&apply=Войти");
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, Yii::getAlias('@www').'/cookie.txt');
        curl_exec($ch);

        curl_setopt($ch, CURLOPT_COOKIEFILE, Yii::getAlias('@www').'/cookie.txt');
        curl_setopt($ch, CURLOPT_URL, 'https://hasttings.ru/diler/fast.yml');
        $result = curl_exec($ch);

        $hasttings = simplexml_load_string($result);
        $hasttingsArray = [];

        foreach($hasttings->shop->offers->offer as $offer) {
            if ($offer->available == 'true') {
                $available = 10;
            } else {
                $available = 0;
            }

            $artikul = (string) $offer->marking;
            $price = (int) $offer->price;

            $hasttingsArray[$artikul]['price'] = $price;
            $hasttingsArray[$artikul]['available'] = $available;
        }

        var_dump($hasttingsArray);die();

        Yii::$app->queue_default->push(new Xml([
            'supplierName' => 'hasttings',
            'data' => $hasttingsArray,
            'supplierId' => 3,
            'notAvailableIfExists' => false,
        ]));
    }

    public function actionXmlImport() {
        Xml::doIt();
    }
}