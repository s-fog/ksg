<?php

namespace backend\models;

use common\models\Catalog;
use common\models\Category;
use common\models\Product;
use common\models\ProductParam;
use DOMDocument;
use Yii;
use yii\helpers\Url;


class UML extends Model
{
    public static function doIt() {
        $dom = new DOMDocument('1.0', 'utf-8');
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
            $variant = ProductParam::find()->where(['product_id' => $product->id])->orderBy(['id' => SORT_ASC])->one();
            $availableProduct = ($product->available) ? 'true' : 'false';

            $offer = $dom->createElement('offer');
            $id = $dom->createAttribute('id');
            $id->value = $product->id;
            $offer->appendChild($id);
            $available = $dom->createAttribute('available');
            $available->value = $availableProduct;
            $offer->appendChild($available);
            ///////////////////////////////////////////////////////////////////////////////////////////
            $https = ($_SERVER['HTTP_HOST'] == 'dev2.ksg.ru') ? 'https://' : 'http://';
            $url = $dom->createElement('url', $https.$_SERVER['HTTP_HOST'].'/product/'.$product->alias);
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

            $vendorCode = $dom->createElement('vendorCode', $product->variant->artikul);
            $offer->appendChild($vendorCode);

            $vendor = $dom->createElement('vendor', $product->brand->name);
            $offer->appendChild($vendor);

            if (!empty($variant->params)) {
                foreach($variant->params as $value) {
                    $par = implode(' -> ', $value);
                    $param = $dom->createElement('param', $par[1]);
                    $name = $dom->createAttribute('name');
                    $name->value = $par[0];
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
    }
}
