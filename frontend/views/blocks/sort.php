<?php

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
        <?php }
        $per_page = 0;
        if (isset($_GET['per_page']))
            $per_page = $_GET['per_page'];
        ?>
        <form action="" method="get" class="sorting">
            <div class="sorting__perpage">
                <span class="sorting__text">показывать по </span>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="40"
                        <?=($per_page == 40 || $per_page == 0) ? ' checked' : ''?>>
                    <span>40</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="80"
                        <?=($per_page == 80) ? ' checked' : ''?>>
                    <span>80</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="120"
                        <?=($per_page == 120) ? ' checked' : ''?>>
                    <span>120</span>
                </label>
            </div>
            <div class="sorting__delimiter">|</div>
            <div class="sorting__sort">
                <span class="sorting__text">сортировать</span>
                <select name="sort" class="select-jquery-ui">
                    <?php if ($level === 3) { ?>
                        <option value="popular_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'popular_desc') ? ' selected' : ''?>>
                            по популярности</option>
                        <option value=""<?=(!isset($_GET['sort'])) ? ' selected' : ''?>>
                            сначала дешевле</option>
                        <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>
                            сначала дороже</option>
                    <?php } else { ?>
                        <option value=""<?=(!isset($_GET['sort'])) ? ' selected' : ''?>>
                            по популярности</option>
                        <option value="price_asc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? ' selected' : ''?>>
                            сначала дешевле</option>
                        <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>
                            сначала дороже</option>
                    <?php } ?>
                </select>
            </div>
        </form>
    </div>
</div>