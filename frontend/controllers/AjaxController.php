<?php
namespace frontend\controllers;

use common\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yz\shoppingcart\ShoppingCart;

/**
 * Site controller
 */
class AjaxController extends Controller
{
    public function actionAddToCart()
    {
        $id = $_POST['id'];
        $count = $_POST['quantity'];
        $paramsV = $_POST['paramsV'];

        $cart = new ShoppingCart();

        $model = Product::findOne($id);
        $model->paramsV = $paramsV;

        if ($model) {
            $cart->put($model, $count);
            return 'success';
        }

        throw new NotFoundHttpException();
    }

    public function actionUpdateCartCount()
    {
        $id = $_POST['id'];
        $count = $_POST['quantity'];
        $cart = new ShoppingCart();

        $model = Product::findOne($id);

        if ($model) {
            $cart->update($model, $count);
            return 'success';
        }

        throw new NotFoundHttpException();
    }

    public function actionRemoveFromCart()
    {
        $id = $_POST['id'];
        $cart = new ShoppingCart();

        $model = Product::findOne($id);

        if ($model) {
            $cart->remove($model);
            return 'success';
        }

        throw new NotFoundHttpException();
    }
}