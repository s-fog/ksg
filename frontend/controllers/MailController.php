<?php

namespace frontend\controllers;

use common\models\Callback;
use common\models\Client;
use common\models\Order;
use common\models\Present;
use common\models\Product;
use common\models\ProductParam;
use common\models\ProductReview;
use frontend\models\CallbackForm;
use frontend\models\ReviewForm;
use Yii;

class MailController extends \yii\web\Controller
{
    public function actionIndex() {
        if (isset($_POST['CallbackForm'])) {
            if (!empty($_POST['CallbackForm']) && isset($_POST['CallbackForm']['type']) && !strlen($_POST['CallbackForm']['BC'])) {
                $form = new CallbackForm();
                $post = $_POST['CallbackForm'];
                $files = (isset($_FILES['CallbackForm'])) ? $_FILES['CallbackForm'] : [];
                $result = $form->send($post, $files);

                $callback = new Callback;
                $callback->name = $_POST['CallbackForm']['name'];
                $callback->phone = $_POST['CallbackForm']['phone'];
                $callback->status = 0;
                $callback->save();

                return $result;
            }
        }

        if (isset($_POST['ReviewForm'])) {
            if (!empty($_POST['ReviewForm']) && isset($_POST['ReviewForm']['type']) && !strlen($_POST['ReviewForm']['BC'])) {
                $form = new ReviewForm();
                $post = $_POST['ReviewForm'];
                $files = (isset($_FILES['ReviewForm'])) ? $_FILES['ReviewForm'] : [];
                $result = $form->send($post, $files);

                $item = new ProductReview();
                $item->name = $_POST['ReviewForm']['name'];
                $item->text = $_POST['ReviewForm']['opinion'];
                $item->product_id = $_POST['ReviewForm']['review_product_id'];
                $item->date = time();
                $item->active = 0;
                $item->save();

                return $result;
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
                $order->email = Yii::$app->params['adminEmail'];
                $order->total_cost = $product->price;

                if ($present = Present::find()->where("$order->total_cost >= min_price AND $order->total_cost < max_price")->one()) {
                    $order->present_artikul = explode(',', $present->product_artikul)[0];
                }

                $products[$product->getId()] = $product;
                $order->products = base64_encode(serialize($products));

                if ($order->save(false)) {
                    $client = new Client;
                    $client->name = $_POST['OneClickForm']['name'];
                    $client->phone = $_POST['OneClickForm']['phone'];
                    $client->save();

                    if ($md5Id = $order->saveMd5Id(false)) {
                        if ($order->sendEmails(Yii::$app->params['adminEmail'], 'Создан новый заказ ksg.ru')) {
                            return $md5Id;
                        } else {
                            return 'cant send emails';
                        }
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
