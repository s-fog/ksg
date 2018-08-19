<?php
namespace frontend\controllers;

use common\models\Brand;
use common\models\Product;
use common\models\ProductParam;
use common\models\Textpage;
use Yii;
use yii\web\Controller;


class CatalogController extends Controller
{
    public function actionIndex($alias = '', $alias2 = '', $alias3 = '', $alias4 = '')
    {
        $model = Textpage::findOne(1);
        $products = Product::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', [
            'model' => $model,
            'products' => $products
        ]);
    }
    public function actionView($alias)
    {
        $model = Product::findOne(['alias' => $alias]);
        $brand = Brand::findOne($model->brand_id);
        $firstVariant = ProductParam::find()->where(['product_id' => $model->id])->orderBy(['id' => SORT_ASC])->one();
        $variants = $model->params;

        $selects = [];

        foreach($variants as $variant) {
            foreach($variant->params as $param) {
                $name = explode(' -> ', $param)[0];
                $value = explode(' -> ', $param)[1];

                if (!isset($selects[$name]) || !in_array($value, $selects[$name])) {
                    $selects[$name][] = $value;
                }
            }
        }

        return $this->render('view', [
            'model' => $model,
            'brand' => $brand,
            'firstVariant' => $firstVariant,
            'variants' => $variants,
            'selects' => $selects,
        ]);
    }
}
