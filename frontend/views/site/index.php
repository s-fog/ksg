<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
?>

<div class="mainSlider owl-carousel">
    <?php foreach(Mainslider::find()->orderBy(['sort_order' => SORT_DESC])->all() as $item) {
        $filename = explode('.', basename($item->image));
        ?>
        <div class="mainSlider__item" style="background-image: url(/images/thumbs/<?=$filename[0]?>-1942-438.<?=$filename[1]?>);">
            <div class="container">
                <div class="mainSlider__itemInner">
                    <div class="mainSlider__itemHeader"><?=$item->header?></div>
                    <div class="mainSlider__itemText"><?=$item->text?></div>
                    <?php if (!empty($item->link)) { ?>
                        <a href="<?=$item->link?>" class="button button4 mainSlider__itemMore">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 34"><g><polygon class="cls-1" points="108.93 0 14.43 0 8.13 0 0 6.73 0 34 14.49 34 109 34 131.87 34 140 27.27 140 0 108.93 0"/></g></svg>
                            <span>подробнее</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="hits">
    <div class="container">
        <div class="header">Хиты продаж</div>
        <div class="hits__text">Эти вещи расхватывают как горячие пирожки<br>
            не просто так: это действительно класные предложения,<br>
            именно по этому мы придержали их для вас</div>
        <div class="catalog">
            <div class="catalog__inner">
                <?php foreach(Product::find()->where(['hit' => 1])->limit(6)->all() as $item) {
                    echo $this->render('@frontend/views/catalog/_item', [
                        'model' => $item
                    ]);
                } ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="wantMore">
            <div class="wantMore__text">Не нашли нужное? Попробуйте <span class="wantMore__load">загрузить ещё</span> или</div>
            <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(1)->alias])?>" class="button button3 wantMore__toCatalog">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"/></g></svg>
                <span>Перейти в каталог</span>
            </a>
        </div>
    </div>
</div>

<div class="infoBlock">
    <div class="container">
        <div class="header header_white">самый спортивный магазин</div>
        <div class="infoBlock__inner">
            <div class="infoBlock__item">
                <div class="infoBlock__itemHeader">74 БРЕНДА И<br>
                    3240 ТОВАРОВ</div>
                <div class="infoBlock__itemText">Наш ассортимент спортивного оборудования
                    и инвентаря <span class="heavyCaps" style="font-style: italic;">полностью перекрывает</span>
                    потребность, как частных, так и
                    корпоративных клиентов, среди которых:
                    фитнес-клубы,оздоровительные учереждения
                    и многие другие.</div>
            </div>
            <div class="infoBlock__item">
                <div class="infoBlock__itemHeader">КВАЛИФИЦИРОВАННАЯ<br>
                    ПОДДЕРЖКА</div>
                <div class="infoBlock__itemText">В штате нашей поддержки трудятся
                    только квалифицированные эксперты.
                    Будьте уверены, мы сможем предложить
                    то, что вам действительно подойдет. Оставьте
                    <a href="#" class="lightRedColor link" data-fancybox data-src="#callback">заявку на обратный звонок</a>, эксперт KSG
                    перезвонит и подробно вас проконсультирует.</div>
            </div>
            <div class="infoBlock__item">
                <div class="infoBlock__itemHeader">ГАРАНТИЯ ЛУЧШЕЙ<br>
                    ЦЕНЫ</div>
                <div class="infoBlock__itemText">Нашли товар дешевле? Сообщите
                    нам, мы проверим актуальность цены на
                    сайте где она была обнаружена и если это
                    не ошибка, то <span class="heavyCaps" style="font-style: italic;">предложим цену меньше</span>
                    чем та, которую вы нашли.
                    Дешевле не бывает!</div>
            </div>
        </div>
    </div>
</div>

<div class="popular">
    <div class="container">
        <div class="header">Популярные товары</div>
        <div class="popular__inner">
            <a href="/catalog/trenazhery/kardiotrenazhery/begovye-dorozhki" class="popular__item">
                <span class="popular__itemText">Беговые дорожки</span>
                <span class="popular__itemImage" style="background-image: url(/img/begovie.jpg);"></span>
            </a>
            <a href="/catalog/trenazhery/kardiotrenazhery/velotrenazhery" class="popular__item">
                <span class="popular__itemText">Велотренажеры</span>
                <span class="popular__itemImage" style="background-image: url(/img/velo.jpg);"></span>
            </a>
            <a href="/catalog/trenazhery/silovye/multistancyy" class="popular__item">
                <span class="popular__itemText">Мультистанции</span>
                <span class="popular__itemImage" style="background-image: url(/img/multistanciya.jpg);"></span>
            </a>
            <a href="/catalog/trenazhery/kardiotrenazhery/ellipticheskie" class="popular__item">
                <span class="popular__itemText">Эллипсы</span>
                <span class="popular__itemImage" style="background-image: url(/img/elips.jpg);"></span>
            </a>
        </div>
    </div>
</div>

<?=$this->render('@frontend/views/blocks/brands')?>