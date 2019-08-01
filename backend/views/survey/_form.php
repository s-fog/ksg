<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Survey $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="survey-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Survey',
    ]
    );
    ?>

    <?=Tabs::widget([
        'items' => [
            [
                'label'     =>  'Основное',
                'content'   =>  $this->render('_main', [
                    'form' => $form,
                    'model' => $model,
                ]),
                'active'    =>  true
            ],
            [
                'label'     => 'Шаги',
                'content'   =>  $this->render('_steps', [
                    'form' => $form,
                    'model' => $model,
                    'modelsStep' => $modelsStep,
                    'modelsStepOption' => $modelsStepOption,
                ])
            ],
            [
                'label'     => 'SEO',
                'content'   =>  $this->render('_seo', ['form' => $form, 'model' => $model])
            ],
        ]
    ]);
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

