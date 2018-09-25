<?php

namespace frontend\models;

use Yii;

class ReviewForm extends Forms
{
    public function rules()
    {
        return [
            [['name', 'opinion'], 'required']
        ];
    }
}