<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\SurveyForm $model
*/

$this->title = Yii::t('models', 'Survey Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Survey Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud survey-form-create">

    <h1>
        <?= Yii::t('models', 'Survey Form') ?>
        <small>
                        <?= Html::encode($model->id) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
