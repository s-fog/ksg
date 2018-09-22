<?php

use common\models\News;
use common\models\Textpage;
use yii\helpers\Url;

$newsPage = Textpage::findOne(13);
$news = News::find()->limit(4)->orderBy(['created_at' => SORT_DESC])->all();

?>
<div class="newsBlock">
    <div class="container">
        <div class="newsBlock__header">свежие новости</div>
        <a href="<?=Url::to(['site/index', 'alias' => $newsPage->alias])?>" class="newsBlock__text"><span>смотреть все новости</span></a>
        <div class="newsBlock__inner">
            <?php foreach($news as $item) {
                echo $this->render('@frontend/views/news/_item', [
                    'model' => $item,
                    'parent' => $newsPage
                ]);
            } ?>
        </div>
    </div>
</div>