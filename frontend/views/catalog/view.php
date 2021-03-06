<?php

use common\models\Category;
use common\models\Mainpage;
use common\models\Param;
use common\models\Product;
use frontend\models\OneClickForm;
use frontend\models\ReviewForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

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

<div itemscope itemtype="http://schema.org/Product" class="product__outer">
    <?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $model->getBreadcrumbs()])?>
    <?=$this->render('_product', [
        'model' => $model,
        'brand' => $brand,
        'currentVariant' => $currentVariant,
        'adviser' => $adviser,
        'features' => $features,
    ])?>
</div>

        <div class="properties">
            <div class="properties__tabs">
                <div class="properties__tab active"><span>характеристики</span></div>
                <div class="properties__tab"><span>Описание</span></div>
                <?php if (!empty($model->video)) { ?>
                    <div class="properties__tab">
                        <span>видео обзор</span>
                        <div class="properties__tabDigit">1</div>
                    </div>
                <?php } ?>
                <?php /* ?><div class="properties__tab"><span>отзывы</span></div>
                <div class="properties__tab"><span>доставка</span></div><?php */ ?>
                <svg class="properties__tabUnderline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89 7.7"><defs></defs><g><polygon points="1.7 0 0 1.4 0 3 39.7 3 44.5 7.7 49.3 3 87.3 3 89 1.5 89 0 1.7 0"></polygon></g></svg>
            </div>
            <div class="properties__contents">
                <div class="properties__content properties__features active">
                    <div class="properties__featuresInner">
                        <?php foreach($features as $index => $item) { ?>
                            <div class="properties__feature<?=($index == 0) ? ' active' : ''?>">
                                <div class="properties__featurePlus"></div>
                                <div class="properties__featureHeader"><span><?=$item['feature']->header?></span></div>
                                <ul class="properties__featureList"<?=($index == 0) ? ' style="display: block;"' : ''?>>
                                    <?php if (is_array($item['values'])) { ?>
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
                                        }
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
<?php /* ?><div class="properties__content properties__reviews">
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
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
                </div><?php */ ?>
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

    <?php
    $compilations = $model->getCompilationCategories();

    if (!empty($compilations)) {
?>
    <div class="brands productCategories">
        <div class="container">
            <div class="brands__header"><?=$model->name?> находится в подборках:</div>
            <div class="category__tags">
                <div class="container">
                    <?php foreach($compilations as $category) { ?>
                        <a href="<?=$category->url?>" class="category__tag">
                            <span><?=$category->name?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
        <?php }?>

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

    <div class="popup productImages" id="productImages">
        <div class="productImages__inner">
            <div class="productImages__info">
                <div class="productImages__header"></div>
                <div class="productImages__text"></div>
            </div>
            <div class="productImages__image"><img src="<?=$model->images[0]->image?>" alt="<?=$model->name?> всплывающая"></div>
        </div>
        <div class="sliderButton productImages__arrowLeft">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>
        </div>
        <div class="sliderButton productImages__arrowRight">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>
        </div>
    </div>

<?=$this->render('_addToCart', [
    'model' => $model,
    'currentVariant' => $currentVariant,
    'presentArtikul' => $presentArtikul,
    'delivery_date' => Product::getNearDates()[0],
])?>

<?php
$oneClickForm = new OneClickForm();
$form = ActiveForm::begin([
    'options' => [
        'class' => 'popup oneClick sendForm',
        'id' => 'delayPayment'
    ],
]);?>
<div class="addToCart__beforeHeader">Покупка в рассрочку: наш менеджер оформит заказ по телефону</div>
<div class="addToCart__header"><?=$model->name?></div>
<?php
//var_dump($currentVariant);die();
$image = '';
$filename = explode('.', basename($model->images[0]->image));

if (isset($filename[1])) {
    $image = '/images/thumbs/'.$filename[0].'-770-553.'.$filename[1];
}
?>
<div class="addToCart__image"><div style="background-image: url(<?=$image?>)"></div></div>
<div class="oneClick__inner">
    <div class="oneClick__top">
        <?=$form->field($oneClickForm, 'name')
            ->textInput([
                'class' => 'callback__input',
                'id' => 'delayPayment__name',
                'placeholder' => 'Имя'
            ])->label(false)?>
        <?=$form->field($oneClickForm, 'phone')->widget(MaskedInput::className(), [
            'mask' => '+7 (999) 999-99-99',
            'options' => [
                'class' => 'callback__input',
                'id' => 'delayPayment_phone_mask',
                'placeholder' => 'Телефон'
            ],
            'clientOptions' => [
                'clearIncomplete' => true
            ]
        ])->label(false) ?>
    </div>
    <div class="oneClick__bottom">
        <div class="oneClick__bottomLeft">
            <div class="callback__bottom">
                Нажимая «купить», вы подтверждаете, что прочли<br>
                и согласны  с “<a href="/kompaniya/publichnaya-oferta" target="_blank" class="link">Публичной офертой</a>”, и даёте своё согласие<br>
                на <a href="/documents/politics.pdf" target="_blank" class="link">обработку персональных данных</a>
            </div>
        </div>
        <div class="oneClick__bottomRight">
            <button class="popup__submit" type="submit"><span>купить</span></button>
        </div>
    </div>
</div>
<?=$form->field($oneClickForm, 'type')
    ->hiddenInput([
        'value' => 'Купить в один клик KSG'
    ])->label(false)?>
<?=$form->field($oneClickForm, 'paramsV')
    ->hiddenInput([
        'value' => $currentVariant->paramsv
    ])->label(false)?>
<?=$form->field($oneClickForm, 'product_id')
    ->hiddenInput([
        'value' => $model->id
    ])->label(false)?>
<?=$form->field($oneClickForm, 'delay_payment')
    ->hiddenInput([
        'value' => 1
    ])->label(false)?>

<?=$form->field($oneClickForm, 'BC')
    ->textInput([
        'class' => 'BC',
        'id' => 'delayPayment__bc',
        'value' => ''
    ])->label(false)?>
<?php ActiveForm::end();?>

<?php
$this->registerCssFile('/css/tiny-slider.css');
$this->registerJsFile('/js/tiny-slider.js');
?>
