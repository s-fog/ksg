<?php
use common\models\Brand;
use common\models\Textpage;
use yii\helpers\Url;
?>
<div class="brands">
    <div class="container">
        <div class="brands__header">бренды-партёры KSG</div>
        <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(2)->alias])?>" class="brands__link linkSpan"><span>смотреть все бренды</span></a>
        <div class="brands__inner owl-carousel">
            <?php foreach(Brand::find()->orderBy(['sort_order' => SORT_DESC])->limit(15)->all() as $item) {
                echo $this->render('@frontend/views/brand/_item', [
                    'model' => $item
                ]);
            } ?>
        </div>
    </div>
</div>