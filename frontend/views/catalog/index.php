<?php

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
?>
<div class="catalog">
    <div class="container">
        <div class="catalog__inner">
            <?php foreach($products as $item) {
                echo $this->render('@frontend/views/catalog/_item', [
                    'model' => $item
                ]);
            } ?>
        </div>
    </div>
</div>