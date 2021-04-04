<?php if (!empty($href)) { ?>
    <a href="<?=$href?>" class="mobileHeaderPopup__menuItem js-mobile-header-link">
        <?=file_get_contents(Yii::getAlias('@www').'/img/'.$svg)?>
        <span><?=$name?></span>
    </a>
<?php } else { ?>
    <div class="mobileHeaderPopup__menuItem mobileHeaderPopup__menuItem_withChildren js-mobile-header-link"
         data-ankor="<?=$ankor?>"><?=$name?></div>
<?php } ?>