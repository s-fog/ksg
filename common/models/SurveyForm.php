<?php

namespace common\models;

use Yii;
use \common\models\base\SurveyForm as BaseSurveyForm;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "survey_form".
 */
class SurveyForm extends BaseSurveyForm
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создано в ',
            'updated_at' => 'Измененно в',
            'survey_id' => 'Опрос',
            'options' => 'Опции',
            'email' => 'Email',
            'phone' => 'Телефон',
        ];
    }

    public function getSurvey() {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }
}
