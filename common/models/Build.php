<?php

namespace common\models;

use Yii;
use \common\models\base\Build as BaseBuild;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "build".
 */
class Build extends BaseBuild
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
                [['category_id'], 'unique']
            ]
        );
    }
}
