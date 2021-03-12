<?php

use common\models\Brand;
use common\models\Category;
use common\models\Textpage;
use frontend\models\City;
use yii\helpers\Url;

$cache = Yii::$app->cache;
$city = City::getCity();
$array = Yii::$app->params['cities'];
$moscow = $array['Москва'];
$others = $array['Others'];

if ($city == 'Москва') {
    $phone = $moscow['phone'];
    $phoneLink = $moscow['phoneLink'];
} else {
    $phone = $others['phone'];
    $phoneLink = $others['phoneLink'];
}

$firstLevelCategories = Category::getFirstLevelCategories();
$deliveryPage = Textpage::findOne(5);
$paymentsPage = Textpage::findOne(4);
$createPage = Textpage::findOne(19);
$contactsPage = Textpage::findOne(14);
$alphabetBrandList = Brand::getAlphabetList();

$detect = new Mobile_Detect();
?>

<div class="mainHeader">
    <div class="mainHeader__popupTriangle"></div>
    <div class="mainHeader__outer">
        <div class="container">
            <div class="mainHeader__inner">
                <a href="/" class="mainHeader__logo">
                    <img src="/img/logo.svg" alt="" class="mainHeader__logo_desktop">
                    <span>Спортивный гипермаркет</span>
                </a>
                <div class="mainHeader__menuLink mainHeader__menuLink_catalog js-hovered js-triangle js-popup" data-popup="menu">
                    <span>Каталог</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.68 15.68"><defs><style>.cls-1gfdg{fill:none;stroke:#e83b4b;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.92px;}</style></defs><g><line class="cls-1gfdg" x1="0.96" y1="14.72" x2="14.72" y2="0.96"/><line class="cls-1gfdg" x1="0.96" y1="0.96" x2="14.72" y2="14.72"/></g></svg>
                </div>
                <form class="mainHeader__search2" action="<?=Url::to(['site/index', 'alias' => Textpage::findOne(15)->alias])?>" method="GET">
                    <input type="text" name="query" class="mainHeader__search2Input" placeholder="Поиск по сайту">
                    <button class="mainHeader__search2Submit" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg>
                    </button>
                </form>
                <div class="mainHeader__right">
                    <?php /* ?><a href="#" class="mainHeader__contactsItem mainHeader__contactsItem_address js-hovered js-triangle js-popup" data-popup="contacts">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.8 33.2"><g><path d="M11.3,0A11.35,11.35,0,0,0,0,11.3C0,17,9.1,31,10.2,32.6a1.5,1.5,0,0,0,2.4,0c1-1.6,10.2-15.5,10.2-21.3A11.53,11.53,0,0,0,11.3,0Zm0,29.2c-3.1-5-8.5-14.3-8.5-17.9a8.5,8.5,0,0,1,17,0C19.8,14.9,14.5,24.2,11.3,29.2Z"/><path d="M11.3,7.1a4.8,4.8,0,1,0,4.8,4.8A4.74,4.74,0,0,0,11.3,7.1Zm0,6.9a2.1,2.1,0,1,1,2.1-2.1A2.11,2.11,0,0,1,11.3,14Z"/></g></svg>
                        <span class="mainHeader__contactsItemBottom"><?=$city?></span>
                    </a><?php */ ?>
                    <a href="tel:<?=$phoneLink?>" class="mainHeader__contactsItem mainHeader__contactsItem_phone">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.81 20.23"><g>
                                <path d="M16.92,4.12a2.93,2.93,0,0,0,.33-1.28,2.64,2.64,0,0,0-.93-2A3.29,3.29,0,0,0,14,0a3.92,3.92,0,0,0-2,.54,2,2,0,0,0-.26.2,1.55,1.55,0,0,0,.5,2.54h0l.2-.43A1.4,1.4,0,0,1,13,2.2a1.93,1.93,0,0,1,2,0,.69.69,0,0,1,.31.59,1.57,1.57,0,0,1-.6,1.09L11.49,7A2.09,2.09,0,0,0,11,9.36h5.24a1,1,0,0,0,1-1h0a1,1,0,0,0-1-1H13.16l2.93-2.11A4.4,4.4,0,0,0,16.92,4.12Z"/>
                                <path d="M24.16,5.42V1.86A1.74,1.74,0,0,0,22.42.12h0L17.69,5.94h0A3.36,3.36,0,0,0,20.4,7.31h1.8V8.37a1,1,0,0,0,1,1h0a1,1,0,0,0,1-1V7.31h.65V5.42Zm-4.49.06,2.58-3.05V5.48Z"/>
                                <path d="M14.65,20.23H14.6a17.35,17.35,0,0,1-10.35-4.8A15.12,15.12,0,0,1,0,4.91,5.57,5.57,0,0,1,4.92,0,4.2,4.2,0,0,1,6.43,8.14a15.44,15.44,0,0,0,2.19,3.42,14.93,14.93,0,0,0,3.24,2.14A4.2,4.2,0,0,1,20,15.12C20,17.36,17,20.23,14.65,20.23ZM4.92,1.94a3.7,3.7,0,0,0-3,3A13.42,13.42,0,0,0,5.6,14.07a15.51,15.51,0,0,0,9.08,4.24c1.32,0,3.42-2,3.42-3.19a2.28,2.28,0,0,0-4.56,0,1,1,0,0,1-.44.8,1,1,0,0,1-.92.07,20.35,20.35,0,0,1-4.91-3.07,20.71,20.71,0,0,1-3.1-5.08A.94.94,0,0,1,4.24,7,1,1,0,0,1,5,6.5a2.28,2.28,0,0,0-.09-4.56Z"/></g></svg>
                        <span class="mainHeader__contactsItemTop">Бесплатный звонок по России</span>
                        <span class="mainHeader__contactsItemBottom"><?=$phone?></span>
                    </a>
                    <div class="mainHeader__cart not_empty favourite js-triangle js-popup" data-popup="cart">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.3 37.1"><g class="favourite" style="display: none;"><path d="M18.1,17.1a3.43,3.43,0,0,0-2.3.9,4.06,4.06,0,0,0-2.6-.9c-1.5,0-3.7,1.2-3.7,4.3,0,3.4,4.6,7.5,5.5,8.2a1.5,1.5,0,0,0,1.8,0c.9-.8,5.5-4.9,5.5-8.2A4.14,4.14,0,0,0,18.1,17.1Zm-2.2,9.6c-1.7-1.6-3.6-4-3.6-5.3s.5-1.5.9-1.5c1.1,0,1.3.9,1.3,1.5h0a1.4,1.4,0,0,0,2.8,0s0-1.5.8-1.5,1.4.3,1.4,1.5S17.6,25,15.9,26.7Z"/></g><g class="not_empty"><path d="M19.4,14.5A1.37,1.37,0,0,0,18,15.9V31.1a1.4,1.4,0,0,0,2.8,0V15.9A1.43,1.43,0,0,0,19.4,14.5Z"/><path d="M15.7,19.8a1.37,1.37,0,0,0-1.4,1.4v9.9a1.4,1.4,0,1,0,2.8,0V21.2A1.43,1.43,0,0,0,15.7,19.8Z"/><path d="M11.9,25a1.37,1.37,0,0,0-1.4,1.4v4.7a1.4,1.4,0,0,0,2.8,0V26.4A1.43,1.43,0,0,0,11.9,25Z"/></g><path d="M7.6,8.7A1.37,1.37,0,0,0,9,7.3a4.5,4.5,0,0,1,9,0,1.4,1.4,0,0,0,2.8,0,7.3,7.3,0,0,0-14.6,0A1.51,1.51,0,0,0,7.6,8.7Z"/><path d="M26.1,11.2a1.35,1.35,0,0,0-1.4-1.3H2.6a1.42,1.42,0,0,0-1.4,1.3L0,35.7a1.16,1.16,0,0,0,.4,1,1.28,1.28,0,0,0,1,.4H25.9a1.78,1.78,0,0,0,1-.4,1.28,1.28,0,0,0,.4-1ZM3.9,12.7h.6l1,21.7H2.9ZM8.3,34.4l-1-21.7H23.4l1,21.7Z"/></svg>
                    </div>
                </div>
            </div>
            <div class="mainHeader__hovered"></div>
            <div class="mainHeader__search2Mobile">
                <form class="mainHeader__search2" action="<?=Url::to(['site/index', 'alias' => Textpage::findOne(15)->alias])?>" method="GET">
                    <input type="text" name="query" class="mainHeader__search2Input" placeholder="Поиск по сайту">
                    <button class="mainHeader__search2Submit" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg>
                    </button>
                </form>
                <a href="/cart" class="mainHeader__cart not_empty">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.3 37.1"><g class="favourite" style="display: none;"><path d="M18.1,17.1a3.43,3.43,0,0,0-2.3.9,4.06,4.06,0,0,0-2.6-.9c-1.5,0-3.7,1.2-3.7,4.3,0,3.4,4.6,7.5,5.5,8.2a1.5,1.5,0,0,0,1.8,0c.9-.8,5.5-4.9,5.5-8.2A4.14,4.14,0,0,0,18.1,17.1Zm-2.2,9.6c-1.7-1.6-3.6-4-3.6-5.3s.5-1.5.9-1.5c1.1,0,1.3.9,1.3,1.5h0a1.4,1.4,0,0,0,2.8,0s0-1.5.8-1.5,1.4.3,1.4,1.5S17.6,25,15.9,26.7Z"/></g><g class="not_empty"><path d="M19.4,14.5A1.37,1.37,0,0,0,18,15.9V31.1a1.4,1.4,0,0,0,2.8,0V15.9A1.43,1.43,0,0,0,19.4,14.5Z"/><path d="M15.7,19.8a1.37,1.37,0,0,0-1.4,1.4v9.9a1.4,1.4,0,1,0,2.8,0V21.2A1.43,1.43,0,0,0,15.7,19.8Z"/><path d="M11.9,25a1.37,1.37,0,0,0-1.4,1.4v4.7a1.4,1.4,0,0,0,2.8,0V26.4A1.43,1.43,0,0,0,11.9,25Z"/></g><path d="M7.6,8.7A1.37,1.37,0,0,0,9,7.3a4.5,4.5,0,0,1,9,0,1.4,1.4,0,0,0,2.8,0,7.3,7.3,0,0,0-14.6,0A1.51,1.51,0,0,0,7.6,8.7Z"/><path d="M26.1,11.2a1.35,1.35,0,0,0-1.4-1.3H2.6a1.42,1.42,0,0,0-1.4,1.3L0,35.7a1.16,1.16,0,0,0,.4,1,1.28,1.28,0,0,0,1,.4H25.9a1.78,1.78,0,0,0,1-.4,1.28,1.28,0,0,0,.4-1ZM3.9,12.7h.6l1,21.7H2.9ZM8.3,34.4l-1-21.7H23.4l1,21.7Z"/></svg>
                </a>
            </div>
        </div>
    </div>
    <div class="mainHeader__popup <?= $detect->isMobile() || $detect->isTablet() ? ' mobile' : '' ?>" data-popup="menu">
        <div class="mainHeader__popupOuter">
            <?php if ($detect->isMobile() || $detect->isTablet()) { ?>
                <div class="mobileHeaderPopup">
                    <div class="mobileHeaderPopup__item js-mobile-header-item active" data-ankor="main">
                        <ul class="mobileHeaderPopup__menu">
                            <li>
                                <?=$this->render('_mobile/_link', [
                                    'name' => 'Каталог',
                                    'ankor' => 'catalog',
                                    'href' => '',
                                    'haveChildren' => true,
                                ])?>
                            </li>
                            <li>
                                <?=$this->render('_mobile/_link', [
                                    'name' => $deliveryPage->name,
                                    'ankor' => '',
                                    'href' => $deliveryPage->url
                                ])?>
                            </li>
                            <li>
                                <?=$this->render('_mobile/_link', [
                                    'name' => $paymentsPage->name,
                                    'ankor' => '',
                                    'href' => $paymentsPage->url
                                ])?>
                            </li>
                            <li>
                                <?=$this->render('_mobile/_link', [
                                    'name' => $createPage->name,
                                    'ankor' => '',
                                    'href' => $createPage->url
                                ])?>
                            </li>
                            <li>
                                <?=$this->render('_mobile/_link', [
                                    'name' => $contactsPage->name,
                                    'ankor' => '',
                                    'href' => $contactsPage->url
                                ])?>
                            </li>
                        </ul>
                    </div>
                    <div class="mobileHeaderPopup__item js-mobile-header-item" data-ankor="catalog">
                        <?=$this->render('_mobile/_header', [
                            'header' => 'Каталог',
                            'ankor' => 'main',
                            'main' => false
                        ])?>
                        <ul class="mobileHeaderPopup__menu">
                            <?php foreach($firstLevelCategories as $index => $firstLevelCategory) { ?>
                                <li>
                                    <?php if (!empty(Category::getSecondLevelCategories($firstLevelCategory))) { ?>
                                        <?=$this->render('_mobile/_link', [
                                            'name' => $firstLevelCategory->name,
                                            'ankor' => 'category-'.$firstLevelCategory->id,
                                            'href' => ''
                                        ])?>
                                    <?php } else { ?>
                                        <?=$this->render('_mobile/_link', [
                                            'name' => $firstLevelCategory->name,
                                            'ankor' => '',
                                            'href' => $firstLevelCategory->url
                                        ])?>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                            <li>
                                <?=$this->render('_mobile/_link', [
                                    'name' => 'Поиск по брендам',
                                    'ankor' => 'brands',
                                    'href' => ''
                                ])?>
                            </li>
                        </ul>
                    </div>
                    <?php foreach($firstLevelCategories as $index => $firstLevelCategory) { ?>
                        <div class="mobileHeaderPopup__item js-mobile-header-item" data-ankor="category-<?=$firstLevelCategory->id?>">
                            <?=$this->render('_mobile/_header', [
                                'header' => $firstLevelCategory->name,
                                'ankor' => 'catalog',
                                'main' => false
                            ])?>
                            <ul class="mobileHeaderPopup__menu">
                                <?php foreach(Category::getSecondLevelCategories($firstLevelCategory) as $secondLevelCategory) { ?>
                                    <li>
                                        <?php if (!empty(Category::getThirdLevelCategories($secondLevelCategory))) { ?>
                                            <?=$this->render('_mobile/_link', [
                                                'name' => $secondLevelCategory->name,
                                                'ankor' => 'category-'.$secondLevelCategory->id,
                                                'href' => ''
                                            ])?>
                                        <?php } else { ?>
                                            <?=$this->render('_mobile/_link', [
                                                'name' => $secondLevelCategory->name,
                                                'ankor' => '',
                                                'href' => $secondLevelCategory->url
                                            ])?>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <?php foreach($firstLevelCategories as $index => $firstLevelCategory) { ?>
                        <?php foreach(Category::getSecondLevelCategories($firstLevelCategory) as $secondLevelCategory) { ?>
                            <div class="mobileHeaderPopup__item js-mobile-header-item" data-ankor="category-<?=$secondLevelCategory->id?>">
                                <?=$this->render('_mobile/_header', [
                                    'header' => $secondLevelCategory->name,
                                    'ankor' => 'category-'.$firstLevelCategory->id,
                                    'main' => false
                                ])?>
                                <ul class="mobileHeaderPopup__menu">
                                    <?php foreach(Category::getThirdLevelCategories($secondLevelCategory) as $thirdLevelCategory) { ?>
                                        <?=$this->render('_mobile/_link', [
                                            'name' => $thirdLevelCategory->name,
                                            'ankor' => '',
                                            'href' => $thirdLevelCategory->url
                                        ])?>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="mobileHeaderPopup__item js-mobile-header-item" data-ankor="brands">
                        <?=$this->render('_mobile/_header', [
                            'header' => 'Поиск по бредам',
                            'ankor' => 'catalog',
                            'main' => false
                        ])?>

                        <?php foreach($alphabetBrandList as $letter => $notUse) { ?>
                            <div class="alphabet__content">
                                <div class="alphabet__contentHeader"><?=$letter?></div>
                                <div class="brands__listInner">
                                    <?php foreach($alphabetBrandList[$letter] as $brand) { ?>
                                        <a href="<?=$brand->url?>" class="brands__listItem"><span><?=$brand->name?></span></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="container">
                    <div class="mainHeader__popupInner">
                        <div class="mainHeader__popupLeft">
                            <div class="mainHeader__popupCatalogHeader">Каталог</div>
                            <div class="mainHeader__popupCatalogLinks">
                                <?php foreach($firstLevelCategories as $index => $firstLevelCategory) { ?>
                                    <?=$index === 0 ? '' : '<br>' ?>
                                        <?php if (!empty(Category::getSecondLevelCategories($firstLevelCategory))) { ?>
                                        <div data-ankor="<?=$firstLevelCategory->id?>"
                                        class="mainHeader__popupCatalogLink js-main-header-popup-link<?=$index === 0 ? ' active' : ''?>">
                                            <?=$firstLevelCategory->name?>
                                        </div>
                                        <?php } else { ?>
                                            <a href="<?=$firstLevelCategory->url?>" class="mainHeader__popupCatalogLink">
                                                <?=$firstLevelCategory->name?>
                                            </a>
                                        <?php } ?>
                                <?php } ?>
                                <br>
                                <div data-ankor="brands"
                                     class="mainHeader__popupCatalogLink js-main-header-popup-link">
                                    Поиск по брендам
                                </div>
                            </div>
                            <div class="mainHeader__popupOtherLinks">
                                <a href="<?=$deliveryPage->url?>" class="mainHeader__popupOtherLink"><span><?=$deliveryPage->name?></span></a>
                                <a href="<?=$paymentsPage->url?>" class="mainHeader__popupOtherLink"><span><?=$paymentsPage->name?></span></a>
                                <a href="<?=$createPage->url?>" class="mainHeader__popupOtherLink"><span><?=$createPage->name?></span></a>
                                <a href="<?=$contactsPage->url?>" class="mainHeader__popupOtherLink"><span><?=$contactsPage->name?></span></a>
                            </div>
                        </div>
                        <div class="mainHeader__popupRight">
                            <?php foreach($firstLevelCategories as $index => $firstLevelCategory) { ?>
                                <div data-ankor="<?=$firstLevelCategory->id?>"
                                     class="mainHeader__popupContent js-main-header-popup-content <?=$index === 0 ? ' active' : ''?>">
                                    <?php foreach(Category::getSecondLevelCategories($firstLevelCategory) as $secondLevelCategory) { ?>
                                        <div class="mainHeader__popupMenuItem">
                                            <a href="<?=$secondLevelCategory->url?>"
                                               class="mainHeader__popupMenuItemHeader"><span><?=$secondLevelCategory->name?></span></a>
                                            <ul class="mainHeader__popupMenuItemMenu">
                                                <?php foreach(Category::getThirdLevelCategories($secondLevelCategory) as $thirdLevelCategory) { ?>
                                                    <li>
                                                        <a href="<?=$thirdLevelCategory->url?>"
                                                           class="mainHeader__popupMenuItemMenuLink">
                                                            <span><?=$thirdLevelCategory->name?></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div data-ankor="brands"
                                 class="mainHeader__popupContent js-main-header-popup-content <?=$index === 0 ? ' active' : ''?>">
                                <?php foreach($alphabetBrandList as $letter => $notUse) { ?>
                                    <div class="alphabet__content">
                                        <div class="alphabet__contentHeader"><?=$letter?></div>
                                        <div class="brands__listInner">
                                            <?php foreach($alphabetBrandList[$letter] as $brand) { ?>
                                                <a href="<?=$brand->url?>" class="brands__listItem"><span><?=$brand->name?></span></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!--<div class="mainHeader__popupOuter" style="padding-bottom: 0;">
            <div class="container">
                <div class="mainHeader__popupMenuInner">
                    <svg class="mainHeader__popupMenuPicked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89 3"><title>some-2</title><polygon points="1.7 0 0 1.4 0 3 87.3 3 89 1.5 89 0 1.7 0"/></svg>
                    <div class="mainHeader__popupMenuTabs">
                        <?php

        foreach($firstLevelCategories as $index => $firstLevelCategory) {
            $active = '';

            if ($index == 0) {
                $active = ' active';
            }

            echo '<div class="mainHeader__popupMenuTab'.$active.'"><span>'.$firstLevelCategory->name.'</span></div>';
        }
        ?>
                    </div>
                    <div class="mainHeader__popupMenuContent">
                        <?php
        foreach($firstLevelCategories as $index => $firstLevelCategory) {
            $active = '';

            if ($index == 0) {
                $active = ' active';
            }
            echo '<div class="mainHeader__popupMenuItems'.$active.'">';

            foreach(Category::getSecondLevelCategories($firstLevelCategory) as $secondLevelCategory) {?>
                                <div class="mainHeader__popupMenuItem">
                                    <a href="<?=$secondLevelCategory->url?>" class="mainHeader__popupMenuItemHeader"><span><?=$secondLevelCategory->name?></span></a>
                                    <ul class="mainHeader__popupMenuItemMenu">
                                        <?php foreach(Category::getThirdLevelCategories($secondLevelCategory) as $index => $thirdLevelCategory) {
                $active = '';
                $url = $thirdLevelCategory->url;

                if ($_SERVER['REQUEST_URI'] == $url) {
                    $active = ' active';
                }
                ?>
                                            <li><a href="<?=$url?>" class="mainHeader__popupMenuItemMenuLink<?=$active?>"><?=$thirdLevelCategory->name?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                        <?php
            }

            echo '</div>';
        }
        ?>
                    </div>
                </div>
            </div>
            <div class="mainHeader__popupMenuBottom">
                <div class="container">
                    <div class="mainHeader__popupMenuBottomInner">
                        <ul class="mainHeader__popupMenuBottomMiddle">
                            <li><a href="<?=Textpage::findOne(1)->url?>" class="mainHeader__popupMenuBottomMiddleLink">В полный каталог</a></li>
                            <li><a href="<?=Textpage::findOne(2)->url?>" class="mainHeader__popupMenuBottomMiddleLink">Поиск по брендам</a></li>
                        </ul>
                        <div class="button button1 callbackButton" data-fancybox data-src="#callback">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
                            <span>заказать обратный звонок</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <?=$this->render('_mainHeader__popup_contacts')?>
    <div class="mainHeader__popup mainHeader__popupCart" data-popup="cart">
        <?=$this->render('@frontend/views/cart/_minicart')?>
    </div>
    <div class="mainHeader__popup mainHeader__popupSearch" data-popup="search">
        <div class="mainHeader__popupOuter">
            <div class="mainHeader__popupSearchInner">
                <div class="mainHeader__popupSearchHeader">Быстрые ссылки</div>
                <div class="mainHeader__popupSearchItem"><span>Беговая дорожка</span></div>
                <div class="mainHeader__popupSearchItem"><span>Matrix</span></div>
                <div class="mainHeader__popupSearchItem"><span>Доставка</span></div>
                <div class="mainHeader__popupSearchItem"><span>Способы оплаты</span></div>
                <div class="mainHeader__popupSearchItem"><span>Контакты</span></div>
            </div>
        </div>
    </div>
    <div class="mainHeader__popupSuccessTriangle"></div>
    <div class="mainHeader__popupSuccess mainHeader__popupSuccess_cart">
        <div class="mainHeader__popupSuccessText">Добавлено в корзину</div>
    </div>
    <div class="mainHeader__popupSuccess mainHeader__popupSuccess_compare">
        <div class="mainHeader__popupSuccessText">Добавлено к сравнению</div>
    </div>
    <div class="mainHeader__popupSuccess mainHeader__popupSuccess_compareAlready">
        <div class="mainHeader__popupSuccessText">Товар уже в сравнении</div>
    </div>
    <div class="mainHeader__popupSuccess mainHeader__popupSuccess_favourite">
        <div class="mainHeader__popupSuccessText">Добавлено в избранное</div>
    </div>
    <div class="mainHeader__popupSuccess mainHeader__popupSuccess_favouriteAlready">
        <div class="mainHeader__popupSuccessText">Товар уже в избранном</div>
    </div>
</div>
