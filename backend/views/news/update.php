<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\News $model
*/

$this->title = Yii::t('models', 'News') . ' Редактирование';
?>
<div class="giiant-crud news-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
