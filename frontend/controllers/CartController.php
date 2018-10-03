<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Product;
use frontend\models\City;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        $cart = new ShoppingCart();

        if (!empty($_POST['Order'])) {
            $positions = unserialize($cart->getSerialized());

            foreach($positions as $md5Id => $position) {

                if (isset($_POST['Order']['build'][$md5Id])) {
                    if ($_POST['Order']['build'][$md5Id] == 'false') {
                        $position->build_cost = false;
                    } else {
                        $position->build_cost = (int) $_POST['Order']['build'][$md5Id];
                    }
                } else {
                    $position->build_cost = false;
                }

                if (isset($_POST['Order']['waranty'][$md5Id])) {
                    if ($_POST['Order']['waranty'][$md5Id] == 'false') {
                        $position->waranty_cost = false;
                    } else {
                        $position->waranty_cost = (int) $_POST['Order']['waranty'][$md5Id];
                    }
                } else {
                    $position->waranty_cost = false;
                }

                $remove = false;

                if (isset($_POST['Order']['count'][$md5Id])) {
                    if ((int) $_POST['Order']['count'][$md5Id] == 0) {
                        $cart->remove($position);
                        unset($positions[$md5Id]);
                        $remove = true;
                    } else {
                        $position->setQuantity((int) $_POST['Order']['count'][$md5Id]);
                    }
                }

                if (!$remove) {
                    $positions[$md5Id] = $position;
                }
            }

            $cart->setPositions($positions);

            $p0 = $this->renderPartial('_products', [
                'cart' => $cart,
                'positions' => $positions,
            ]);
            $p1 = $this->renderPartial('_cartServices', [
                'cart' => $cart,
                'positions' => $positions,
            ]);
            $p2 = $this->renderPartial('_cartTotal', [
                'cart' => $cart,
                'positions' => $positions,
            ]);

            if (!empty($positions)) {
                return json_encode([$p0, $p1, $p2]);
            } else {
                return 'empty';
            }
        }
    }

    public function actionMinicart()
    {
        return $this->renderPartial('_minicart');
    }

    public function actionIndex()
    {
        City::setCity();

        if (!empty($_POST['Order'])) {
            $model = new Order;
            $cart = new ShoppingCart();

            $_POST['Order']['products'] = base64_encode($cart->getSerialized());
            $_POST['Order']['total_cost'] = (int) $_POST['Order']['total_cost'];

            if ($model->load($_POST)) {
                $model->paid = 0;
                $model->status = 0;

                if ($model->save()) {
                    if (
                        $model->saveMd5Id()
                        &&
                        $model->sendEmails($model->email, 'Спасибо за заказ!')
                        &&
                        $model->sendEmails(Yii::$app->params['adminEmail'], 'Создан новый заказ ksg.ru')
                    ) {
                        $cart->removeAll();

                        return $this->redirect(['cart/success', 'md5Id' => $model->md5Id]);
                    }
                    
                    return $this->redirect(['cart/index']);
                }
            }
        } else {
            $this->layout = 'cart';
            $cart = new ShoppingCart();

            return $this->render('index', ['cart' => $cart]);
        }
    }

    public function actionSuccess($md5Id)
    {
        if ($order = Order::findOne(['md5Id' => $md5Id])) {
            return $this->render('success', ['order' => $order]);
        } else {
            throw new NotFoundHttpException;
        }
    }
}