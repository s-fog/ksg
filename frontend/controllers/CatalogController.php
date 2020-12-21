<?php
namespace frontend\controllers;

use common\models\Adviser;
use common\models\Brand;
use common\models\Category;
use common\models\FeatureValue;
use common\models\Param;
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

    }

    public function actionPopup() {
        if (!empty($_POST)) {
            $model = Product::findOne($_POST['id']);

            if (!$model) {
                throw new NotFoundHttpException();
            }

            $currentParamName = ($curP = Param::findOne($model->main_param))? $curP->name : '';

            $currentVariant = ProductParam::find()
                ->where(['product_id' => $model->id])
                ->andWhere(['params' => $_POST['paramsv']])
                ->one();

            if (!$currentVariant) {
                $val = '';

                foreach(explode('|', $_POST['paramsv']) as $r) {
                    $p = explode(' -> ', $r);

                    if ($p[0] == $currentParamName) {
                        $val = $r;
                    }
                }

                $currentVariant = ProductParam::find()
                    ->where(['product_id' => $model->id])
                    ->andWhere(['LIKE', 'params', $val])
                    ->orderBy('id')
                    ->one();
            }

            $features = [];

            foreach($model->features as $index => $feature) {
                $features[$index]['feature'] = $feature;

                foreach($feature->featurevalues as $i => $fv) {
                    $features[$index]['values'][$i]['name'] = $fv->name;
                    $features[$index]['values'][$i]['value'] = $fv->value;
                }
            }

            $presents = \common\models\Present::find()->all();

            $presentArtikul = '';
            foreach($presents as $present) {
                if ($model->price >= $present->min_price && $model->price <= $present->max_price) {
                    $presentArtikul = explode(',', $present->product_artikul)[0];
                }
            }

            return $this->renderPartial('_addToCartInner', [
                'model' => $model,
                'presentArtikul' => $presentArtikul
            ]);
        }
    }

    public function actionView($alias)
    {
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

    public function actionGetFilterUrl() {
        if (isset($_POST['url'])) {
            $category = Category::find()->where(['filter_url' => $_POST['url']])->one();

            if ($category) {
                return $this->asJson(['found_category_url' => $category->url]);
            }
        }
    }
}
