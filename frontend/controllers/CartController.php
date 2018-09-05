<?php
namespace frontend\controllers;

use common\models\Product;
use Yii;
use yii\web\Controller;
use yz\shoppingcart\ShoppingCart;

/**
 * Site controller
 */
class CartController extends Controller
{
    public function actionAdd()
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

        return 'error';
    }

    public function actionUpdateCount()
    {
        $md5Id = $_POST['id'];
        $count = $_POST['quantity'];
        $cart = new ShoppingCart();

        $position = $cart->getPositionById($md5Id);

        if ($position) {
            $cart->update($position, $count);
            return 'success';
        }

        return 'error';
    }

    public function actionRemove()
    {
        $md5Id = $_POST['id'];
        $cart = new ShoppingCart();

        $position = $cart->getPositionById($md5Id);

        if ($position) {
            $cart->remove($position);
            return 'success';
        }

        return 'error';
    }

    public function actionReloadCart() {
        return $this->renderPartial('_products');
    }

    public function actionMinicart()
    {
        return $this->renderPartial('_minicart');
    }

    public function actionIndex()
    {
        /*$model = new Order;
        $cart = new ShoppingCart();
        $this->layout = 'textpage';*/

        /*if (!empty($_POST['Order'])) {
            $_POST['Order']['products'] = base64_encode($cart->getSerialized());

            if (strstr($_POST['Order']['delivery'], 'Доставка_')) {
                $deliveryCost = explode('_', $_POST['Order']['delivery']);
                $_POST['Order']['total_cost'] = ''.($_POST['Order']['total_cost']*1 + $deliveryCost[1]*1).'';
            }
        }

        try {
            if ($model->load($_POST) && $model->save()) {
                $cart->removeAll();
                return $this->render('index', ['model' => $model]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }*/
        $this->layout = 'cart';
        $cart = new ShoppingCart();

        return $this->render('index', ['cart' => $cart]);
    }
}