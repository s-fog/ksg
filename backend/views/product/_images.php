<?php
use kartik\widgets\FileInput;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_images', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-images', // required: css class selector
    'widgetItem' => '.images-item', // required: css class
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-images', // css class
    'deleteButton' => '.remove-images', // css class
    'model' => $modelsImage[0],
    'formId' => 'Product',
    'formFields' => [
        'image',
        'text',
    ],
]); ?>
        <div class="panel panel-default">
            <div class="panel-heading" style="height: 45px;">
                <h4 style="float: left;margin: 0;"><i class="glyphicon glyphicon-envelope"></i> Изображения</h4>
                <div class="pull-right">
                    <button type="button" class="add-images btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
            </div>
            <div class="panel-body">
                <div class="container-images"><!-- widgetContainer -->
                    <?php foreach ($modelsImage as $i => $modelImage): ?>
                        <div class="images-item panel panel-default" data-id="<?=$modelImage->id?>"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Изображение, номер <b><?=$i?></b></h3>
                                <div class="pull-right">
                                    <button type="button" class="remove-images btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    if (! $modelImage->isNewRecord) {
                                        echo Html::activeHiddenInput($modelImage, "[{$i}]id");
                                    }
                                ?>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <?=Html::img(Yii::$app->params['frontendHost'].$modelImage->image, ['width' => 250])?>
                                    </div>
                                    <div class="col-sm-9">
                                        <?=$form->field($modelImage, "[{$i}]image")->widget(FileInput::className(), [
                                            'pluginOptions' => [
                                                'showCaption' => false,
                                                'showRemove' => false,
                                                'showUpload' => false,
                                                'browseClass' => 'btn btn-primary btn-block',
                                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
                                                'browseLabel' =>  'Выберите изображение'
                                            ],
                                            'options' => ['accept' => 'image/*']
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <?= $form->field($modelImage, "[{$i}]text")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="panel-heading" style="height: 45px;padding: 10px 0 0 0;">
                    <div class="pull-right">
                        <button type="button" class="add-images btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
<?php DynamicFormWidget::end(); ?>