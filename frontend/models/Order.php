<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Order extends Model
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $comm;
    public $totalCost__products;
    public $totalCost__services;
    public $totalCost__all;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }

}
