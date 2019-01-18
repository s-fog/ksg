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
use frontend\models\Pagination;
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
        $cache = Yii::$app->cache;

        City::setCity();

        if (Category::isAliasesEmpty([$alias, $alias2, $alias3, $alias4, $alias5])) {
            $model = Textpage::findOne(1);

            return $this->render('outer', [
                'model' => $model
            ]);
        } else {
            $model = Category::getCurrentCategory([$alias, $alias2, $alias3, $alias4, $alias5]);

            /*if (!$lpua = $cache->get('last_product_updated_at')) {
                $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM product ORDER BY updated_at DESC']);
                $cache->set('last_product_updated_at', 1, null, $dependency);
            }

            if (!isset($_GET['page']) && !isset($_GET['per_page']) && $model->type == 0 && $cache->get('products-cat'.$model->id) && $lpua) {
                $products = $cache->get('products-cat'.$model->id);
                $pages = $cache->get('pages-cat'.$model->id);
                $tags = $cache->get('tags-cat'.$model->id);
                $brands = $cache->get('brands-cat'.$model->id);
                $years = $cache->get('years-cat'.$model->id);
                $brandsSerial = $cache->get('brandsSerial-cat'.$model->id);
                $bHeader = $cache->get('bHeader-cat'.$model->id);
                $bHeader2 = $cache->get('bHeader2-cat'.$model->id);
                $minPrice = $cache->get('minPrice-cat'.$model->id);
                $maxPrice = $cache->get('maxPrice-cat'.$model->id);
                $filterBrands = $cache->get('filterBrands-cat'.$model->id);

                return $this->render('index', [
                    'model' => $model,
                    'products' => $products,
                    'pages' => $pages,
                    'tags' => $tags,
                    'brands' => $brands,
                    'years' => $years,
                    'brandsSerial' => $brandsSerial,
                    'bHeader' => $bHeader,
                    'bHeader2' => $bHeader2,
                    'minPrice' => $minPrice,
                    'maxPrice' => $maxPrice,
                    'filterBrands' => $filterBrands,
                ]);
            }*/

            $innerIdsWhere = [];

            if (!$model) {
                throw new NotFoundHttpException;
            }

            /////////////////////////////////////////////////////////
            $innerIds = $model->getInnerIds();

            if (!empty($innerIds)) {
                $innerIdsWhere = ['parent_id' => $innerIds];
            }
            /////////////////////////////////////////////////////////
            $otherIds = [];
            $otherIdsWhere = [];

            if ($model->type != 2) {
                foreach ($innerIds as $category_id) {
                    foreach (ProductHasCategory::findAll(['category_id' => $category_id]) as $productHasCategory) {
                        $otherIds[] = $productHasCategory->product_id;
                    }
                }
            } else {
                foreach (Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 3])
                    ->orWhere(['id' => $model->id])
                    ->all() as $category) {
                    foreach (ProductHasCategory::findAll(['category_id' => $category->id]) as $productHasCategory) {
                        $otherIds[] = $productHasCategory->product_id;
                    }
                }
            }


            if (!empty($otherIds)) {
                $otherIdsWhere = ['id' => $otherIds];
            }
            /////////////////////////////////////////////////////////
            $orderBy = [];

            if ($model->level === 3 || in_array($model->type, [1, 2, 3, 4])) {
                if (isset($_GET['sort'])) {
                    $sort = explode('_', $_GET['sort']);

                    if ($sort[0] == 'price') {
                        if ($sort[1] == 'desc') {
                            $orderBy = [$sort[0] => SORT_DESC];
                        } else if ($sort[1] == 'asc') {
                            $orderBy = [$sort[0] => SORT_ASC];
                        }
                    } else if ($sort[0] == 'popular') {
                        if ($sort[1] == 'desc') {
                            $orderBy = [$sort[0] => SORT_DESC];
                        } else if ($sort[1] == 'asc') {
                            $orderBy = [$sort[0] => SORT_ASC];
                        }
                    }
                } else {
                    $orderBy = ['price' => SORT_ASC];
                }
            } else {
                if (isset($_GET['sort'])) {
                    $sort = explode('_', $_GET['sort']);

                    if ($sort[0] == 'price') {
                        if ($sort[1] == 'desc') {
                            $orderBy = [$sort[0] => SORT_DESC];
                        } else if ($sort[1] == 'asc') {
                            $orderBy = [$sort[0] => SORT_ASC];
                        }
                    }
                } else {
                    $orderBy = ['popular' => SORT_DESC];
                }
            }
            /////////////////////////////////////////////////////////
            $tags = [];
            $brands = [];
            $years = [];
            $brandsSerial = [];

            if ($model->type == 0) {//Если категория
                $tags = Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 1, 'active' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $years = Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 4, 'active' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $brands = Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 2, 'active' => 1])
                    ->orderBy(['name' => SORT_ASC])
                    ->all();

                $allproducts = Product::find()
                    ->orWhere($otherIdsWhere)
                    ->orWhere($innerIdsWhere)
                    ->orderBy($orderBy)->all();
            } else {//Если всё остальное
                if (in_array($model->type, [1, 2, 4])) {
                    $parent = Category::findOne(['id' => $model->parent_id]);

                    $tags = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 1, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 4, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brands = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 2, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();

                    foreach ($brands as $brand) {
                        foreach (Category::find()
                            ->where(['parent_id' => $brand->id, 'type' => 3])
                            ->orderBy(['name' => SORT_DESC])
                            ->all() as $brandSerial) {
                            $brandsSerial[] = $brandSerial;
                        }
                    }
                }

                if ($model->type == 3) {// Если серия бренда
                    $parentBrand = Category::findOne(['id' => $model->parent_id]);
                    $parent = Category::findOne(['id' => $parentBrand->parent_id]);

                    $tags = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 1, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 4, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brands = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 2, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();

                    foreach ($brands as $brand) {
                        foreach (Category::find()
                            ->where(['parent_id' => $brand->id, 'type' => 3, 'active' => 1])
                            ->orderBy(['name' => SORT_ASC])
                            ->all() as $brandSerial) {
                            $brandsSerial[] = $brandSerial;
                        }
                    }
                }
                ////////////////////////////////////////////////////////////
                $idsTags = [];
                $andWhereTags = ['id' => ''];

                foreach (ProductHasCategory::findAll(['category_id' => $model->id]) as $productHasCategory) {
                    $idsTags[] = $productHasCategory->product_id;
                }

                if (!empty($idsTags)) {
                    $andWhereTags = ['id' => $idsTags];
                }
                ////////////////////////////////////////////////////////////
                $allproducts = Product::find()
                    ->where($andWhereTags)
                    ->orWhere($otherIdsWhere)
                    ->orderBy($orderBy)->all();
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
            $countAllProducts = count($allproducts);
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            $per_page = (isset($_GET['per_page'])) ? (int) $_GET['per_page'] : $defaultPageSize;

            if ($page <= 0) {
                throw new NotFoundHttpException;
            }

            if ($page >= 2 && $countAllProducts <= $defaultPageSize) {
                throw new NotFoundHttpException;
            }

            if ($countAllProducts != 0) {
                if (($per_page * $page) - $countAllProducts > $per_page) {
                    throw new NotFoundHttpException;
                }
            }

            $allproducts = Product::sortAvailable($allproducts);
            $products = [];
            $minPrice = 100000000;
            $maxPrice = 0;
            $minPriceAvailable = 100000000;
            $maxPriceAvailable = 0;
            $filterBrands = [];
            $i = 0;

            /////////////////////////////////////////////////////////////////////////
            $filterFeaturesIds = [];
            $filterBrandsIds = [];
            $priceFrom = 0;
            $priceTo = 0;

            if (isset($_GET['priceTo']) && isset($_GET['priceFrom'])) {
                $filterFeatures = [];
                $priceFrom = (int) str_replace(' ', '', $_GET['priceFrom']);
                $priceTo = (int) str_replace(' ', '', $_GET['priceTo']);

                foreach($_GET as $index => $value) {
                    ////////////////////////////////////////////////////////////////////
                    preg_match('#^feature(.+)_(.+)$#siU', $index, $match);

                    if (!empty($match)) {
                        $a1 = (int) $match[1];//$filterFeature->id
                        $a2 = (int) $match[2];//$filterFeatureValue->id
                        $filterFeatures[$a1][] = $a2;
                    }
                    ////////////////////////////////////////////////////////////////////
                    preg_match('#^brand_(.+)$#siU', $index, $match);

                    if (!empty($match)) {
                        $a1 = (int) $match[1];//$brand->id
                        $filterBrandsIds[] = $a1;
                    }
                    ////////////////////////////////////////////////////////////////////
                }

                foreach($filterFeatures as $filterFeatureId => $filterFeatureValueIds) {
                    $phffv = ProductHasFilterFeatureValue::findAll(['filter_feature_value_id' => $filterFeatureValueIds]);

                    foreach($phffv as $hgg) {
                        $filterFeaturesIds[] = $hgg->product_id;
                    }
                }

                $filterFeaturesIds = array_unique($filterFeaturesIds);
            }

            /////////////////////////////////////////////////////////////////////////

            foreach($allproducts as $product) {
                if ($product->available) {
                    if ($product->price < $minPriceAvailable) {
                        $minPriceAvailable = $product->price;
                    }

                    if ($product->price > $maxPriceAvailable) {
                        $maxPriceAvailable = $product->price;
                    }
                }

                if ($product->price < $minPrice) {
                    $minPrice = $product->price;
                }

                if ($product->price > $maxPrice) {
                    $maxPrice = $product->price;
                }

                $brand = Brand::findOne($product->brand_id);

                if (empty($filterBrands)) {
                    $filterBrands[$i]['id'] = $brand->id;
                    $filterBrands[$i]['name'] = $brand->name;
                    $i++;
                } else {
                    $flag = false;

                    foreach($filterBrands as $index => $arr) {
                        if ($brand->id == $arr['id']) {
                            $flag = true;
                        }
                    }

                    if (!$flag) {
                        $filterBrands[$i]['id'] = $brand->id;
                        $filterBrands[$i]['name'] = $brand->name;
                        $i++;
                    }
                }
            }

            usort($filterBrands, function($a,$b){
                return ($a['name']-$b['name']);
            });

            if ($minPrice == 100000000) {
                $minPrice = 0;
            }

            if ($priceFrom == 0) $priceFrom = $minPrice;
            if ($priceTo == 0) $priceTo = $maxPrice;

            $unfilteredProducts = $allproducts;
            $allproducts = [];

            foreach($unfilteredProducts as $product) {
                if (empty($filterBrandsIds) || in_array($product->brand_id, $filterBrandsIds)) {
                    if (empty($filterFeaturesIds) || in_array($product->id, $filterFeaturesIds)) {
                        if ($product->price >= $priceFrom && $product->price <= $priceTo) {
                            $allproducts[] = $product;
                        }
                    }
                }
            }

            $pages = new \yii\data\Pagination([
                'totalCount' => count($allproducts),
                'defaultPageSize' => $defaultPageSize,
                'pageSizeParam' => 'per_page',
                'forcePageParam' => false,
                'pageSizeLimit' => 200
            ]);

            for ($i = 0; $i < count($allproducts); $i++) {
                if (count($products) >= $pages->limit) {
                    break;
                }

                if ($i >= $pages->offset) {
                    $products[] = $allproducts[$i];
                }
            }

            /*if (!isset($_GET['page']) && !isset($_GET['per_page']) && $model->type == 0) {
                $cache->set('products-cat'.$model->id, $products);
                $cache->set('pages-cat'.$model->id, $pages);
                $cache->set('tags-cat'.$model->id, $tags);
                $cache->set('brands-cat'.$model->id, $brands);
                $cache->set('years-cat'.$model->id, $years);
                $cache->set('brandsSerial-cat'.$model->id, $brandsSerial);
                $cache->set('bHeader-cat'.$model->id, $bHeader);
                $cache->set('bHeader2-cat'.$model->id, $bHeader2);
                $cache->set('minPrice-cat'.$model->id, $minPrice);
                $cache->set('maxPrice-cat'.$model->id, $maxPrice);
                $cache->set('filterBrands-cat'.$model->id, $filterBrands);
            }*/

            return $this->render('index', [
                'model' => $model,
                'products' => $products,
                'pages' => $pages,
                'tags' => $tags,
                'brands' => $brands,
                'years' => $years,
                'brandsSerial' => $brandsSerial,
                'bHeader' => $bHeader,
                'bHeader2' => $bHeader2,
                'minPrice' => $minPriceAvailable,
                'maxPrice' => $maxPriceAvailable,
                'filterBrands' => $filterBrands,
            ]);
        }

    }

    public function actionView($alias)
    {
        City::setCity();

        $model = Product::findOne(['alias' => $alias]);

        if (!$model) {
            throw new NotFoundHttpException;
        }

        if (isset($_POST['reload']) && $_POST['reload'] == 1) {
            $currentVariant = ProductParam::find()
                ->where(['product_id' => $model->id])
                ->andWhere(['params' => $_POST['paramsv']])
                ->one();

        } else {
            $currentVariant = ProductParam::find()->where(['product_id' => $model->id])->orderBy(['id' => SORT_ASC])->one();
        }

        $brand = Brand::findOne($model->brand_id);
        $variants = $model->params;
        $adviser = Adviser::findOne($model->adviser_id);
        $features = [];

        foreach($model->features as $index => $feature) {
            $features[$index]['feature'] = $feature;

            foreach(FeatureValue::find()
                ->where(['feature_id' => $feature->id])
                ->orderBy(['sort_order' => SORT_ASC])
                ->all() as $i => $fv) {
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
            $parent = Category::find()->where(['id' => $model->parent_id])->one();
            ////////////////////////////////////////////////////////////////////////////////////////////
            $accessories = [];
            $ids = [];

            if (!empty($parent->aksses_ids)) {
                foreach(json_decode($parent->aksses_ids) as $value) {
                    $ids[] = (int) $value;
                }

                $accessoriesCategory = Category::find()->where(['id' => $ids])->all();
                $accessories = Product::find()
                    ->where(['parent_id' => ArrayHelper::map($accessoriesCategory, 'id', 'id')])
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
