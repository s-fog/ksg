<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\News $model
*/

$this->title = Yii::t('models', 'News');
?>
<div class="giiant-crud news-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
