<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <a class="logo" href="/officeback/site/index">
        <span class="logo-mini">KSG</span>
        <span class="logo-lg">KSG</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="user">
                    <?php
                    echo Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Выйти (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout', 'style' => 'color: #fff;']
                        )
                        . Html::endForm()
                    ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
