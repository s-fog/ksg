<?php

use common\models\Performance;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Mainpage $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mainpage-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Mainpage',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger'
    ]
    );
    ?>
    <?=$form->field($model, 'seo_title') ?>
    <?=$form->field($model, 'seo_keywords') ?>
    <?=$form->field($model, 'seo_description') ?>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Сохранить'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

