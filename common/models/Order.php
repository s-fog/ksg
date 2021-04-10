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
            [['payment', 'name', 'phone', 'email', 'total_cost'], 'required'],
            [['products', 'comm', 'address'], 'string'],
            [['total_cost'], 'number'],
            [['paid', 'status', 'payment', 'delivery_cost', 'discount'], 'integer'],
            [['name', 'phone', 'email', 'present_artikul', 'md5Id'], 'string', 'max' => 255],
            ['present_artikul', 'artikulExists', 'on' => 'update'],
        ];
    }

    public function artikulExists($attribute, $params)
    {
        if (!ProductParam::findOne(['artikul' => $this->present_artikul])) {
            $this->addError('new_password', 'Подарка с таким артикулом нет');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment' => 'Оплата',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'address' => 'Адрес',
            'comm' => 'Комментарий к заказу',
            'products' => 'Товары',
            'total_cost' => 'Общая сумма',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'paid' => 'Оплачено?',
            'status' => 'Статус',
            'delivery_cost' => 'Цена доставки'
        ];
    }

    public function hasServices() {
        $hasServices = false;
        $products = unserialize(base64_decode($this->products));

        foreach($products as $md5Id => $product) {
            if ($product->build_cost) {
                $hasServices = true;
            }

            if ($product->waranty_cost) {
                $hasServices = true;
            }
        }

        return $hasServices;
    }

    public function totalCost($offDelivery = false) {
        $serviceCost = 0;
        $products = unserialize(base64_decode($this->products));

        foreach($products as $md5Id => $product) {
            if ($product->build_cost) {
                $serviceCost += $product->getQuantity() * $product->build_cost;
            }

            if ($product->waranty_cost) {
                $serviceCost += $product->getQuantity() * $product->waranty_cost;
            }
        }

        $deliveryCost = 0;

        if ($this->delivery_cost > 0 && !$offDelivery) {
            $deliveryCost = $this->delivery_cost;
        }

        return $this->total_cost + $serviceCost + $deliveryCost;
    }

    public function costWithDiscount() {
        $total_cost = $this->totalCost();

        if (!empty($this->discount)) {
            $d = (int) $this->discount;

            if (strstr($this->discount, '%')) {
                if ($d > 0) {
                    if ($d > 100) {
                        return $total_cost;
                    } else {
                        return $total_cost * ((100 - $d) / 100);
                    }
                } else {
                    return $total_cost;
                }
            } else {
                if ($d > 0) {
                    return $total_cost - $d;
                } else {
                    return $total_cost;
                }
            }
        } else {
            return $total_cost;
        }
    }

    public function sendEmails($to, $subject, $paying = false)
    {
        return Yii::$app
            ->mailer_order
            ->compose(
                ['html' => 'orderSend-html'],
                ['order' => $this, 'paying' => $paying]
            )
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
    
    public function saveMd5Id($validate = true) {
        $this->md5Id = md5($this->id.$this->email.rand(0, 50));
        
        if ($this->save($validate)) {
            return $this->md5Id;
        } else {
            return false;
        }
    }

    public function hasAnyUnavailableProduct() {
        $products = unserialize(base64_decode($this->products));

        foreach($products as $md5Id => $product) {
            if ($product->hasProperty('available_p')) {
                if ($product->available_p === false) {
                    return true;
                }
            }
        }

        return false;
    }
}
