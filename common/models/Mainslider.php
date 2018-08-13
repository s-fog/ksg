<?php

namespace common\models;

use Yii;
use \common\models\base\Mainslider as BaseMainslider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mainslider".
 */
class Mainslider extends BaseMainslider
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
            [['image'], 'required', 'on' => 'create'],
            [['header', 'text'], 'required'],
            [['text'], 'string'],
            [['sort_order'], 'integer'],
            [['header', 'link'], 'string', 'max' => 255],
            [['image'], 'image', 'maxSize' => 1000000,  'minWidth' => 1942, 'minHeight' => 438, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
}
