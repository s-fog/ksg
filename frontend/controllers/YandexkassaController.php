<?php
namespace frontend\controllers;

use common\models\Order;
use frontend\models\Fiskal;
use frontend\models\Yandexkassa;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class YandexkassaController extends Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionOrderCheck() {
        $yandexKassa = new Yandexkassa();
        $thisAction = 'checkOrder';
        Yii::$app->response->setStatusCode(200);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/xml; charset=utf-8');

        if ($_POST) {
            $order = Order::findOne($_POST['orderNumber']*1);

            if (!empty($order)) {
                if ($order->email != $_POST['customerNumber']) {
                    return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 100);
                }
            } else {
                return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 100);
            }

            if (strtoupper($yandexKassa->md5($_POST)) == $_POST['md5']) {
                return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 0);
            } else if (mb_strtoupper($yandexKassa->md5) != $_POST['md5']) {
                return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 1);
            } else {
                return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 200);
            }
        }
    }

    public function actionPaymentAviso() {
        $yandexKassa = new Yandexkassa();
        $order = Order::findOne($_POST['orderNumber']*1);
        $thisAction = 'paymentAviso';
        Yii::$app->response->setStatusCode(200);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/xml; charset=utf-8');

        if ($order) {
            if ($order->email != $_POST['customerNumber']) {
                return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 100);
            }
        } else {
            return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 100);
        }

        if (mb_strtoupper($yandexKassa->md5($_POST)) == $_POST['md5']) {
            file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/www/logs/jhhhh.log", $order->paid);
            if ($order->paid != 1) {
                $order->paid = 1;
                $order->save(false);
                $order->sendEmails($order->email, 'Ваш заказ оплачен! KSG', true);
                $order->sendEmails(Yii::$app->params['adminEmail'], 'Оплачен заказ ksg.ru', true);
            }

            return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 0);
        } else if (mb_strtoupper($yandexKassa->md5) != $_POST['md5']) {
            return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 1);
        } else {
            return $yandexKassa->buildResponse($thisAction, $_POST['invoiceId'], 200);
        }
    }
}
