<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Callback $model
* @var yii\widgets\ActiveForm $form
*/
$cre = new DateTime();
$cre->setTimestamp($model->created_at);
$upd = new DateTime();
$upd->setTimestamp($model->updated_at);

?>

<div class="callback-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Callback',
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            <div class="form-group" style="margin: 40px 0 20px;">
                <label class="control-label" for="callback-status">Время создания</label>
                <span><?=$cre->format('c')?></span>
            </div>
            <div class="form-group" style="margin: 20px 0 40px;">
                <label class="control-label" for="callback-status">Время изменения</label>
                <span><?=$upd->format('c')?></span>
            </div>

<!-- attribute status -->
			<?= $form->field($model, 'status')->dropDownList(Yii::$app->params['callbackStatus']) ?>

<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!-- attribute phone -->
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

<!-- attribute comment -->
			<?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Callback'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Создать' : 'Сохранить'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

