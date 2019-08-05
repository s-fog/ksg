<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\SurveyForm;
use common\models\Textpage;
use frontend\models\StepOptionChoose;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['name'] = $model->name;

?>

<h1 class="header"><?=$model->step_header?></h1>

<?php
$form = ActiveForm::begin([
    'options' => [
        'class' => 'surveyStep',
        'id' => 'stepOptionsChooseForm'
    ],
]);?>
    <div class="surveyStep__container">
        <div class="surveyStep__header">#<?=$step?>
            <?php if ($isPhoneStep) { ?>
                <?=$model->phone_step_header?>
            <?php } else if ($isEmailStep) { ?>
                <?=$model->email_step_header?>
            <?php } else { ?>
                <?=$model->steps[$step - 1]->inner_header?>
            <?php } ?>
        </div>
        <div class="surveyStep__steps">
            <div class="surveyStep__stepsInner">
                <?php
                $before = true;
    
                for($index = 1; $index <= count($model->steps) + 1; $index++) {
                    $active = false;
    
                    if ($index == $step) {
                        $active = true;
                        $before = false;
                    }
                    ?>
                    <div class="surveyStep__step<?=$active ? ' active' : ''?><?=$before ? ' before' : ''?>">
                        <span><?=$index?></span>
                        <em class="surveyStep__stepDot"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.39 11.6"><path class="svg-dot" d="M15,0H8.18a3.49,3.49,0,0,0-2.4,1L1,5.8a3.42,3.42,0,0,0,2.4,5.8h6.9a3.49,3.49,0,0,0,2.4-1l4.8-4.8A3.46,3.46,0,0,0,15,0Z"/></svg></em>
                        <em class="surveyStep__stepDot2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.39 11.6"><path class="svg-dot" d="M15,0H8.18a3.49,3.49,0,0,0-2.4,1L1,5.8a3.42,3.42,0,0,0,2.4,5.8h6.9a3.49,3.49,0,0,0,2.4-1l4.8-4.8A3.46,3.46,0,0,0,15,0Z"/></svg></em>
                    </div>
                <?php } ?>
            </div>
            <div class="product__presents">
                <svg class="notanimated" xmlns="http://www.w3.org/2000/svg" viewBox="-14.5 -14 50 50" id="el_SyGqzxv2m" height="50" width="50"><style>#el_SyfGqzlD3m{fill: #e83b4b;}</style><defs></defs><title>podarok</title><g id="el_Byxf5zgP2Q" data-name="Слой 2"><g id="el_HJ-M5zxv37" data-name="Слой 1"><path d="M20.29,5H16.92A6.25,6.25,0,0,0,18.07,3.9a2.46,2.46,0,0,0,.6-2.71,2,2,0,0,0-1.25-1A6.58,6.58,0,0,0,13,.73a8.45,8.45,0,0,0-2.29,2.42A8.19,8.19,0,0,0,8.38.73,6.55,6.55,0,0,0,3.93.18a2,2,0,0,0-1.26,1C2.13,2.36,2.86,3.82,4.44,5H1a1,1,0,0,0-1,1v4.94a1,1,0,0,0,1,1h.27V21.9a1,1,0,0,0,1,1H19.06a1,1,0,0,0,1-1V11.83h.27a1,1,0,0,0,1-1V5.93A1,1,0,0,0,20.29,5Zm-1,4.94H11.59v-3h7.74ZM13.91,2.4a4.81,4.81,0,0,1,3-.4c.05.22-.5,1.21-2.11,2l-2.4,0A6.29,6.29,0,0,1,13.91,2.4ZM5.26,1.92a4.79,4.79,0,0,1,2.17.48A6,6,0,0,1,8.93,4L6.53,4A4.2,4.2,0,0,1,4.36,2.08,1.72,1.72,0,0,1,5.26,1.92Zm-3.34,5H9.67v3H1.92Zm1.23,4.94H9.67v9.11H3.15Zm15,9.11H11.59V11.83H18.1Z" id="el_SyfGqzlD3m"></path></g></g></svg>
                <svg class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="-14.5 -14 50 50" id="el_SyGqzxv2m" height="50" width="50"><style>@-webkit-keyframes el_SyfGqzlD3m_HyLSVgPhm_Animation{
                                                                                                                                                       100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}}
                        @keyframes el_SyfGqzlD3m_HyLSVgPhm_Animation{
                            0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                            6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                            13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(-5deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(-5deg) translate(-10.664999961853027px, -11.456446766853333px);}
                            16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                            20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(5deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(5deg) translate(-10.664999961853027px, -11.456446766853333px);}
                            23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                            100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}}
                        @-webkit-keyframes el_SyfGqzlD3m_SJyhGxP3Q_Animation{
                            0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                            6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);}
                            16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);}
                            23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            33.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            41.11%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                            66.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                            100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}}
                        @keyframes el_SyfGqzlD3m_SJyhGxP3Q_Animation{
                            0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                            6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);}
                            16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);}
                            23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            33.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                            41.11%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                            66.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                            100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}}
                        #el_SyGqzxv2m *{-webkit-animation-duration: 3s;animation-duration: 3s;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}
                        #el_SyfGqzlD3m{fill: #e83b4b;}
                        #el_SyfGqzlD3m_SJyhGxP3Q{-webkit-animation-name: el_SyfGqzlD3m_SJyhGxP3Q_Animation;animation-name: el_SyfGqzlD3m_SJyhGxP3Q_Animation;}
                        #el_SyfGqzlD3m_HyLSVgPhm{-webkit-animation-name: el_SyfGqzlD3m_HyLSVgPhm_Animation;animation-name: el_SyfGqzlD3m_HyLSVgPhm_Animation;}</style><defs></defs><title>podarok</title><g id="el_Byxf5zgP2Q" data-name="Слой 2"><g id="el_HJ-M5zxv37" data-name="Слой 1"><g id="el_SyfGqzlD3m_SJyhGxP3Q" data-animator-group="true" data-animator-type="0"><g id="el_SyfGqzlD3m_HyLSVgPhm" data-animator-group="true" data-animator-type="1"><path d="M20.29,5H16.92A6.25,6.25,0,0,0,18.07,3.9a2.46,2.46,0,0,0,.6-2.71,2,2,0,0,0-1.25-1A6.58,6.58,0,0,0,13,.73a8.45,8.45,0,0,0-2.29,2.42A8.19,8.19,0,0,0,8.38.73,6.55,6.55,0,0,0,3.93.18a2,2,0,0,0-1.26,1C2.13,2.36,2.86,3.82,4.44,5H1a1,1,0,0,0-1,1v4.94a1,1,0,0,0,1,1h.27V21.9a1,1,0,0,0,1,1H19.06a1,1,0,0,0,1-1V11.83h.27a1,1,0,0,0,1-1V5.93A1,1,0,0,0,20.29,5Zm-1,4.94H11.59v-3h7.74ZM13.91,2.4a4.81,4.81,0,0,1,3-.4c.05.22-.5,1.21-2.11,2l-2.4,0A6.29,6.29,0,0,1,13.91,2.4ZM5.26,1.92a4.79,4.79,0,0,1,2.17.48A6,6,0,0,1,8.93,4L6.53,4A4.2,4.2,0,0,1,4.36,2.08,1.72,1.72,0,0,1,5.26,1.92Zm-3.34,5H9.67v3H1.92Zm1.23,4.94H9.67v9.11H3.15Zm15,9.11H11.59V11.83H18.1Z" id="el_SyfGqzlD3m"></path></g></g></g></g></svg>
            </div>
        </div>
        <?php if ($isPhoneStep) { ?>
            <div class="surveyStep__optionsHeader"><?=$model->phone_step_text?></div>
            <?=$form->field($stepOptionsChoose, 'phone', [
                'options' => [
                    'class' => 'form-group surveyStep__phone'
                ]
            ])->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999-99-99',
                'options' => [
                    'class' => 'surveyStep__input',
                    'placeholder' => 'Ваш номер телефона'
                ],
                'clientOptions' => [
                    'clearIncomplete' => true
                ]
            ])->label(false) ?>
            <button type="submit" class="button button3 surveyStep__nextStep">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"></polygon></g></svg>
                <span>Отправить</span>
            </button>
            <?=$form->field($stepOptionsChoose, 'phone_required')
            ->hiddenInput([
                'value' => 1
            ])->label(false)?>
            <?=$form->field($stepOptionsChoose, 'options')
            ->hiddenInput([
                'value' => 1
            ])->label(false)?>
            <div class="surveyStep__formText">
                Нажимая «отправить», вы соглашаетесь <br>
                с <a href="/documents/politics.pdf" target="_blank" class="link">условиями обработки персональных данных.</a>
            </div>
        <?php } else if ($isEmailStep) {
            if ($surveyForm) {
                $stepOptionsChoose->email = $surveyForm->email;
            }
            ?>
            <div class="surveyStep__optionsHeader"><?=$model->email_step_text?></div>
            <?=$form->field($stepOptionsChoose, 'email', [
                'options' => [
                    'class' => 'form-group surveyStep__email'
                ]
            ])->textInput([
                'class' => 'surveyStep__input',
                'placeholder' => 'Ваш e-mail'
            ])->label(false);?>
            <button type="submit" class="button button3 surveyStep__nextStep">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"></polygon></g></svg>
                <span>продолжить</span>
            </button>
            <?=$form->field($stepOptionsChoose, 'email_required')
                ->hiddenInput([
                    'value' => 1
                ])->label(false)?>
            <?=$form->field($stepOptionsChoose, 'options')
            ->hiddenInput([
                'value' => 1
            ])->label(false)?>
            <div class="surveyStep__formText">
                Нажимая «отправить», вы соглашаетесь <br>
                с <a href="/documents/politics.pdf" target="_blank" class="link">условиями обработки персональных данных.</a>
            </div>
        <?php } else {
            if (isset($_COOKIE['survey'.$model->id])) {
                $data = json_decode($_COOKIE['survey'.$model->id], true);

                if (isset($data[$model->id][$step])) {
                    $stepOptionsChoose->options = $data[$model->id][$step];
                }
            }
            ?>
            <div class="surveyStep__optionsHeader"><?=$model->steps[$step - 1]->inner_text?></div>
            <?=$form->field($stepOptionsChoose, 'options')->checkboxList(
                ArrayHelper::map($model->steps[$step - 1]->stepOptions, 'id', 'name'),
                [
                    'item' => function ($index, $label, $name, $checked, $value){
                        $che = '';

                        if ($checked) {
                            $che = ' checked';
                        }

                        return '
                            <label class="surveyStep__optionsCheckboxLabel'.$che.'">
                                <input type="checkbox" name="'.$name.'" value="'.$value.'"'.$che.'>
                                <span class="surveyStep__optionsCheckbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.56 27.1"><defs><linearGradient id="Безымянный_градиент_9" x1="17.52" y1="3.37" x2="20.69" y2="8.86" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#161412" stop-opacity=".95"/><stop offset=".07" stop-color="#161412" stop-opacity=".86"/><stop offset=".43" stop-color="#161412" stop-opacity=".65"/><stop offset=".64" stop-color="#161412" stop-opacity=".23"/><stop offset=".88" stop-color="#161412" stop-opacity="0"/></linearGradient></defs><path class="ned" d="M12.28 2.54a12.28 12.28 0 1 0 12.28 12.28A12.3 12.3 0 0 0 12.28 2.54zm0 22.72a10.44 10.44 0 1 1 10.43-10.44 10.45 10.45 0 0 1-10.43 10.44z"/><path d="M16.79 5.41a10.54 10.54 0 0 1 2.28 1.49 10.41 10.41 0 0 1 1.05 1c.9 1 2.72.31 1.43-1.18a12.58 12.58 0 0 0-1.76-1.66 13.62 13.62 0 0 0-1.88-1.2c-1.48-.72-2.24 1.01-1.12 1.55z" fill="url(#Безымянный_градиент_9)"/><path class="ned" d="M17.85.17l-6.8 16.9-4-5.07a2.56 2.56 0 0 0-2.87 2.24l5.76 7.39a2 2 0 0 0 1.57.77 2 2 0 0 0 1.84-1.25l7.84-19.5A2.59 2.59 0 0 0 17.85.17z"/></svg>
                                    <span class="surveyStep__optionsCheckboxText">'.$label.'</span>
                                </span>
                            </label>';
                    }
                ]
            )->label(false)?>

            <button type="submit" class="button button3 surveyStep__nextStep">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"></polygon></g></svg>
                <span>продолжить</span>
            </button>
        <?php } ?>
    </div>
<?=$form->field($stepOptionsChoose, 'bc')
    ->textInput([
        'class' => 'BC',
        'value' => ''
    ])->label(false)?>
<?php ActiveForm::end();?>