<?php
namespace frontend\controllers;

use common\models\Adviser;
use common\models\Brand;
use common\models\Category;
use common\models\FeatureValue;
use common\models\Product;
use common\models\ProductHasCategory;
use common\models\ProductHasFilterFeatureValue;
use common\models\ProductParam;
use common\models\Textpage;
use frontend\models\City;
use frontend\models\Filter;
use frontend\models\Pagination;
use frontend\models\Sort;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class BrandController extends Controller
{
    public function actionView($alias)
    {
        City::setCity();
        $model = Brand::findOne(['alias' => $alias]);

        if (!$model) {
            throw new NotFoundHttpException;
        }

        $orderBy = array_merge([ProductParam::tableName().'.available' => SORT_DESC], Sort::getOrderBy($model, $_GET));
        $productQuery = $model->getProducts()
            ->orderBy($orderBy);
        /////////////////////////////////////////////////////////
        $defaultPageSize = 40;
        $countAllProducts = $productQuery->count();
        Product::check404($countAllProducts, $defaultPageSize);
        $minPrice = 100000000;
        $maxPrice = 0;
        $minPriceAvailable = 100000000;
        $maxPriceAvailable = 0;

        $allProductsQuery = clone $productQuery;
        $allProducts = $allProductsQuery->asArray()->all();
        $filterBrands = ArrayHelper::map($allProducts, 'brand_id', 'brand');
        ArrayHelper::multisort($filterBrands, ['name'], [SORT_ASC]);

        $inCategories = [];
        foreach($allProducts as $product) {
            if (!isset($inCategories[$product['parent_id']])) {
                $inCategories[$product['parent_id']] = Category::find()
                    ->where(['id' => $product['parent_id']])
                    ->one();
            }
        }
        ArrayHelper::multisort($inCategories, ['name'], [SORT_ASC]);

        $productQuery = Filter::filter($productQuery, $_GET);

        /////////////////////////////////////////////////////////////////////////
        $allProductsQuery = clone $productQuery;
        $allProducts = $allProductsQuery->asArray()->all();

        foreach($allProducts as $product) {
            $available = false;

            foreach($product['productParams'] as $pp) {
                if ($pp['available'] > 0) {
                    $available = true;
                }
            }

            if ($available) {
                if ($product['price'] < $minPriceAvailable) {
                    $minPriceAvailable = $product['price'];
                }

                if ($product['price'] > $maxPriceAvailable) {
                    $maxPriceAvailable = $product['price'];
                }
            }

            if ($product['price'] < $minPrice) {
                $minPrice = $product['price'];
            }

            if ($product['price'] > $maxPrice) {
                $maxPrice = $product['price'];
            }
        }

        if ($minPrice == 100000000){
            $minPrice = 0;
        }

        if ($minPriceAvailable == 100000000){
            $minPriceAvailable = 0;
        }

        if ($maxPrice == 0){
            $maxPrice = 100000000;
        }

        if ($maxPriceAvailable == 0){
            $maxPriceAvailable = 100000000;
        }

        $pages = new \yii\data\Pagination([
            'totalCount' => $allProductsQuery->count(),
            'defaultPageSize' => $defaultPageSize,
            'pageSizeParam' => 'per_page',
            'forcePageParam' => false,
            'pageSizeLimit' => 200
        ]);

        $products = $productQuery->limit($pages->limit)->offset($pages->offset)->all();

        $filterFeatures = [];
        if (isset($_GET['cats'])) {
            if (count(explode(',', $_GET['cats'])) == 1) {
                $filterFeatures = $model->getFilterFeatures($_GET['cats']);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'products' => $products,
            'pages' => $pages,
            'minPrice' => $minPriceAvailable,
            'maxPrice' => $maxPriceAvailable,
            'filterBrands' => $filterBrands,
            'inCategories' => $inCategories,
            'filterFeatures' => $filterFeatures,
        ]);
    }
}
