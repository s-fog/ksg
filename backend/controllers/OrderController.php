<?php

namespace backend\controllers;

use common\models\Order;
use common\models\Product;
use common\models\ProductParam;
use common\models\ProductParamOrder;
use Yii;
use yii\helpers\Url;

/**
* This is the class for controller "OrderController".
*/
class OrderController extends \backend\controllers\base\OrderController
{
    public function actionProductAdd($id)
    {
        $order = Order::findOne($id);

        if ($order) {
            $model = new ProductParamOrder();

            try {
                if ($model->load($_POST) && $model->validate()) {
                    $productParam = ProductParam::findOne(['artikul' => $model->artikul]);

                    if ($productParam) {
                        $product = Product::findOne($productParam->product_id);
                        $product->paramsV = implode('|', !empty($productParam->params) ? $productParam->params : []);
                        $products = unserialize(base64_decode($order->products));
                        $alreadyHere = false;
                        $quantity = ((int) $model->quantity > 0) ? (int) $model->quantity : 1;

                        foreach ($products as $md5Id => $p) {
                            if ($product->getId() == $md5Id) {
                                $p->setQuantity($p->getQuantity() + $quantity);
                                $products[$md5Id] = $p;
                                $alreadyHere = true;
                            }
                        }

                        if (!$alreadyHere) {
                            $product->setQuantity($quantity);
                            $products[$product->getId()] = $product;
                        }

                        $total_cost = 0;

                        foreach($products as $md5Id => $product) {
                            $total_cost += $product->getQuantity() * $product->price;
                        }

                        $order->products = base64_encode(serialize($products));
                        $order->total_cost = $total_cost;

                        if ($order->save()) {
                            return $this->redirect(['order/update', 'id' => $order->id]);
                        }
                    } else {
                        return 'Такого артикула нет';
                    }
                } elseif (!\Yii::$app->request->isPost) {
                    $model->load($_GET);
                }
            } catch (\Exception $e) {
                $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
                $model->addError('_exception', $msg);
            }

            return $this->render('product-add', ['model' => $model, 'order' => $order]);
        } else {
            return $this->redirect('index');
        }
    }

    public function actionProductDelete($order_id, $id)
    {
        $order = Order::findOne($order_id);

        if ($order) {
            $products = unserialize(base64_decode($order->products));

            foreach ($products as $md5Id => $product) {
                if ($md5Id == $id) {
                    unset($products[$md5Id]);
                }
            }

            $order->products = base64_encode(serialize($products));

            if ($order->save()) {
                return $this->redirect(['order/update', 'id' => $order_id]);
            } else {
                return $this->redirect('index');
            }
        } else {
            return $this->redirect('index');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            if ($model->status == 0) {
                $model->status = 1;
                $model->save();
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
