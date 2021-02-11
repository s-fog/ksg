<?php

use common\models\Category;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

?>

<div class="catalogPage">
    <?php foreach($firstLevelCategories = Category::find()
        ->where(['parent_id' => 0, 'type' => 0, 'active' => 1])
        ->orderBy(['sort_order' => SORT_DESC])
        ->all() as $firstLevelCategory) {
        $filename = explode('.', basename($firstLevelCategory->image_catalog));

        if (empty($filename[1])) {
            $filename[1] = '';
        }

        $secondLevelCategories = Category::find()
            ->where(['parent_id' => $firstLevelCategory->id, 'type' => 0, 'active' => 1])
            ->orderBy(['sort_order' => SORT_DESC])
            ->all();
        ?>
        <div class="catalogPage__item">
            <a href="<?=$firstLevelCategory->url?>" class="catalogPage__header" style="background-image: url(/images/thumbs/<?=$filename[0]?>-1600-250.<?=$filename[1]?>);">
                <span class="header"><span><?=$firstLevelCategory->name?></span></span>
            </a>
            <div class="container">
                <div class="mainHeader__popupMenuItems">
                    <?php foreach($secondLevelCategories as $secondLevelCategory) {
                            $thirdLevelCategories = Category::find()
                                ->where(['parent_id' => $secondLevelCategory->id, 'type' => 0, 'active' => 1])
                                ->orderBy(['sort_order' => SORT_DESC])
                                ->all();
                    ?>
                    <div class="mainHeader__popupMenuItem">
                        <a href="<?=$secondLevelCategory->url?>" class="mainHeader__popupMenuItemHeader"><span><?=$secondLevelCategory->name?></span></a>
                        <ul class="mainHeader__popupMenuItemMenu">
                            <?php foreach($thirdLevelCategories as $index => $thirdLevelCategory) { ?>
                                <li><a href="<?=$thirdLevelCategory->url?>" class="mainHeader__popupMenuItemMenuLink active"><?=$thirdLevelCategory->name?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
