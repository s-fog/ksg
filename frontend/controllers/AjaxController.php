<?php
namespace frontend\controllers;

use common\models\base\Product;
use common\models\Brand;
use common\models\Mainpage;
use common\models\Textpage;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
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
        $params = $_POST['params'];

        $cart = new ShoppingCart();

        $model = Product::findOne($id);
        $model->params = $params;

        if ($model) {
            $cart->put($model, $count);
            return 'success';
        }

        throw new NotFoundHttpException();
    }

    public function actionUpdateCount()
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