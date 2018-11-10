<?php

use common\models\Mainpage;
use common\models\Param;
use common\models\Product;
use frontend\models\ReviewForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->params['seo_title'] = $model->name.' - купите за '.number_format($model->price, 0, '', ' ').' рублей в интернет-магазине KSG.ru';
$this->params['seo_description'] = $model->name.' - купите у официального дилера '.$brand->name.' и получите фирменную гарантию от производителя. Доставка по Москве и в регионы России.';
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

$presents = \common\models\Present::find()->all();
$presentArtikul = '';

foreach($presents as $present) {
    if ($model->price >= $present->min_price && $model->price <= $present->max_price) {
        $presentArtikul = explode(',', $present->product_artikul)[0];
    }
}

$mainpage = Mainpage::findOne(1);

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $model->getBreadcrumbs()])?>
<div itemscope itemtype="http://schema.org/Product">
    <?=$this->render('_product', [
        'model' => $model,
        'brand' => $brand,
        'currentVariant' => $currentVariant,
        'variants' => $variants,
        'selects' => $selects,
        'adviser' => $adviser,
        'features' => $features,
    ])?>
    
    <div class="properties">
        <div class="properties__tabs">
            <div class="properties__tab active"><span>характеристики</span></div>
            <div class="properties__tab"><span>Описание</span></div>
            <?php if (!empty($model->video)) { ?>
                <div class="properties__tab"><span>видео обзор</span></div>
            <?php } ?>
            <div class="properties__tab"><span>отзывы</span></div>
            <div class="properties__tab"><span>доставка</span></div>
            <svg class="properties__tabUnderline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89 7.7"><defs></defs><polygon points="1.7 0 0 1.4 0 3 39.7 3 44.5 7.7 49.3 3 87.3 3 89 1.5 89 0 1.7 0"></polygon></svg>
        </div>
        <div class="properties__contents">
            <div class="properties__content properties__features active">
                <div class="properties__featuresInner">
                    <?php foreach($features as $index => $item) { ?>
                        <div class="properties__feature<?=($index == 0) ? ' active' : ''?>">
                            <div class="properties__featurePlus"></div>
                            <div class="properties__featureHeader"><span><?=$item['feature']->header?></span></div>
                            <ul class="properties__featureList"<?=($index == 0) ? ' style="display: block;"' : ''?>>
                                <?php foreach($item['values'] as $values) {
                                    if (strlen($values['value']) > 75) { ?>
                                        <li class="big">
                                            <div class="properties__featureName<?=(strlen($values['name']) > 75) ? ' properties__featureName_big' : ''?>"><?=$values['name']?></div>
                                            <div class="properties__featureMiddle properties__featureMiddle_big"></div>
                                            <div class="properties__featureValue properties__featureValue_big"><?=$values['value']?></div>
                                        </li>
                                    <?php } else {
                                        ?>
                                        <li>
                                            <div class="properties__featureName<?=(strlen($values['name']) > 75) ? ' properties__featureName_big' : ''?>"><?=$values['name']?></div>
                                            <div class="properties__featureMiddle"></div>
                                            <div class="properties__featureValue"><?=$values['value']?></div>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="properties__content properties__descr content">
                <div class="properties__descrInner" itemprop="description">
                    <?=$model->description?>
                </div>
            </div>
            <?php if (!empty($model->video)) { ?>
                <div class="properties__content properties__video">
                    <div class="properties__videoInner">
                        <iframe src="https://www.youtube.com/embed/<?=$model->video?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            <?php } ?>
            <div class="properties__content properties__reviews">
                <div class="properties__reviewsInner">
                    <?php if ($model->activeReviews) { ?>
                        <?php foreach($model->activeReviews as $review) { ?>
                            <div class="properties__reviewsItem">
                                <div class="properties__reviewsHeader">
                                    <div class="properties__reviewsName"><?=$review->name?></div>
                                    <div class="properties__reviewsDate">{<?=$review->date?>}</div>
                                </div>
                                <div class="properties__reviewsText"><?=$review->text?></div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p>Отзывов нет</p>
                    <?php } ?>
                    <?php
                    $callbackForm = new ReviewForm();
                    $form = ActiveForm::begin([
                        'options' => [
                            'class' => 'reviewForm sendForm',
                            'id' => 'reviewForm'
                        ],
                    ]);?>
                            <?=$form->field($callbackForm, 'name')
                                ->textInput([
                                    'class' => 'reviewForm__input',
                                    'placeholder' => 'Ваше имя'
                                ])->label(false)?>
                            <?=$form->field($callbackForm, 'opinion')
                                ->textarea([
                                    'class' => 'reviewForm__input reviewForm__input_textarea',
                                    'placeholder' => 'Ваше мнение'
                                ])->label(false)?>
                        <button class="button button1 reviewForm__submit" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></svg>
                            <span>оставить свой отзыв</span>
                        </button>
                    <?=$form->field($callbackForm, 'type')
                        ->hiddenInput([
                            'value' => 'Оставлен отзыв KSG'
                        ])->label(false)?>
                    <?=$form->field($callbackForm, 'review_product_id')
                        ->hiddenInput([
                            'value' => $model->id
                        ])->label(false)?>
    
                    <?=$form->field($callbackForm, 'BC')
                        ->textInput([
                            'class' => 'BC',
                            'value' => ''
                        ])->label(false)?>
                    <?php ActiveForm::end();?>
                </div>
            </div>
            <div class="properties__content properties__features">
                <div class="properties__deliveryInner">
                    <div class="content columnsFlex">
                        <div class="columnsFlex__column"><?=$mainpage->product_delivery_left?></div>
                        <div class="columnsFlex__column"><?=$mainpage->product_delivery_right?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($accessories)) { ?>
    <div class="productSlider">
        <div class="container">
            <div class="header2">Аксессуары</div>
            <div class="productSlider__inner owl-carousel">
                <?php foreach($accessories as $accessory) {
                    if ($accessory->available) {
                        echo $this->render('@frontend/views/catalog/_item', [
                            'model' => $accessory,
                            'accessory' => true
                        ]);
                    }
                } ?>
            </div>
        </div>
    </div>

    <?php foreach($accessories as $product) {
        echo $this->render('@frontend/views/catalog/_addToCart_items', [
            'model' => $product,
            'presents' => $presents,
        ]);
    } ?>
<?php } ?>

<?php if (!empty($similar)) { ?>
    <div class="productSlider">
        <div class="container">
            <div class="header2">Похожие товары</div>
            <div class="productSlider__inner owl-carousel">
                <?php foreach($similar as $s) {
                    if ($s->available) {
                        echo $this->render('@frontend/views/catalog/_item', [
                            'model' => $s
                        ]);
                    }
                } ?>
            </div>
        </div>
    </div>
    <?php foreach($similar as $product) {
        echo $this->render('@frontend/views/catalog/_addToCart_items', [
            'model' => $product,
            'presents' => $presents,
        ]);
    } ?>
<?php } ?>

<?=$this->render('@frontend/views/blocks/news')?>

<div class="popup productImages" id="productImages">
    <div class="productImages__inner">
        <div class="productImages__info">
            <div class="productImages__header"></div>
            <div class="productImages__text"></div>
        </div>
        <div class="productImages__image"><img src="" alt="<?=$model->name?>"></div>
    </div>
    <div class="sliderButton productImages__arrowLeft" onselectstart="return false">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></svg>
    </div>
    <div class="sliderButton productImages__arrowRight" onselectstart="return false">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></svg>
    </div>
</div>

<?=$this->render('_addToCart', [
    'model' => $model,
    'currentVariant' => $currentVariant,
    'selects' => $selects,
    'presentArtikul' => $presentArtikul,
    'delivery_date' => Product::getNearDates()[0],
])?>