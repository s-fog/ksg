<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Product $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Product',
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
                    'modelsFeature' => $modelsFeature,
                    'modelsFeatureValue' => $modelsFeatureValue,
                ]),
                'active'    =>  true
            ],
            [
                'label'     => 'Изображения',
                'content'   =>  $this->render('_images', [
                    'form' => $form,
                    'model' => $model,
                    'modelsImage' => $modelsImage,
                ])
            ],
            [
                'label'     => 'Варианты',
                'content'   =>  $this->render('_params', [
                    'form' => $form,
                    'model' => $model,
                    'modelsImage' => $modelsImage,
                    'modelsParams' => $modelsParams,
                ])
            ],
            [
                'label'     => 'Фильтр',
                'content'   =>  $this->render('_filter', [
                    'form' => $form,
                    'model' => $model,
                ])
            ],
            [
                'label'     => 'Отзывы',
                'content'   =>  $this->render('_reviews', [
                    'form' => $form,
                    'model' => $model,
                    'modelsReview' => $modelsReview,
                ])
            ],
            [
                'label'     => 'SEO',
                'content'   =>  $this->render('_seo', ['form' => $form, 'model' => $model])
            ],
            [
                'label'     => 'Доп. функции',
                'content'   =>  $this->render('_additional_options', ['form' => $form, 'model' => $model])
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
            'class' => 'btn btn-success',
            'name' => 'mode',
            'value' => 'justSave'
        ]
    );
    ?>
    <?=Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Создать и выйти' : 'Сохранить и выйти'),
        [
            'class' => 'btn btn-success',
            'name' => 'mode',
            'value' => 'saveAndExit'
        ]
    );?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

