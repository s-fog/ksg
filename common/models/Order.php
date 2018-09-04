<?php

namespace common\models;

use Yii;
use \common\models\base\Order as BaseOrder;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 */
class Order extends BaseOrder
{
    private $adminMail = 'shtepstore@tantci.ru';

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return [
            [['delivery', 'payments', 'name', 'phone', 'email', 'total_cost'], 'required'],
            [['products'], 'safe'],
            [['paid'], 'integer'],
            [['email'], 'email'],
            [['delivery', 'payments', 'name', 'phone', 'email', 'shipaddress', 'comment', 'promocode', 'total_cost'], 'string', 'max' => 255],
            [['check'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery' => 'Доставка',
            'payments' => 'Оплата',
            'name' => 'Имя клиента',
            'phone' => 'Телефон клиента',
            'email' => 'Email клиента',
            'shipaddress' => 'Адрес доставки',
            'comment' => 'Комментарий к заказу',
            'products' => 'Товары',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'promocode' => 'Промокод',
            'total_cost' => 'Общая сумма заказа',
            'paid' => 'Оплачено?',
            'check' => 'Чек uuid',
        ];
    }

    public function sendEmails()
    {
        return ($this->userMessage() && $this->adminMessage());
    }

    public function sendEmailsPaid()
    {
        return ($this->userMessagePaid() && $this->adminMessagePaid());
    }

    public function userMessage() {
        $body = $this->bodyTop();
        $body .= '<div style="text-align: center;color: #fff;">Спасибо за Ваш заказ. Как только товар будет отгружен,<br>
            мы свяжемся с Вами по телефону или e-mail.</div>';
        $body .= $this->bodyBottom();

        return $this->send($this->email, 'Вы оформили новый заказ на сайте Shop.tanci.ru', $body);
    }

    public function adminMessage() {
        $body = $this->bodyTop();
        $body .= '<div style="text-align: center;color: #fff;">Новый заказ на Вашем сайте</div>';
        $body .= $this->bodyBottom();

        return $this->send($this->adminMail, 'Новый заказ на сайте Shop.tanci.ru', $body);
    }

    private function bodyTop() {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html>
                <head>
                    <meta name="viewport" content="width=600, initial scale=1.0">
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <title>Email subject or title</title>
                </head>
                <body style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 16px;">
                <div id="mailsub" style="margin: 0 auto;width: 600px;padding: 20px;">
                    <div class="header" style="margin: 0 auto;padding: 20px;background-color: #000;width: 600px;">
                        <table style="width: 100%;border-collapse: collapse;">
                            <tr>
                                <td style="border: none;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;"><img src="https://shop.tantci.ru/mail-img/logo.png" alt=""></td>
                                <td style="text-align: right;border: none;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">
                                    <a href="tel:+74952299202" class="big" target="_blank" style="font-weight: bold;font-size: 22px;color: #fff;text-decoration: none;">+7 495 229-92-02</a><br>
                                    <a href="mailto:shtepstore@tantci.ru" class="small" target="_blank" style="font-size: 14px;color: #fff;text-decoration: none;">shtepstore@tantci.ru</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="main" style="margin: 0 auto;padding: 20px;background-color: #3a3c47;width: 600px;">
                        <div style="margin-bottom: 15px;text-align: center;color: #92e3c4;font-weight: bold;font-size: 22px;">Заказ №'.$this->id.' от '.date("d.m.Y", $this->created_at).'</div>
        ';
    }

    private function bodyBottom() {
        $bodyBottom = '
                <div style="width: 530px;margin: 20px auto 25px;height: 1px;border: none;background-color: #fff;"></div>
                <div style="margin-bottom: 15px;font-size: 18px;text-align: center;color: #fff;">Информация о заказе:</div>
                <div class="main-container" style="margin: 0 auto;width: 495px;">
                    <table style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th style="text-align: left;width: 240px;border: 1px solid #fff;padding: 15px;background-color: #000;font-weight: normal;font-size: 15px;color: #fff;">Наименование</th>
                            <th style="border: 1px solid #fff;padding: 15px;background-color: #000;font-weight: normal;font-size: 15px;color: #fff;">Кол-во</th>
                            <th style="border: 1px solid #fff;padding: 15px;background-color: #000;font-weight: normal;font-size: 15px;color: #fff;">Цена</th>
                        </tr>
        ';
        //////////////////////////////////////////////////////////////////////////////////////////////////
        $totalSum = 0;
        $totalCount = 0;
        $products = Yii::$app->cart->getPositions();
        if (empty($products)) {
            $products = unserialize(base64_decode($this->products));
        }
        $productsString = '';

        foreach($products as $product) {
            $quantity = $product->getQuantity();
            $price = $quantity * $product->price;
            $cost = number_format($price, 0, ',', ' ');
            $productsString .= '
                        <tr>
                            <td style="font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$product->name.'<br>Цвет: <span style="display: inline-block;width: 20px;height: 20px;background-color: '.$product->getColor($product->color_id)->color.'"></span><br>Размер: '.$product->size.'</td>
                            <td style="font-weight: bold;text-align: center;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$quantity.' шт.</td>
                            <td style="font-weight: bold;text-align: center;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$cost.' руб.</td>
                        </tr>
            ';
            $totalSum += $price;
            $totalCount += $quantity;
        }
        $deliveryCost = [];
        if (strstr($this->delivery, 'Доставка_')) {
            $deliveryCost = explode('_', $this->delivery);
            $totalSum = $totalSum + $deliveryCost[1]*1;
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        $selfDeliveryText = '';
        if (!empty($this->shipaddress) && strstr($this->delivery, 'Доставка_')) {
            $deliveryName = 'Доставка по адресу';
            $deliveryPrice = $deliveryCost[1].' руб.';
            $delivery = $this->shipaddress;
        } else {
            switch($this->delivery) {
                case 'г. Москва, Новинский бульвар, д. 31, ТДЦ «Новинский», 2 этаж.': {
                    $deliveryName = 'Без доставки / Самовывоз';
                    $deliveryPrice = '0 руб.';
                    $delivery = 'Самовывоз товара производится с 9:00 до 20:00 по адресу, <a style="color: #fff;text-decoration: none;">г. Москва, Новинский бульвар, д. 31, ТДЦ «Новинский», 2 этаж.</a>';
                    $selfDeliveryText = '<div style="margin: 10px 0 20px;text-align: center;font-size: 14px;color: #ffd2d2;">Самовывоз производится исключительно<br>
                    по предварительному согласованию.</div>';
                    break;
                }
                case 'г. Москва, ул. Щукинская д. 42, ТРК «Щука», 4 этаж. ': {
                    $deliveryName = 'Без доставки / Самовывоз';
                    $deliveryPrice = '0 руб.';
                    $delivery = 'Самовывоз товара производится с 9:00 до 20:00 по адресу, <a style="color: #fff;text-decoration: none;">г. Москва, ул. Щукинская д. 42, ТРК «Щука», 4 этаж. </a>';
                    $selfDeliveryText = '<div style="margin: 10px 0 20px;text-align: center;font-size: 14px;color: #ffd2d2;">Самовывоз производится исключительно<br>
                    по предварительному согласованию.</div>';
                    break;
                }
                default: {
                    $deliveryName = 'Доставка по России';
                    $deliveryPrice = 'По договоренности';
                    $delivery = $this->delivery;
                    break;
                }
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        switch($this->payments) {
            case 'Картой на сайте': {
                $paymentsLeft = 'Картой на сайте';

                if ($this->paid == 1) {
                    $paymentsRight = 'Статус: Оплачен';
                } else {
                    $paymentsRight = 'Статус: Не оплачен';
                }

                break;
            }
            case 'Картой при получении товара': {
                $paymentsLeft = 'Картой при получении товара';
                $paymentsRight = '';
                break;
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        $comment = '';
        if (!empty($this->comment)) {
            $comment = '
                        <tr>
                            <td style="width: 50%;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">Комментарии к заказу</td>
                            <td style="width: 50%;font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$this->comment.'</td>
                        </tr>
            ';
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        $bodyBottom .= $productsString . '
                        <tr>
                            <td style="font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$deliveryName.'</td>
                            <td style="font-weight: bold;text-align: center;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;"></td>
                            <td style="font-weight: bold;text-align: center;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$deliveryPrice.'</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center;color: #92e3c4;font-size: 18px;border: 1px solid #fff;padding: 10px;line-height: 1.3;vertical-align: middle;">
                                <span style="font-weight: bold;text-transform: uppercase;">Итого:</span>
                                '.$totalCount.' шт. на общую сумму
                                <span style="font-weight: bold;text-transform: uppercase;">'.number_format($totalSum, 0, ",", " ").' руб.</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin: 25px 0 15px;font-size: 18px;text-align: center;color: #fff;">Информация о доставке:</div>
                <div class="main-container" style="margin: 0 auto;width: 495px;">
                    <table style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td style="width: 50%;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$deliveryName.'</td>
                            <td style="width: 50%;padding: 30px 10px;font-size: 14px;border: 1px solid #fff;color: #fff;line-height: 1.3;vertical-align: middle;">'.$delivery.'</td>
                        </tr>
                    </table>
                </div>
                '.$selfDeliveryText.'
                <div style="margin: 25px 0 15px;font-size: 18px;text-align: center;color: #fff;">Информация об оплате:</div>
                <div class="main-container" style="margin: 0 auto;width: 495px;">
                    <table style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td style="width: 50%;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$paymentsLeft.'</td>
                            <td style="width: 50%;font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$paymentsRight.'</td>
                        </tr>
                    </table>
                </div>
                <div style="margin: 25px 0 15px;font-size: 18px;text-align: center;color: #fff;">Информация о клиенте:</div>
                <div class="main-container" style="margin: 0 auto;width: 495px;">
                    <table style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td style="width: 50%;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">Имя</td>
                            <td style="width: 50%;font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">'.$this->name.'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">Телефон</td>
                            <td style="width: 50%;font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;"><a style="color: #fff;text-decoration: none;">'.$this->phone.'</a></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;">E-mail</td>
                            <td style="width: 50%;font-size: 14px;border: 1px solid #fff;padding: 10px;color: #fff;line-height: 1.3;vertical-align: middle;"><a style="color: #fff;text-decoration: none;">'.$this->email.'</a></td>
                        </tr>
                        '.$comment.'
                    </table>
                </div>
                <div style="margin: 15px 0;font-size: 18px;color: #fff;text-align: center;">Спасибо за покупку!</div>
                <div style="margin: 15px 0 0;color: #fff;text-align: center;">С уважением, Ваш интернет-магазин одежды<br>
и аксессуаров для танцев shop.tantci.ru</div>
            </div>
        '.$this->footer();

        return $bodyBottom;
    }

    private function footer() {
        return '<div class="footer" style="width: 600px;margin: 0 auto;padding: 20px;background-color: #000;text-align: center;">
                <div style="color: #fff;">Присоединяйтесь к нам в социальных сетях:</div>
                <div style="margin: 15px 0;">
                    <a href="#" class="soc" target="_blank" style="margin: 0 5px;"><img src="https://shop.tantci.ru/mail-img/vk.png" width="44" height="44" alt=""></a>
                    <a href="#" class="soc" target="_blank" style="margin: 0 5px;"><img src="https://shop.tantci.ru/mail-img/inta.png" width="44" height="44" alt=""></a>
                    <a href="#" class="soc" target="_blank" style="margin: 0 5px;"><img src="https://shop.tantci.ru/mail-img/facebook.png" width="44" height="44" alt=""></a>
                    <a href="#" class="soc" target="_blank" style="margin: 0 5px;"><img src="https://shop.tantci.ru/mail-img/youttube.png" width="44" height="44" alt=""></a>
                </div>
                <div style="color: #fff;font-size: 12px;">© 2008–2017 Fashion auto Все права защищены.</div>
            </div>
        </div>
        </body>
        </html>';
    }

    public function userMessagePaid() {
        $body = $this->bodyTop();
        $body .= '<div style="text-align: center;color: #fff;">Ваш заказ оплачен. Спасибо за заказ!</div>';
        $body .= $this->bodyBottom();

        return $this->send($this->email, 'Вы оплатили заказ на сайте Shop.tanci.ru', $body);
    }

    public function adminMessagePaid() {
        $body = $this->bodyTop();
        $body .= '<div style="text-align: center;color: #fff;">Клиент оплатил заказ.</div>';
        $body .= $this->bodyBottom();

        return $this->send($this->adminMail, 'Клиент оплатил заказ Shop.tanci.ru', $body);
    }

    private function send($to, $subject, $body) {
        $headers = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $headers .= "From: <shtepstore@tantci.ru>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        return mail($to, $subject, $body, $headers);
    }
}
