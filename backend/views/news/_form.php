<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\News $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
    'id' => 'News',
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <!-- attribute alias -->
            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'introtext')->textarea(['maxlength' => true]) ?>

<!-- attribute html -->
			<?= $form->field($model, 'html')->widget(CKEditor::classname()) ?>

<!-- attribute html2 -->
			<?= $form->field($model, 'html2')->widget(CKEditor::classname()) ?>

            <?=$this->render('@backend/views/blocks/image', [
                'form' => $form,
                'model' => $model,
                'image' => $model->image,
                'name' => 'image'
            ])?>

            <!-- attribute seo_description -->
            <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>

<!-- attribute seo_h1 -->
			<?= $form->field($model, 'seo_h1')->textInput(['maxlength' => true]) ?>

<!-- attribute seo_title -->
			<?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

<!-- attribute seo_keywords -->
			<?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'News'),
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

