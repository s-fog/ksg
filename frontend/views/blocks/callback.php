<?php
use frontend\models\CallbackForm;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$callbackForm = new CallbackForm();
$form = ActiveForm::begin([
    'options' => [
        'class' => 'popup callback sendForm',
        'id' => 'callback'
    ],
]);?>
    <div class="callback__inner">
        <div class="callback__left">
            <div class="callback__image"></div>
        </div>
        <div class="callback__right">
            <div class="callback__header">Специалист  оперативно перезвонит
                и ответит на все вопросы.</div>
            <?=$form->field($callbackForm, 'name')
                ->textInput([
                    'class' => 'callback__input',
                    'placeholder' => 'Имя'
                ])->label(false)?>
            <?=$form->field($callbackForm, 'phone')->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999-99-99',
                'options' => [
                    'class' => 'callback__input',
                    'id' => 'callback_phone_mask',
                    'placeholder' => 'Телефон'
                ],
                'clientOptions' => [
                    'clearIncomplete' => true
                ]
            ])->label(false) ?>
            <button class="popup__submit" type="submit"><span>заказать обратный звонок</span></button>
        </div>
    </div>
    <div class="callback__bottom">
        Нажимая «заказать обратный звонок», вы подтверждаете, что прочли и согласны
        с “<a href="/kompaniya/publichnaya-oferta" target="_blank" class="link">Публичной офертой</a>”, и даёте своё согласие на <a href="/documents/politics.pdf" target="_blank" class="link">обработку персональных данных</a>.
    </div>

<?=$form->field($callbackForm, 'type')
    ->hiddenInput([
        'value' => 'Обратный звонок KSG'
    ])->label(false)?>

<?=$form->field($callbackForm, 'BC')
    ->textInput([
        'class' => 'BC',
        'value' => ''
    ])->label(false)?>
<?php ActiveForm::end();?>