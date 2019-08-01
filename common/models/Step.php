<?php

namespace common\models;

use Yii;
use \common\models\base\Step as BaseStep;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "step".
 */
class Step extends BaseStep
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
                [['sort_order'], 'default', 'value' => 0]
            ]
        );
    }

    public function getStepOptions() {
        return $this->hasMany(StepOption::className(), ['step_id' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_id' => 'Survey ID',
            'name' => 'Название',
            'text' => 'Текст',
            'icon' => 'Изображение SVG',
            'options' => 'Options',
            'sort_order' => 'Сортировка',
        ];
    }
}
