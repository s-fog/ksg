<?php

use common\models\Textpage;
use frontend\models\Compare;

$inCompare = Compare::inCompare($model->id);

?>
<a href="<?=($inCompare) ? Textpage::getCompareUrl() : '#'?>"
   class="catalog__itemCompare js-add-to-compare<?=($inCompare) ? ' added' : ''?>"
   data-id="<?=$model->id?>"
   data-url="<?=Textpage::getCompareUrl()?>"
   title="<?=($inCompare) ? 'Перейти к сравнению' : 'Добавить в сравнение'?>">
    <span><?=($inCompare) ? 'Перейти к сравнению' : 'К сравнению'?></span>
    <svg<?=($inCompare) ? ' class="active"' : ''?> xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><path d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/>/svg></a>