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
    public function actionIndex($alias = '', $alias2 = '', $alias3 = '', $alias4 = '')
    {
        if (empty($alias) && empty($alias2) && empty($alias3) && empty($alias4)) {
            $model = Textpage::findOne(1);

            return $this->render('outer', [
                'model' => $model
            ]);
        } else {
            $model = '';
            $innerIdsWhere = [];

            if (!empty($alias3)) {
                $model = Category::findOne(['alias' => $alias3]);
            } else if (!empty($alias2)) {
                $model = Category::findOne(['alias' => $alias2]);
            } else if (!empty($alias)) {
                $model = Category::findOne(['alias' => $alias]);
            }

            if (!$model) {
                throw new NotFoundHttpException;
            }

            /////////////////////////////////////////////////////////
            $page = (!empty($_GET['page']))? $_GET['page']: 1;
            $limit = (!empty($_GET['per_page']))? $_GET['per_page']: 20;
            $offset = ($page == 1)? 0 : $page * $limit - $limit;
            /////////////////////////////////////////////////////////
            $innerIds = $model->getInnerIds();

            if (!empty($innerIds)) {
                $innerIdsWhere = ['parent_id' => $innerIds];
            }
            /////////////////////////////////////////////////////////
            $otherIds = [];
            $otherIdsWhere = [];

            foreach($innerIds as $category_id) {
                foreach(ProductHasCategory::findAll(['category_id' => $category_id]) as $productHasCategory) {
                    $otherIds[] = $productHasCategory->product_id;
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

            $allproducts = Product::find()
                ->orWhere($otherIdsWhere)
                ->orWhere($innerIdsWhere)
                ->orderBy($orderBy)
                ->all();

            $products = Product::find()
                ->orWhere($otherIdsWhere)
                ->orWhere($innerIdsWhere)
                ->limit($limit)
                ->offset($offset)
                ->orderBy($orderBy)
                ->all();

            $products = Product::sortAvailable($products);

            $pagination = Pagination::pagination(count($allproducts), $page, $limit);

            return $this->render('index', [
                'model' => $model,
                'products' => $products,
                'pagination' => $pagination,
            ]);
        }

    }
    public function actionView($alias)
    {
        $model = Product::findOne(['alias' => $alias]);
        $brand = Brand::findOne($model->brand_id);
        $firstVariant = ProductParam::find()->where(['product_id' => $model->id])->orderBy(['id' => SORT_ASC])->one();
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

        $selects = [];

        foreach($variants as $variant) {
            if ($variant->params) {
                foreach($variant->params as $param) {
                    $name = explode(' -> ', $param)[0];
                    $value = explode(' -> ', $param)[1];

                    if (!isset($selects[$name]) || !in_array($value, $selects[$name])) {
                        $selects[$name][] = $value;
                    }
                }
            }
        }

        $model->popular = $model->popular + 1;
        $model->save();

        return $this->render('view', [
            'model' => $model,
            'brand' => $brand,
            'firstVariant' => $firstVariant,
            'variants' => $variants,
            'selects' => $selects,
            'adviser' => $adviser,
            'features' => $features,
        ]);
    }
}
