<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\Product;
use frontend\models\CallbackForm;
use Yii;

class MailController extends \yii\web\Controller
{
    public function actionIndex() {
        if (isset($_POST['CallbackForm'])) {
            if (!empty($_POST['CallbackForm']) && isset($_POST['CallbackForm']['type']) && !strlen($_POST['CallbackForm']['BC'])) {
                $form = new CallbackForm();
                $post = $_POST['CallbackForm'];
                $files = (isset($_FILES['CallbackForm'])) ? $_FILES['CallbackForm'] : [];
                $form->send($post, $files);
            }
        }
        if (isset($_POST['OneClickForm'])) {
            if (!empty($_POST['OneClickForm']) && isset($_POST['OneClickForm']['type']) && !strlen($_POST['OneClickForm']['BC'])) {
                $product = Product::findOne($_POST['OneClickForm']['product_id']);
                $product->paramsV = $_POST['OneClickForm']['paramsV'];
                $product->setQuantity(1);
                $order = new Order;
                $order->payment = 0;
                $order->name = $_POST['OneClickForm']['name'];
                $order->phone = $_POST['OneClickForm']['phone'];
                $order->email = '';
                $order->products = base64_encode(serialize([$product->getId() => $product]));
                $order->total_cost = $product->price;

                if ($order->save(false)) {
                    if ($md5Id = $order->saveMd5Id(false)) {
                        return $md5Id;
                    } else {
                        return 'cant save md5Id';
                    }
                } else {
                    return 'error';
                }
            }
        }
    }
}
