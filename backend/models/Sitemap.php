<?php

namespace backend\models;

use common\models\Category;
use common\models\News;
use common\models\Product;
use common\models\Textpage;
use DOMDocument;
use Yii;
use yii\helpers\Url;


class Sitemap extends Model
{
    public static function doIt()
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $xmlns = $dom->createAttribute('xmlns');
        $xmlns->value = "http://www.sitemaps.org/schemas/sitemap/0.9";
        $urlset->appendChild($xmlns);

        foreach(Textpage::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('url', $_SERVER['HTTP_HOST'].htmlspecialchars($model->backendUrl));
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        $newsPageUrl = Textpage::findOne(13)->backendUrl;

        foreach(News::find()->orderBy(['created_at' => SORT_DESC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('url', $_SERVER['HTTP_HOST'].$newsPageUrl.'/'.$model->alias);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        foreach(Category::find()->where(['active' => 1])->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('url', $_SERVER['HTTP_HOST'].$model->getUrl(true));
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        foreach(Product::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('url', $_SERVER['HTTP_HOST'].'/product/'.$model->alias);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        $dom->appendChild($urlset);
        var_dump($dom->save('../sitemap.xml'));
    }

       /* $dom = new DOMDocument('1.0', 'utf-8');
        $yml_catalog = $dom->createElement('yml_catalog');
        $date = $dom->createAttribute('date');
        $date->value = date("Y-m-d H:i");
        $yml_catalog->appendChild($date);
        $shop = $dom->createElement('shop');

        $name = $dom->createElement('name', 'KSG');
        $shop->appendChild($name);

        $company = $dom->createElement('company', 'KSG Shop');
        $shop->appendChild($company);

        $url = $dom->createElement('url', 'https://dev2.ksg.ru');
        $shop->appendChild($url);

        $currencies = $dom->createElement('currencies');
        $currency = $dom->createElement('currency');
        $id = $dom->createAttribute('id');
        $id->value = "RUR";
        $currency->appendChild($id);
        $rate = $dom->createAttribute('rate');
        $rate->value = 1;
        $currency->appendChild($rate);
        $currencies->appendChild($currency);
        $shop->appendChild($currencies);

        $categories = $dom->createElement('categories');
        $level0Categories = Category::find()->where(['type' => 0, 'parent_id' => 0])->orderBy('name')->all();

        foreach($level0Categories as $level0Category) {
            $categoryItem = $dom->createElement('category', $level0Category->name);
            $id = $dom->createAttribute('id');
            $id->value = $level0Category->id;
            $categoryItem->appendChild($id);
            $categories->appendChild($categoryItem);

            foreach(Category::find()
                ->where(['type' => 0, 'parent_id' => $level0Category->id])
                ->orderBy('name')
                ->all() as $level1Category) {
                $categoryItem = $dom->createElement('category', $level1Category->name);
                $id = $dom->createAttribute('id');
                $id->value = $level1Category->id;
                $categoryItem->appendChild($id);
                $parentId = $dom->createAttribute('parentId');
                $parentId->value = $level1Category->parent_id;
                $categoryItem->appendChild($parentId);
                $categories->appendChild($categoryItem);

                foreach(Category::find()
                    ->where(['type' => 0, 'parent_id' => $level1Category->id])
                    ->orderBy('name')
                    ->all() as $level2Category) {
                    $categoryItem = $dom->createElement('category', $level2Category->name);
                    $id = $dom->createAttribute('id');
                    $id->value = $level2Category->id;
                    $categoryItem->appendChild($id);
                    $parentId = $dom->createAttribute('parentId');
                    $parentId->value = $level2Category->parent_id;
                    $categoryItem->appendChild($parentId);
                    $categories->appendChild($categoryItem);
                }
            }

        }
        $shop->appendChild($categories);

        $cpa = $dom->createElement('cpa', 0);
        $shop->appendChild($cpa);

        $offers = $dom->createElement('offers');

        $products = Product::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        foreach($products as $product) {
            $imageModel = $product->images[0];
            $filename = explode('.', basename($imageModel->image));
            $link = Url::to(['catalog/view', 'alias' => $product->alias]);
            $variant = ProductParam::find()->where(['product_id' => $product->id])->orderBy(['id' => SORT_ASC])->one();
            //$available = $product->available;

            $offer = $dom->createElement('offer');
            $id = $dom->createAttribute('id');
            $id->value = $product->id;
            $offer->appendChild($id);
            $available = $dom->createAttribute('available');
            $available->value = "true";
            $offer->appendChild($available);
            ///////////////////////////////////////////////////////////////////////////////////////////
            $https = ($_SERVER['HTTP_HOST'] == 'dev2.ksg.ru') ? 'https://' : 'http://';
            $url = $dom->createElement('url', $link);
            $offer->appendChild($url);
            ///////////////////////////////////////////////////////////////////////////////////////////

            $price = $dom->createElement('price', $product->price);
            $offer->appendChild($price);

            if (!empty($product->price_old)) {
                $oldprice = $dom->createElement('oldprice', $product->price_old);
                $offer->appendChild($oldprice);
            }

            $currencyId = $dom->createElement('currencyId', "RUR");
            $offer->appendChild($currencyId);

            $categoryId = $dom->createElement('categoryId', $product->parent_id);
            $offer->appendChild($categoryId);

            $picture = $dom->createElement('picture', $https.$_SERVER['HTTP_HOST']."/images/thumbs/{$filename[0]}-770-553.{$filename[1]}");
            $offer->appendChild($picture);

            $pickup = $dom->createElement('pickup', "true");
            $offer->appendChild($pickup);

            $name = $dom->createElement('name', htmlspecialchars($product->name));
            $offer->appendChild($name);

            $description = $dom->createElement('description');
            $description->appendChild($dom->createCDATASection($product->description));
            $offer->appendChild($description);

            $vendorCode = $dom->createElement('vendorCode', $product->code	);
            $offer->appendChild($vendorCode);

            $available = $dom->createElement('available', 'true');
            $offer->appendChild($available);

            if (!empty($variant->params)) {
                foreach($variant->params as $paramName => $paramValue) {
                    $param = $dom->createElement('param', $paramValue);
                    $name = $dom->createAttribute('name');
                    $name->value = $paramName;
                    $param->appendChild($name);
                    $offer->appendChild($param);
                }
            }

            $offers->appendChild($offer);
        }

        $shop->appendChild($offers);
        $yml_catalog->appendChild($shop);
        $dom->appendChild($yml_catalog);
        var_dump($dom->save('../yml.xml'));
    }*/
}
