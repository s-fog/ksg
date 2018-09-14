<?php

namespace frontend\models;

use Yii;

class OneClickForm extends Forms
{
    public $paramsV;
    public $product_id;

    public function rules()
    {
        return [
            [['phone', 'name'], 'required'],
        ];
    }
}