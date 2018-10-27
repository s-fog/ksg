<?php

use common\models\News;
use common\models\Textpage;
use yii\helpers\Url;
$cache = Yii::$app->cache;

if (!$newsPage = $cache->get('newsPage')){
    $newsPage = Textpage::findOne(13);
    $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM textpage WHERE id = 13']);
    $cache->set('newsPage', $newsPage, null, $dependency);
}

if (!$newsMain = $cache->get('newsMain')){
    $newsMain = News::find()->limit(4)->orderBy(['created_at' => SORT_DESC])->all();
    $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM news ORDER BY updated_at DESC']);
    $cache->set('newsMain', $newsMain, null, $dependency);
}

if (!isset($class)) {
    $class = '';
}

?>
<div class="newsBlock<?=$class?>">
    <div class="container">
        <div class="newsBlock__header">Новое в нашем блоге</div>
        <a href="<?=Url::to(['site/index', 'alias' => $newsPage->alias])?>" class="newsBlock__text"><span>Смотреть все статьи</span></a>
        <div class="newsBlock__inner">
            <?php foreach($newsMain as $item) {
                echo $this->render('@frontend/views/news/_item', [
                    'model' => $item,
                    'parent' => $newsPage
                ]);
            } ?>
        </div>
    </div>
</div>