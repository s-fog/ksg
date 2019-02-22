<?php
use common\models\ProductParam;
use frontend\models\Favourite;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
$this->params['seo_h1'] = $model->seo_h1;


?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => [0 => $model->name]])?>

<h1 class="header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>

<?php if (empty($products)) { ?>
    <div class="empty">
        <div class="container">
            <div class="empty__inner">
                <div class="empty__left" style="background-image: url(/img/compareEmpty.png);"></div>
                <div class="empty__right">
                    <div class="empty__header">К сравнению не добавлено товаров</div>
                    <div class="empty__text">В этом разделе Вы можете сравнить любые товары сайта и сделать обоснованный выбор. Просто нажмите на «иконку с лесенкой» в правом верхнем углу товара, и он окажется в этом списке. Товары в сравнении не исчезают при уходе с сайта, и Вы сможете вернуться к сравнению позже.</div>
                    <a href="/catalog" class="empty__link">Перейти в каталог</a>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="compare">
        <div class="compare__products">
            <div class="container">
                <div class="sliderButton compare__button compare__prev">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>
                </div>
                <div class="sliderButton compare__button compare__next">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>
                </div>
                <div class="compare__container">
                    <div class="compare__productsInner js-compare-container">
                        <?php foreach($products as $product) {
                            $currentVariant = ProductParam::find()->where(['product_id' => $product->id])->orderBy(['id' => SORT_ASC])->one();
                            $image0 = $product->images[$currentVariant->image_number];
                            $filename = explode('.', basename($image0->image));
                            ?>
                            <a href="<?=Url::to(['catalog/view', 'alias' => $product->alias])?>" class="compare__productsItem">
                                <span class="compare__productsItemTop">
                                    <span class="catalog__itemTop">
                                        <span data-title="Удалить из сравнения"
                                              data-id="<?=$product->id?>"
                                              class="catalog__itemCompareDelete hint hint_tocompare js-delete-from-compare"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.14 34.01"><g><path class="cls-1" d="M30.1,7c-.86-3.72-7.54-4.17-12.24-4.15a2.88,2.88,0,0,0-5.76.06v0C7.89,2.94,0,3.32,0,7.36a3.13,3.13,0,0,0,1.84,2.73Q3.07,21.32,4.32,32.56A1.48,1.48,0,0,0,5.76,34H24.39a1.49,1.49,0,0,0,1.45-1.45q1.23-11.24,2.48-22.48A3.82,3.82,0,0,0,30.1,7.74a1.83,1.83,0,0,0,0-.76Zm-7,24.14H7.05L5,12.12a45.55,45.55,0,0,0,10.12,1.36A48.21,48.21,0,0,0,25.19,12.2S23.8,24.81,23.11,31.12ZM14.75,10.36C8.5,10.36,3.66,9,3.66,7.55S8.73,5.37,15,5.37s11.33.74,11.33,2.18S21,10.36,14.75,10.36Zm-.91,6.5V27.22a1.45,1.45,0,0,0,2.89,0V16.86A1.45,1.45,0,0,0,13.84,16.86ZM21,27.22Q21.5,22,22,16.86c.18-1.85-2.71-1.83-2.89,0q-.54,5.19-1.06,10.36C17.9,29.07,20.79,29.06,21,27.22ZM11.43,16.86c-.18-1.83-3.08-1.85-2.89,0q.54,5.19,1.06,10.36c.19,1.84,3.08,1.86,2.89,0Q12,22,11.43,16.86Z"/></g></svg></span>
                                        <span data-title="Добавить в корзину"
                                              data-id="<?=$product->id?>"
                                              data-paramsV="<?=($currentVariant->params) ? implode('|', $currentVariant->params) : ''?>"
                                              data-quantity="1"
                                              class="catalog__itemCart hint hint_tocart js-add-to-cart"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"></path><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"></path><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"></path></g></svg></span>
                                    </span>
                                </span>
                                <span class="compare__productsItemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-350-300.<?=$filename[1]?>);"></span>
                                <span class="compare__productsItemName"><span><?=$product->name?></span></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="compare__item">
            <div class="container">
                <div class="compare__container">
                    <div class="compare__itemInner js-compare-container">
                        <?php foreach($products as $product) { ?>
                            <div class="compare__itemFeature">
                                <?php if (!empty($product->price_old)) { ?>
                                    <div class="compare__oldPrice"><?=number_format($product->price_old, 0, '', ' ')?> <span class="rubl">₽</span></div>
                                <?php } ?>
                                <div class="compare__price"><?=number_format($product->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i = 0;
        foreach($features as $featureHeader => $featuresName) {
            $active = '';
            $dn = ' style="display: none;"';

            if ($i == 0) {
                $active = ' active';
                $dn = '';
            }
            ?>
            <div class="compare__item">
                <div class="container">
                    <div class="compare__tab properties__feature<?=$active?>">
                        <div class="properties__featurePlus"></div>
                        <div class="properties__featureHeader"><span><?=$featureHeader?></span></div>
                    </div>
                </div>
            </div>
            <div class="compare__tabContent"<?=$dn?>>
                <?php foreach($featuresName as $featureName => $values) { ?>
                    <div class="compare__item compare__item_hover">
                        <div class="container">
                            <div class="compare__itemHeader"><?=$featureName?></div>
                            <div class="compare__container">
                                <div class="compare__itemInner js-compare-container">
                                    <?php foreach($values as $value) { ?>
                                        <div class="compare__itemFeature"><?=$value?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php $i++;
        } ?>
    </div>
<?php } ?>
