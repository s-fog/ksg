<?php

namespace common\models;

use Yii;
use \common\models\base\Survey as BaseSurvey;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "survey".
 */
class Survey extends BaseSurvey
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
        return [
            [['name'], 'required'],
            [['preview_image', 'cupon_image', 'success_image'], 'required', 'on' => 'create'],
            [['seo_description', 'under_header', 'youtube_text', 'cupon_text', 'introtext', 'success_text', 'success_link'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'youtube', 'button_text', 'button2_text', 'cupon_header', 'cupon_image', 'cupon_button', 'preview_image', 'success_header', 'success_image', 'success_button', 'success_link_text', 'step_header'], 'string', 'max' => 255],
            [['preview_image'], 'image', 'minWidth' => 260, 'minHeight' => 150, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['cupon_image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['success_image'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'alias' => 'Урл',
            'seo_h1' => 'Seo H1',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'under_header' => 'Текст под главным заголовком',
            'youtube' => 'id видео на youtube',
            'youtube_text' => 'Текст под видео',
            'button_text' => 'Текст кнопки по видео',
            'button2_text' => 'Текст кнопки под шагами',
            'cupon_header' => 'Заголовок купона',
            'cupon_text' => 'Текст купона',
            'cupon_image' => 'Изображение купона',
            'cupon_button' => 'Текст кнопки купона',
            'preview_image' => 'Превью изображение(260x150)',
            'introtext' => 'Введение',
            'success_header' => 'Заголовок успеха',
            'success_image' => 'Изображение успеха',
            'success_button' => 'Текст кнопки успеха',
            'success_text' => 'Текст успеха',
            'success_link_text' => 'Текст ссылки в тексте успеха',
            'success_link' => 'Ссылка успеха',
            'step_header' => 'Заголовок шагов',
            'sort_order' => 'Sort Order',
        ];
    }

    public function getSteps() {
        return $this->hasMany(Step::className(), ['survey_id' => 'id']);
    }

    public function getUrl() {
        return Url::to(['site/index', 'alias' => Textpage::getSurveyPage()->alias, 'alias2' => $this->alias]);
    }
}