<?php

namespace frontend\models;

use Yii;

class CallbackForm extends Forms
{
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'length' => [6]],
        ];
    }
}