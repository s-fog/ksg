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
            [['seo_description', 'under_header', 'youtube_text',
                'cupon_text', 'introtext', 'success_text', 'success_link',
                'email_step_header', 'email_step_text', 'phone_step_text', 'phone_step_header'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'youtube', 'button_text',
                'button2_text', 'cupon_header', 'cupon_button',
                'success_header', 'success_button',
                'success_link_text', 'step_header'], 'string', 'max' => 255],
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
            'email_step_header' => 'Шаг Email заголовок',
            'email_step_text' => 'Шаг Email текст',
            'phone_step_header' => 'Шаг Телефон заголовок',
            'phone_step_text' => 'Шаг Телефон текст',
        ];
    }

    public function getSteps() {
        return $this->hasMany(Step::className(), ['survey_id' => 'id']);
    }

    public function getUrl() {
        return Url::to(['site/index', 'alias' => Textpage::getSurveyPage()->alias, 'alias2' => $this->alias]);
    }

    public function getLastStep($step, $isEmailStep, $isPhoneStep, $stepCount, $surveyCookieName, $surveyFormCookieName) {
        if (isset($_COOKIE['survey'.$this->id])) {
            $maxStep = 0;

            foreach(json_decode($_COOKIE[$surveyCookieName], true)[$this->id] as $step_id => $options) {
                if ($step_id > $maxStep && !empty($options)) {
                    $maxStep = $step_id;
                }
            }

            if ($isEmailStep || $isPhoneStep) {
                if ($maxStep == $stepCount) {
                    return $step;
                }
            }

            return $maxStep + 1;
        } else {
            return 1;
        }
    }

    public function setCookie($stepOptionsChoose, $step, $surveyCookieName, $surveyFormCookieName) {
        $json = isset($_COOKIE[$surveyCookieName]) ? $_COOKIE[$surveyCookieName] : false;

        if (!$json) {
            $data = [
                $this->id => [
                    1 => $stepOptionsChoose->options
                ]
            ];
        } else {
            $data = json_decode($json, true);
            $data[$this->id][$step] = $stepOptionsChoose->options;
        }

        setcookie($surveyCookieName, json_encode($data), time()+3600*24*30);
        
        if (isset($_COOKIE[$surveyFormCookieName])) {
            $surveyForm = SurveyForm::findOne($_COOKIE[$surveyFormCookieName]);

            if ($surveyForm) {
                $surveyForm->options = json_encode($data);
                $surveyForm->save();
            }
        }
    }
}