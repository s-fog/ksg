<?php
$filename = explode('.', basename($model->image));
?>
<div class="brands__item">
    <a href="<?=$model->link?>" class="brands__itemImage"><img src="/images/thumbs/<?=$filename[0]?>-280-140.<?=$filename[1]?>" alt=""></a>
    <div class="brands__itemText"><?=$model->name?></div>
    <a href="<?=$model->link?>" class="brands__itemLink"><span>на страницу товаров бренда ––></span></a>
</div>
