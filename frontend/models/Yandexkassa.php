<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * ContactForm is the model behind the contact form.
 */
class Yandexkassa extends Model
{
    public $shopId = 506702;
    public $scid = 800588;
    public $shopPassword = 'OhZuYQUrbomgObCmVD';

    public function returnForm($order) {
        $host = 'https://www.ksg.ru';
        $items = [];
        $i = 0;
        $productCount = 0;
        $productsI = [];

        foreach(unserialize(base64_decode($order->products)) as $product) {
            for ($j = 0; $j < $product->getQuantity(); $j++) {
                $productsI[$j]['quantity'] = 1;
                $productsI[$j]['price']['amount'] = $product->price;
                $productsI[$j]['tax'] = 1;
                $productsI[$j]['text'] = $product->name;
                $productCount++;
            }

            if ($product->build_cost > 0) {
                $items[$i]['quantity'] = $product->getQuantity();
                $items[$i]['price']['amount'] = $product->build_cost;
                $items[$i]['tax'] = 1;
                $items[$i]['text'] = 'Сборка '.$product->name;
                $i++;
            }

            if ($product->waranty_cost > 0) {
                $items[$i]['quantity'] = $product->getQuantity();
                $items[$i]['price']['amount'] = $product->waranty_cost;
                $items[$i]['tax'] = 1;
                $items[$i]['text'] = 'Гарантия на '.$product->name;
                $i++;
            }
        }

        if ($order->delivery_cost > 0) {
            $items[$i]['quantity'] = 1;
            $items[$i]['price']['amount'] = $order->delivery_cost;
            $items[$i]['tax'] = 1;
            $items[$i]['text'] = 'Доставка';
        }

        if ($order->discount > 0) {
            $discount = $order->discount;
            $perTik = (int) floor($discount / $productCount);

            for($i = 0; $i < 100;$i++) {
                $minus = ($discount - $perTik > 0) ? $perTik : $discount;

                foreach($productsI as $index => $item) {
                    if ($item['price']['amount'] > $minus) {
                        $item['price']['amount'] = $item['price']['amount'] - $minus;
                        $discount = $discount - ($minus * $item['quantity']);
                        $productsI[$index] = $item;

                        if ($discount <= 0) {
                            break 2;
                        }
                    }
                }
            }
        }

        $productsB = [];

        foreach($productsI as $index => $item) {
            $mdd5 = md5($item['quantity'].$item['price']['amount'].$item['text']);

            if (isset($productsB[$mdd5])) {
                $productsB[$mdd5]['quantity']++;
            } else {
                $productsB[$mdd5] = $item;
            }
        }
        sort($productsB);

        $merchant = [
            'customerContact' => $order->email,
            'taxSystem' => 3,
            'items' => $productsB
        ];

        $merchantJson = json_encode($merchant);
        $returnUrl = $host.Url::to(['cart/success', 'md5Id' => $order->md5Id]);

        $form = '<form action="https://money.yandex.ru/eshop.xml" method="POST" class="formYandex to-yandex">';
        $form .= '<input type="hidden" name="shopId" value="'.$this->shopId.'">';
        $form .= '<input type="hidden" name="scid" value="'.$this->scid.'">';
        $form .= '<input type="hidden" name="customerNumber" value="'.$order->email.'">';
        $form .= '<input type="hidden" name="sum" value="'.$order->costWithDiscount().'">';
        $form .= '<input type="hidden" name="orderNumber" value="'.$order->id.'">';
        $form .= '<input type="hidden" name="cps_email" value="'.$order->email.'">';
        $form .= '<input type="hidden" name="shopSuccessURL" value="'.$returnUrl.'">';
        $form .= '<input type="hidden" name="shopFailURL" value="'.$returnUrl.'">';
        $form .= '<input name="ym_merchant_receipt" value=\''.$merchantJson.'\' type="hidden"/>';
        $form .= '<input type="hidden" name="paymentType" value="AC">';
        $form .= '<button type="submit" class="formYandex__button"></button>';
        $form .= '</form>';

        return $form;
    }

    public function buildResponse($action, $invoiceId, $resultCode, $message = null)
    {
        $xml = new \DOMDocument("1.0", "utf-8");
        $child = $xml->createElement($action . "Response");
        $child->setAttribute('performedDatetime', date("Y-m-d\TH:i:s.000P"));
        $child->setAttribute('code', $resultCode);
        if ($message) {
            $child->setAttribute('message', $message);
        }
        $child->setAttribute('invoiceId', $invoiceId);
        $child->setAttribute('shopId', $this->shopId);
        $xml->appendChild($child);

        return $xml->saveXML();
    }

    public function md5($post) {
        $str = implode(';', [
            $post['action'],
            $post['orderSumAmount'],
            $post['orderSumCurrencyPaycash'],
            $post['orderSumBankPaycash'],
            $post['shopId'],
            $post['invoiceId'],
            $post['customerNumber'],
            $this->shopPassword
        ]);

        $md5 = strtoupper(md5($str));

        return $md5;
    }
}
