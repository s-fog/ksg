<?php

namespace backend\models;

use common\models\Catalog;
use common\models\Category;
use common\models\Present;
use common\models\Product;
use common\models\ProductParam;
use DOMDocument;
use Yii;
use yii\console\Exception;
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

        $url = $dom->createElement('url', 'https://ksg.ru');
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
        $categoriesDisallowIds = [];

        foreach($level0Categories as $level0Category) {
            if ($level0Category->disallow_xml == 1) {
                $categoriesDisallowIds[] = $level0Category->id;
                break;
            }

            $categoryItem = $dom->createElement('category', $level0Category->name);
            $id = $dom->createAttribute('id');
            $id->value = $level0Category->id;
            $categoryItem->appendChild($id);
            $categories->appendChild($categoryItem);

            foreach(Category::find()
                ->where(['type' => 0, 'parent_id' => $level0Category->id])
                ->orderBy('name')
                ->all() as $level1Category) {
                if ($level1Category->disallow_xml == 1) {
                    $categoriesDisallowIds[] = $level1Category->id;
                    break;
                }

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
                    if ($level2Category->disallow_xml == 1) {
                        $categoriesDisallowIds[] = $level2Category->id;
                        break;
                    }

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
            ->where(['NOT IN', 'category_id', $categoriesDisallowIds])
            ->andWhere(['disallow_xml' => 0])
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
            $url = $dom->createElement('url', $https.$_SERVER['HTTP_HOST'].$product->url);
            $offer->appendChild($url);
            ///////////////////////////////////////////////////////////////////////////////////////////

            $price = $dom->createElement('price', $product->price);
            $offer->appendChild($price);

            if (!empty($product->price_old)) {
                $oldprice = $dom->createElement('oldprice', (int) $product->price_old);
                $offer->appendChild($oldprice);
            }

            if (!empty($product->mmodel)) {
                $mmodel = $dom->createElement('model', htmlspecialchars($product->mmodel));
                $offer->appendChild($mmodel);
            }

            $sales_notes = $dom->createElement('sales_notes', 'Спортивный гипермаркет. Доставка. Сборка. Гарантия');
            $offer->appendChild($sales_notes);

            $currencyId = $dom->createElement('currencyId', "RUR");
            $offer->appendChild($currencyId);

            $categoryId = $dom->createElement('categoryId', $product->parent_id);
            $offer->appendChild($categoryId);

            $picture = $dom->createElement('picture', $https.$_SERVER['HTTP_HOST']."/images/thumbs/{$filename[0]}-770-553.{$filename[1]}");
            $offer->appendChild($picture);

            $pickup = $dom->createElement('pickup', "false");
            $offer->appendChild($pickup);

            $name = $dom->createElement('name', htmlspecialchars($product->name));
            $offer->appendChild($name);

            $description = $dom->createElement('description');
            $description->appendChild($dom->createCDATASection($product->description));
            $offer->appendChild($description);

            $vendorCode = $dom->createElement('vendorCode', htmlspecialchars($product->variant->artikul));
            $offer->appendChild($vendorCode);

            $vendor = $dom->createElement('vendor', htmlspecialchars($product->brand->name));
            $offer->appendChild($vendor);

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

        if ($presents = Present::find()->all()) {
            $promos = $dom->createElement('promos');

            foreach($presents as $present) {
                $productsInThisRange = Product::find()
                    ->joinWith('category')
                    ->andWhere(['>=', 'price', $present->min_price])
                    ->andWhere(['<=', 'price', $present->max_price])
                    ->andWhere(['category.active' => 1])
                    ->all();

                if ($productsInThisRange) {
                    $artikuls = explode(',', $present->product_artikul);
                    $promo = $dom->createElement('promo');

                    $id = $dom->createAttribute('id');
                    $id->value = 'PromoGift'.$present->id;
                    $promo->appendChild($id);

                    $type = $dom->createAttribute('type');
                    $type->value = 'gift with purchase';
                    $promo->appendChild($type);

                    $promoDescription = $dom->createElement('description', 'Подарок!');
                    $promo->appendChild($promoDescription);

                    $purchase = $dom->createElement('purchase');
                    foreach($productsInThisRange as $p) {
                        $pr = $dom->createElement('product');
                        $offer_id = $dom->createAttribute('offer-id');
                        $offer_id->value = $p->id;
                        $pr->appendChild($offer_id);
                        $purchase->appendChild($pr);
                    }
                    $promo->appendChild($purchase);

                    $promo_gifts = $dom->createElement('promo-gifts');
                    foreach($artikuls as $artikul) {
                        if ($presentP = ProductParam::findOne(['artikul' => $artikul])->product) {
                            $promo_gift = $dom->createElement('promo-gift');
                            $offer_id = $dom->createAttribute('offer-id');
                            $offer_id->value = $presentP->id;
                            $promo_gift->appendChild($offer_id);
                            $promo_gifts->appendChild($promo_gift);
                        };
                    }
                    $promo->appendChild($promo_gifts);

                    $promos->appendChild($promo);
                }
            }

            $shop->appendChild($promos);
        }

        $yml_catalog->appendChild($shop);
        $dom->appendChild($yml_catalog);
        return $dom->save(Yii::getAlias('@www').'/yml.xml');
    }
}
