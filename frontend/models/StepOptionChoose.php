<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class StepOptionChoose extends Model
{
    public $options;
    public $email;
    public $email_required;
    public $phone;
    public $phone_required;
    public $bc;

    public function rules()
    {
        return [
            [['options'], 'required', 'message' => 'Необходимо выбрать какой-нибудь вариант.'],
            ['bc', 'string', 'min' => 0, 'max' => 0],
            ['phone', 'string'],
            ['phone', 'required',
                'when' => function($model) {
                    return $model->phone_required == 1;
                },
                'whenClient' => "function(attribute, value) {
                    return $('#stepoptionchoose-phone_required').val() == 1;
                }"
            ],
            ['email', 'email'],
            ['email', 'required',
                'when' => function($model) {
                    return $model->email_required == 1;
                },
                'whenClient' => "function(attribute, value) {
                    return $('#stepoptionchoose-email_required').val() == 1;
                }"
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'options' => 'Опции',
            'phone' => 'Телефон',
        ];
    }
}