<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Brand $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="brand-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Brand',
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<!-- attribute link -->
			<?= $form->field($model, 'link')->textInput() ?>

<!-- attribute description -->
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?=$this->render('@backend/views/blocks/image', [
                'form' => $form,
                'model' => $model,
                'image' => $model->image,
                'name' => 'image'
            ])?>

            <?= $form->field($model, 'seo_h1')->textInput() ?>
            <?= $form->field($model, 'seo_title')->textInput() ?>
            <?= $form->field($model, 'seo_keywords')->textInput() ?>
            <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Brand'),
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

