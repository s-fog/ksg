<?php

$cookies = Yii::$app->request->cookies;

?>
<div class="filterTrigger active">
    <div class="container">
        <ul class="filterTrigger__top breadcrumbs__inner">
            <li>
                <a href="#" class="filterTrigger__topItem js-filter-open breadcrumbs__item">
                    <em class="filterTrigger__openPlus"></em>
                    <span>Фильтр</span>
                    <span class="filterTrigger__topItemCount">{по выбраным параметрам ничего не найдено}</span>
                </a>
            </li>
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
        </ul>
    </div>
</div>
