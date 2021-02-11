<?php
if (!empty($childrenCategories) || (isset($inCategories) &&
        !empty($inCategories) &&
        count($inCategories) > 1 &&
        (isset($childrenCategories) && empty($childrenCategories)))) {
?>
    <div class="category">
        <div class="container">
            <?php if (isset($childrenCategories) && !empty($childrenCategories)) { ?>
                <div class="category__slider owl-carousel">
                    <?php foreach($childrenCategories as $childrenCategory) {
                        $filename = explode('.', basename($childrenCategory->image_menu));

                        if (empty($filename[1])) {
                            $filename[1] = '';
                        }
                        ?>
                        <a href="<?=$childrenCategory->url?>" class="category__sliderItem">
                            <span class="category__sliderItemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-134-134.<?=$filename[1]?>);"></span>
                            <span class="category__sliderItemName"><span><?=$childrenCategory->name?></span></span>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (isset($inCategories) &&
                !empty($inCategories) &&
                count($inCategories) > 1 &&
                (isset($childrenCategories) && empty($childrenCategories))) { ?>
                <div class="category__slider owl-carousel">
                    <?php foreach($inCategories as $inCategory) {
                        $filename = explode('.', basename($inCategory->image_menu));

                        if (empty($filename[1])) {
                            $filename[1] = '';
                        }

                        ?>
                        <a href="<?=$inCategory->url?>?brands[]=<?=$brand->id?>" class="category__sliderItem">
                            <span class="category__sliderItemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-134-134.<?=$filename[1]?>);"></span>
                            <span class="category__sliderItemName"><span><?=$inCategory->name?></span></span>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>