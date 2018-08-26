<?php

use common\models\Brand;
use common\models\Category;
use kartik\checkbox\CheckboxX;
use kartik\widgets\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;


$model->aksses_ids = json_decode($model->aksses_ids, true);

?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Category',
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

            <?= $form->field($model, 'type')->dropDownList(array_merge(
                ['' => 'Ничего не выбрано'],
                Yii::$app->params['categoryTypes']
            )) ?>

            <?php

            $parents = Category::getCategoryChain($model);
            echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'data' => $parents,
                'options' => ['placeholder' => 'Выберите категорию'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => false
                ],
            ]);

            if (!$model->isNewRecord) {
                if ($model->type == 0) {

                    echo $form->field($model, 'priority')->textInput();

                    echo $form->field($model, 'aksses_ids')->widget(Select2::classname(), [
                        'data' => $parents,
                        'options' => ['placeholder' => 'Выберите категории'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true
                        ],
                    ]);

                    echo $form->field($model, 'text_advice')->widget(\mihaildev\ckeditor\CKEditor::className());

                    echo $form->field($model, 'descr')->textarea();

                    echo $this->render('@backend/views/blocks/image', [
                        'form' => $form,
                        'model' => $model,
                        'image' => $model->image_catalog,
                        'name' => 'image_catalog'
                    ]);

                    echo $this->render('@backend/views/blocks/image', [
                        'form' => $form,
                        'model' => $model,
                        'image' => $model->image_menu,
                        'name' => 'image_menu'
                    ]);

                    echo '<br>';
                    echo $this->render('@backend/views/features/_features', [
                        'form' => $form,
                        'modelsFeature' => $modelsFeature,
                        'modelsFeatureValue' => $modelsFeatureValue,
                        'formId' => 'Category',
                    ]);
                    echo '<br>';

                    echo $form->field($model, 'video')->textInput();

                    echo $form->field($model, 'disallow_xml')->widget(CheckboxX::classname(), [
                        'pluginOptions' => [
                            'threeState'=>false
                        ]
                    ]);

                    echo $form->field($model, 'seo_h1')->textInput(['maxlength' => true]);

                    echo $form->field($model, 'seo_title')->textInput(['maxlength' => true]);

                    echo $form->field($model, 'seo_description')->textarea(['rows' => 6]);

                    echo $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]);
                } else if ($model->type == 1) {

                    echo $form->field($model, 'priority')->textInput();

                    echo $form->field($model, 'text_advice')->widget(\mihaildev\ckeditor\CKEditor::className());

                    echo $form->field($model, 'descr')->textarea();

                    echo $form->field($model, 'video')->textInput();

                    echo $form->field($model, 'seo_h1')->textInput(['maxlength' => true]);

                    echo $form->field($model, 'seo_title')->textInput(['maxlength' => true]);

                    echo $form->field($model, 'seo_description')->textarea(['rows' => 6]);

                    echo $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]);
                } else if ($model->type == 2 || $model->type == 3 || $model->type == 4) {

                    if ($model->type == 2) {

                        echo $form->field($model, 'brand_id')->widget(Select2::classname(), [
                            'data' => \yii\helpers\ArrayHelper::map(
                                Brand::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'
                            ),
                        ]);
                    }

                    echo $form->field($model, 'priority')->textInput();

                    echo $form->field($model, 'text_advice')->widget(\mihaildev\ckeditor\CKEditor::className());

                    echo $form->field($model, 'descr')->textarea();

                    echo $form->field($model, 'video')->textInput();

                    echo $form->field($model, 'disallow_xml')->widget(CheckboxX::classname(), [
                        'pluginOptions' => [
                            'threeState'=>false
                        ]
                    ]);

                    echo $form->field($model, 'seo_h1')->textInput(['maxlength' => true]);

                    echo $form->field($model, 'seo_title')->textInput(['maxlength' => true]);

                    echo $form->field($model, 'seo_description')->textarea(['rows' => 6]);

                    echo $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]);
                }
            }
            ?>
        </p>
        <?php $this->endBlock(); ?>

        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [
                        [
    'label'   => Yii::t('models', 'Category'),
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


<?=$this->render('@backend/views/features/_sortableJs')?>
