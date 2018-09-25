<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class SubscribeForm extends Model
{
    public $email;
    
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
        ];
    }
}