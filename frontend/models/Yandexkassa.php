<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Yandexkassa extends Model
{
    public $shopId = 180077;
    public $scid = 714018;
    public $shopPassword = 'OvtyEzl3SVgA2CNJ5s';

    public function returnForm($order) {
        $form = '<form action="https://money.yandex.ru/eshop.xml" method="POST" class="to-yandex">';
        $form .= '<input type="hidden" name="shopId" value="'.$this->shopId.'">';
        $form .= '<input type="hidden" name="scid" value="'.$this->scid.'">';
        $form .= '<input type="hidden" name="customerNumber" value="'.$order->email.'">';
        $form .= '<input type="hidden" name="sum" value="'.$order->total_cost.'">';
        $form .= '<input type="hidden" name="orderNumber" value="'.$order->id.'">';
        $form .= '<input type="hidden" name="cps_email" value="'.$order->email.'">';
        $form .= '<input type="hidden" name="paymentType" value="AC">';
        $form .= '<button type="submit"></button>';
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
