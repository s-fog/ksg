<?php
use yii\helpers\Url;

$url = Url::to(['site/index', 'alias' => $parent->alias, 'alias2' => $model->alias]);
$filename = explode('.', basename($model->image));
?>
<div class="newsBlock__item">
    <a href="<?=$url?>" class="newsBlock__itemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-260-150.<?=$filename[1]?>);">
        <span class="newsBlock__itemDate"><span></span><?=date('d.m.Y', $model->created_at)?></span>
        <span class="newsBlock__itemRead"><span>Читать дальше</span></span>
    </a>
    <div class="newsBlock__itemInfo">
        <a href="<?=$url?>" class="newsBlock__itemHeader"><span><?=$model->name?></span></a>
        <div class="newsBlock__itemText"><?=$model->introtext?></div>
    </div>
</div>