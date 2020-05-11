<?php

namespace backend\controllers;


use common\models\Category;
use common\models\Product;
use common\models\ProductHasCategory;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class AjaxController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionProductHasCategoryChange() {
        $arrayValues = ($_POST['values'] != 'null') ? explode(',', $_POST['values']) : [];
        $productsHasCategories = ProductHasCategory::findAll(['product_id' => $_POST['product_id']]);

        if (count($productsHasCategories) > count($arrayValues) || empty($arrayValues[0])) { //Удаляем элемент
            foreach($productsHasCategories as $productHasCategory) {
                if (!in_array($productHasCategory->category_id, $arrayValues)) {
                    $item = ProductHasCategory::find()->where([
                        'product_id' => $_POST['product_id'],
                        'category_id' => $productHasCategory->category_id
                    ])->one();

                    $item->delete();
                    echo 'success delete';
                }
            }
        } else {//Добавляем элемент
            foreach($arrayValues as $value) {
                if (!ProductHasCategory::findOne([
                    'product_id' => $_POST['product_id'],
                    'category_id' => $value,
                    ])) {

                    $item = new ProductHasCategory;
                    $item->product_id = $_POST['product_id'];
                    $item->category_id = $value;

                    if ($item->save()) {
                        echo 'success added';
                    }
                }
            }
        }
    }

    public function actionDisallowYandexProducts() {
        Product::updateAll(['disallow_xml' => 1]);
    }

    public function actionAllowYandexProducts() {
        Product::updateAll(['disallow_xml' => 0]);
    }
}
