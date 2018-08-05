<?php

namespace common\models;

use Yii;
use \common\models\base\Adviser as BaseAdviser;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adviser".
 */
class Adviser extends BaseAdviser
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
            [['name', 'header', 'text'], 'required'],
            [['image'], 'required', 'on' => 'create'],
            [['header', 'text'], 'string'],
            [['sort_order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'image', 'maxSize' => 1000000,  'minWidth' => 130, 'minHeight' => 175, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
}
