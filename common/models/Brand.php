<?php

namespace common\models;

use Yii;
use \common\models\base\Brand as BaseBrand;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "brand".
 */
class Brand extends BaseBrand
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
            [['name', 'link'], 'required'],
            [['image'], 'required', 'on' => 'create'],
            [['description', 'link'], 'string'],
            [['sort_order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'image', 'maxSize' => 1000000,  'minWidth' => 280, 'minHeight' => 140, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
}
