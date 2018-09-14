<?php

namespace common\models;

use Yii;
use \common\models\base\Image as BaseImage;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "image".
 */
class Image extends BaseImage
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
            [['text'], 'string'],
            [['product_id', 'sort_order'], 'integer'],
            [['image'], 'image', 'maxSize' => 1000000,/*  'minWidth' => 770, 'minHeight' => 553,*/ 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
}
