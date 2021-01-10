<div class="mobileHeaderPopup__header">
    <?php if ($main === false) { ?>
        <div class="mobileHeaderPopup__headerPrev js-mobile-header-prev" data-ankor="<?=$ankor?>">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 19L5 12L12 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    <?php } ?>
    <div class="mobileHeaderPopup__headerHeader"><?=$header?></div>
    <?php if ($main === false) { ?>
        <div class="mobileHeaderPopup__headerClose js-mobile-header-close">
            <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 15.9184L15.9184 1" stroke="#E83B4B" stroke-width="1.92" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1 1L15.9184 15.9184" stroke="#E83B4B" stroke-width="1.92" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    <?php } ?>
</div>