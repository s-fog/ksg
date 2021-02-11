<?php
use kartik\widgets\FileInput;
use yii\helpers\Html;
echo '<div style="margin: 15px 0;border: 1px solid #000;border-radius: 10px;padding: 10px;">';
if ($image) {
    echo '
                <div class="form-group">
                    <div>
                        ' . Html::img(Yii::$app->params['frontendHost'].$image, ['width' => 250]) . '
                    </div>
                </div>
                ';
}

echo $form->field($model, $name)->widget(FileInput::className(), [
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
