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


class CatalogController extends Controller
{
    public function actionIndex($alias = '', $alias2 = '', $alias3 = '', $alias4 = '', $alias5 = '')
    {
        $cookies = Yii::$app->request->cookies;
        $cookies->readOnly = false;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'filter_showed',
            'value' => '1',
            'expire' => strtotime('+1 hour'),
        ]));

        City::setCity();

        if (Category::isAliasesEmpty([$alias, $alias2, $alias3, $alias4, $alias5])) {
            $model = Textpage::findOne(1);

            return $this->render('outer', [
                'model' => $model
            ]);
        } else {
            $model = Category::getCurrentCategory([$alias, $alias2, $alias3, $alias4, $alias5]);

            if (!$model) {
                throw new NotFoundHttpException;
            }

            $wheres = $model->getWheres();
            $innerIdsWhere = $wheres[0];
            $otherIdsWhere = $wheres[1];
            $tags = [];
            $brandCategories = [];
            $years = [];
            $brandsSerial = [];

            $orderBy = array_merge([ProductParam::tableName().'.available' => SORT_DESC], Sort::getOrderBy($model, $_GET));
            $productQuery = Product::find()
                ->joinWith(['productParams'])
                ->with(['brand', 'images'])
                ->orderBy($orderBy);

            if ($model->type == 0) {//Если категория
                $tags = Category::find()
                    ->with(['parent0', 'productHasCategories'])
                    ->where(['parent_id' => $model->id, 'type' => 1, 'active' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $years = Category::find()
                    ->with(['parent0', 'productHasCategories'])
                    ->where(['parent_id' => $model->id, 'type' => 4, 'active' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $brandCategories = Category::find()
                    ->with(['parent0', 'brand', 'productHasCategories'])
                    ->where(['parent_id' => $model->id, 'type' => 2, 'active' => 1])
                    ->orderBy(['name' => SORT_ASC])
                    ->all();

                $productQuery->orWhere($otherIdsWhere)
                    ->orWhere($innerIdsWhere);
            } else {//Если всё остальное
                if (in_array($model->type, [1, 2, 4])) {
                    $parent = Category::findOne(['id' => $model->parent_id]);

                    $tags = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 1, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 4, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brandCategories = Category::find()
                        ->with(['parent0', 'brand', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 2, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                    $brandsSerial = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => ArrayHelper::getColumn($brandCategories, 'id'), 'type' => 3, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                }

                if ($model->type == 3) {// Если серия бренда
                    $parentBrand = Category::findOne(['id' => $model->parent_id]);
                    $parent = Category::findOne(['id' => $parentBrand->parent_id]);

                    $tags = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 1, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 4, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brandCategories = Category::find()
                        ->with(['parent0', 'brand', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 2, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                    $brandsSerial = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => ArrayHelper::getColumn($brandCategories, 'id'), 'type' => 3, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                }
                ////////////////////////////////////////////////////////////
                $andWhereTags = [Product::tableName().'.id' => ''];
                $idsTags = ArrayHelper::getColumn(ProductHasCategory::findAll(['category_id' => $model->id]), 'product_id');

                if (!empty($idsTags)) {
                    $andWhereTags = [Product::tableName().'.id' => $idsTags];
                }
                ////////////////////////////////////////////////////////////
                $productQuery->where($andWhereTags)
                    ->orWhere($otherIdsWhere);
            }
            /////////////////////////////////////////////////////////
            $bHeader = $model->seo_h1 . ' по брендам';
            $bHeader2 = $model->seo_h1;

            if (in_array($model->type, [1, 2, 4])) {
                $parent = Category::findOne($model->parent_id);
                $bHeader = $parent->seo_h1 . ' по брендам';
                $bHeader2 = $parent->seo_h1;
            }

            if ($model->type == 3) {
                $parent = Category::findOne($model->parent_id);
                $parent2 = Category::findOne($parent->parent_id);
                $bHeader = $parent2->seo_h1 . ' по брендам';
                $bHeader2 = $parent2->seo_h1;
            }
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

            $pages = new \yii\data\Pagination([
                'totalCount' => $allProductsQuery->count(),
                'defaultPageSize' => $defaultPageSize,
                'pageSizeParam' => 'per_page',
                'forcePageParam' => false,
                'pageSizeLimit' => 200
            ]);

            $products = $productQuery->limit($pages->limit)->offset($pages->offset)->all();

            return $this->render('index', [
                'model' => $model,
                'products' => $products,
                'pages' => $pages,
                'tags' => $tags,
                'brandCategories' => $brandCategories,
                'years' => $years,
                'brandsSerial' => $brandsSerial,
                'bHeader' => $bHeader,
                'bHeader2' => $bHeader2,
                'minPrice' => $minPriceAvailable,
                'maxPrice' => $maxPriceAvailable,
                'filterBrands' => $filterBrands,
                'inCategories' => $inCategories,
            ]);
        }

    }

    public function actionView($alias)
    {
        City::setCity();

        $model = Product::find()
            ->with([
                'productParams',
                'brand',
                'images',
                'parent',
                'features',
                'features.featurevalues'])
            ->where(['alias' => $alias])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        if (isset($_POST['reload']) && $_POST['reload'] == 1) {
            $currentVariant = ProductParam::find()
                ->where(['product_id' => $model->id])
                ->andWhere(['params' => $_POST['paramsv']])
                ->one();
        } else {
            $currentVariant = $model->productParams[0];
        }

        $brand = Brand::findOne($model->brand_id);
        $variants = $model->productParams;
        $adviser = Adviser::findOne($model->adviser_id);
        $features = [];

        foreach($model->features as $index => $feature) {
            $features[$index]['feature'] = $feature;

            foreach($feature->featurevalues as $i => $fv) {
                $features[$index]['values'][$i]['name'] = $fv->name;
                $features[$index]['values'][$i]['value'] = $fv->value;
            }
        }
        ///////////////////////////////////////////////////////////////////////
        $selects = [];
        $i = 0;
        $currentParams = [];

        if ($currentVariant->params) {
            foreach($currentVariant->params as $p) {
                $name = explode(' -> ', $p)[0];
                $value = explode(' -> ', $p)[1];
                $currentParams[$name] = $value;
            }
        }

        foreach($variants as $v) {
            if ($v->params) {
                foreach($v->params as $param) {
                    $name = explode(' -> ', $param)[0];
                    $value = explode(' -> ', $param)[1];

                    if (!isset($selects[$name]) || !Product::in_array_in($value, $selects, $name)) {
                        $selects[$name][$i]['value'] = $value;

                        if ($currentParams[$name] == $value) {
                            $selects[$name][$i]['active'] = true;
                        } else {
                            $selects[$name][$i]['active'] = false;
                        }

                        $i++;
                    }
                }
            }
        }

        ///////////////////////////////////////////////////////////////////////

        if (isset($_POST['reload']) && $_POST['reload'] == 1) {
            $productView = $this->renderPartial('_product', [
                'model' => $model,
                'brand' => $brand,
                'currentVariant' => $currentVariant,
                'variants' => $variants,
                'selects' => $selects,
                'adviser' => $adviser,
                'features' => $features,
                'pswHeight' => $_POST['pswHeight'],
            ]);

            $addToCartView = $this->renderPartial('_addToCart', [
                'model' => $model,
                'brand' => $brand,
                'currentVariant' => $currentVariant,
                'variants' => $variants,
                'selects' => $selects,
                'adviser' => $adviser,
                'features' => $features,
            ]);

            return json_encode([$productView, $addToCartView]);
        } else {
            $model->popular++;
            $model->save();
            $parent = $model->parent;
            ////////////////////////////////////////////////////////////////////////////////////////////
            $accessories = [];
            $ids = [];

            if (!empty($parent->aksses_ids)) {
                foreach(json_decode($parent->aksses_ids) as $value) {
                    $ids[] = (int) $value;
                }

                $accessories = Product::find()
                    ->with([
                        'productParams',
                        'brand',
                        'images',
                        'parent'])
                    ->where(['parent_id' => $ids])
                    ->orderBy(new Expression('rand()'))
                    ->limit(15)
                    ->all();
            }
            ////////////////////////////////////////////////////////////////////////////////////////////
            $similar = [];

            for($i = 15; $i < 100; $i = $i + 5) {
                $priceFrom = (int) $model->price * ((100 - $i) / 100);
                $priceTo = (int) $model->price * ((100 + $i) / 100);
                $similarQuery = Product::find()
                    ->with([
                        'productParams',
                        'brand',
                        'images',
                        'parent'])
                    ->where(['parent_id' => $parent->id])
                    ->andWhere("id <> {$model->id}")
                    ->andWhere("price > $priceFrom  AND price < $priceTo")
                    ->orderBy(new Expression('rand()'))
                    ->limit(9);

                if ($similarQuery->count() >= 3) {
                    $similar = $similarQuery->all();
                    break;
                }
            }
            ////////////////////////////////////////////////////////////////////////////////////////////

            return $this->render('view', [
                'model' => $model,
                'brand' => $brand,
                'currentVariant' => $currentVariant,
                'variants' => $variants,
                'selects' => $selects,
                'adviser' => $adviser,
                'features' => $features,
                'accessories' => $accessories,
                'similar' => $similar,
            ]);
        }

    }

    function in_multiarray( $e, $a )
    {
        $t = sizeof( $a ) - 1;
        $b = 0;
        while($b <= $t)
        {
            if( isset( $a[ $b ] ) )
            {
                if( $a[ $b ] == $e )
                    return true;
                else
                    if( is_array( $a[ $b ] ) )
                        if( in_multiarray( $e, ( $a[ $b ] ) ) )
                            return true;
            }

            $b++;
        }

        return false;
    }
}
