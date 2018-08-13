<?php

namespace common\models;

use Yii;
use \common\models\base\Textpage as BaseTextpage;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "textpage".
 */
class Textpage extends BaseTextpage
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => \nsept\behaviors\CyrillicSlugBehavior::className(),
                    'attribute' => 'name',
                    'slugAttribute' => 'alias',
                    'immutable' => true,
                    'ensureUnique' => true,
                ],
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
