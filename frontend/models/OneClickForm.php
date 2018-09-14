<?php

namespace frontend\models;

use Yii;

class OneClickForm extends Forms
{
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'length' => [6]],
        ];
    }
}