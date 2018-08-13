<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<?=$this->render('_head')?>

<body>
<?php $this->beginBody() ?>

<?=$this->render('_header')?>

<?=$content?>

<?=$this->render('_footer')?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
