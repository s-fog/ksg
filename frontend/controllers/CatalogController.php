<?php
namespace frontend\controllers;

use common\models\Adviser;
use common\models\Brand;
use common\models\Category;
use common\models\FeatureValue;
use common\models\Product;
use common\models\ProductHasCategory;
use common\models\ProductParam;
use common\models\Textpage;
use frontend\models\Pagination;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CatalogController extends Controller
{
    public function actionIndex($alias = '', $alias2 = '', $alias3 = '', $alias4 = '', $alias5 = '')
    {
        if (Category::isAliasesEmpty([$alias, $alias2, $alias3, $alias4, $alias5])) {
            $model = Textpage::findOne(1);

            return $this->render('outer', [
                'model' => $model
            ]);
        } else {
            $model = Category::getCurrentCategory([$alias, $alias2, $alias3, $alias4, $alias5]);
            $innerIdsWhere = [];

            if (!$model) {
                throw new NotFoundHttpException;
            }

            /////////////////////////////////////////////////////////
            $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
            $limit = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 20;
            $offset = ($page == 1) ? 0 : $page * $limit - $limit;
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
            /////////////////////////////////////////////////////////
            $tags = [];
            $brands = [];
            $years = [];
            $brandsSerial = [];

            if ($model->type == 0) {//Если категория
                $tags = Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $years = Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 4])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $brands = Category::find()
                    ->where(['parent_id' => $model->id, 'type' => 2])
                    ->orderBy(['name' => SORT_ASC])
                    ->all();

                $allproducts = Product::find()
                    ->orWhere($otherIdsWhere)
                    ->orWhere($innerIdsWhere)
                    ->orderBy($orderBy);
            } else {//Если всё остальное
                if (in_array($model->type, [1, 2, 4])) {
                    $parent = Category::findOne(['id' => $model->parent_id]);

                    $tags = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 4])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brands = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 2])
                        ->orderBy(['name' => SORT_DESC])
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
                        ->where(['parent_id' => $parent->id, 'type' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 4])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brands = Category::find()
                        ->where(['parent_id' => $parent->id, 'type' => 2])
                        ->orderBy(['name' => SORT_DESC])
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
                    ->orderBy($orderBy);
            }
            /////////////////////////////////////////////////////////
            $bHeader = $model->seo_h1 . ' по брендам';

            if (in_array($model->type, [1, 2, 4])) {
                $parent = Category::findOne($model->parent_id);
                $bHeader = $parent->seo_h1 . ' по брендам';
            }

            if ($model->type == 3) {
                $parent = Category::findOne($model->parent_id);
                $parent2 = Category::findOne($parent->parent_id);
                $bHeader = $parent2->seo_h1 . ' по брендам';
            }
            /////////////////////////////////////////////////////////
            $pages = new \yii\data\Pagination([
                'totalCount' => $allproducts->count(),
                'defaultPageSize' => 20,
                'pageSizeParam' => 'per_page',
                'forcePageParam' => false
            ]);

            $products = $allproducts->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            $productsBrands = Product::getBrandsCategoriesBrands($brands);
            $products = Product::sortAvailable($products);

            return $this->render('index', [
                'model' => $model,
                'products' => $products,
                'pages' => $pages,
                'tags' => $tags,
                'productsBrands' => $productsBrands,
                'brands' => $brands,
                'years' => $years,
                'brandsSerial' => $brandsSerial,
                'bHeader' => $bHeader,
            ]);
        }

    }

    public function actionReloadProduct(){
        $id = $_POST['id'];
        $quantity = $_POST['quantity'];
        $paramsV = $_POST['paramsV'];
    }
    public function actionView($alias)
    {
        $model = Product::findOne(['alias' => $alias]);
        
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
            $model->popular = $model->popular + 1;
            $model->save();

            return $this->render('view', [
                'model' => $model,
                'brand' => $brand,
                'currentVariant' => $currentVariant,
                'variants' => $variants,
                'selects' => $selects,
                'adviser' => $adviser,
                'features' => $features,
            ]);
        }

    }
}
