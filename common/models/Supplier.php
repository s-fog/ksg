<?php

namespace common\models;

use Yii;
use \common\models\base\Supplier as BaseSupplier;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "supplier".
 */
class Supplier extends BaseSupplier
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
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
