<?php
$filename = explode('.', basename($model->image));
?>
<div class="brands__item">
    <a href="<?=$model->url?>" class="brands__itemImage"><img src="/images/thumbs/<?=$filename[0]?>-280-140.<?=$filename[1]?>" alt=""></a>
    <div class="brands__itemText"><?=$model->description?></div>
    <a href="<?=$model->url?>" class="brands__itemLink">
        <span><?=(isset($header) ? "смотреть $header {$model->name} ––>" : 'на страницу товаров бренда ––>')?></span>
    </a>
</div>
