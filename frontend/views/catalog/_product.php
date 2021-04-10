<?php
use common\models\Build;
use common\models\Mainpage;
use common\models\Param;
use common\models\Product;
use frontend\models\Compare;
use frontend\models\Favourite;

$inCompare = Compare::inCompare($model->id);
$inFavourite = Favourite::inFavourite($model->id);
$presents = $model->getPresents();
$mainpage = Mainpage::findOne(1);
$empty = false;

if ($currentVariant->available == 0) {
    $empty = true;
}
?>

<div class="product">
    <div class="container">
        <div class="product__inner">
            <div class="product__left">
                <div class="product__klavdia">
                    <div class="product__klavdiaLeft" style="background-image: url(/img/klavdia.png)"></div>
                    <div class="product__klavdiaRight">
                        <div class="product__klavdiaHeader">Консультация 24/7</div>
                        <div class="product__klavdiaCallback" data-fancybox data-src="#callback"><span>Заказать обратный звонок</span></div>
                        <div class="product__klavdiaText">Знаем все о тренажерах, поможем оформить заказ по телефону <a href="tel:<?=Yii::$app->params['cities']['Others']['phoneLink']?>" class="product__klavdiaPhone link"><?=Yii::$app->params['cities']['Others']['phone']?></a></div>
                    </div>
                </div>

                <?php
                $build = Build::findOne(['category_id' => $model->parent_id]);
                if ($build !== null) { ?>
                    <div class="product__leftItem">
                        <div class="product__leftHeader">
                            <div class="product__leftHeaderIcon"><svg fill="none" viewBox="0 0 69 38" xmlns="http://www.w3.org/2000/svg" style="width: 69px;"><g clip-path="url(#a)" stroke="#fff" stroke-miterlimit="10" stroke-width="2"><path d="M49.275 31.846H36.538M64.851 31.846h3.42v-7.8a3.625 3.625 0 00-1.673-3.078l-4.076-2.576-1.674-7.442c-.291-1.289-1.383-2.147-2.766-2.147h-8.006V.716H12.3v31.13M21.035 31.846h-8.734"/><path d="M57.136 12.452l1.456 6.584h-8.516v-6.584h7.06zM66.598 26.335h1.674M32.153 32.741c.495-3.004-1.581-5.833-4.637-6.32s-5.933 1.555-6.427 4.559 1.58 5.833 4.636 6.32c3.056.486 5.933-1.555 6.428-4.559zM60.35 33.078c.709-2.962-1.159-5.929-4.172-6.626s-6.03 1.14-6.739 4.102c-.708 2.963 1.16 5.929 4.172 6.626s6.03-1.14 6.739-4.102z"/><path d="M56.554 31.846c0 .93-.8 1.718-1.747 1.718s-1.747-.788-1.747-1.718c0-.93.801-1.718 1.747-1.718 1.02 0 1.747.788 1.747 1.718zM26.566 33.563c.965 0 1.747-.769 1.747-1.718 0-.948-.782-1.717-1.747-1.717-.965 0-1.747.769-1.747 1.718 0 .948.782 1.717 1.747 1.717zM45.854 19.036H12.3M26.566 10.305h8.807M33.335 7.228l2.547 3.077-2.547 3.006M7.86 31.846H0M7.86 26.335H2.548M7.86 20.896H5.169"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h69v38H0z"/></clipPath></defs></svg></div>
                            <div class="product__leftHeaderText"><?=$build->thisPrice($model->price) > 0 ? 'Соберем' : 'Бесплатно соберем'?> и настроим</div>
                        </div>
                        <div class="product__leftText"><span><?=$model->category->name?></span> требуют сборки и настройки. Покупая в у нас вы снимаете с себя все заботы по сборке, а также риски связанные с потерей гарантии в случае, если сделаете что-то «не так».</div>
                    </div>
                <?php } ?>
                <div class="product__leftItem">
                    <div class="product__leftHeader">
                        <div class="product__leftHeaderIcon"><svg width="52" height="53" viewBox="0 0 52 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path d="M21.7455 10.2213C22.1867 10.5368 22.7539 10.7892 23.5103 10.7892C24.7709 10.7892 25.7794 10.4737 25.7794 9.27491C25.7794 8.1392 24.7709 7.76063 23.5103 7.76063C22.2497 7.76063 21.2412 7.31896 21.2412 6.24634C21.2412 5.17372 22.2497 4.73206 23.5103 4.73206C24.2667 4.73206 24.897 4.98444 25.3382 5.36301" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M23.4473 4.79517V3.78564" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M23.4473 11.9249V10.8523" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M30.4642 8.94203C31.092 5.05477 28.4529 1.39407 24.5697 0.765618C20.6864 0.137167 17.0295 2.77895 16.4017 6.66621C15.7739 10.5535 18.413 14.2142 22.2962 14.8426C26.1795 15.4711 29.8364 12.8293 30.4642 8.94203Z" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M15.1273 49.2143L14.1188 52.3691H7.50061L9.45455 46.375L9.39152 46.3119C6.74425 44.356 4.72728 41.706 3.46667 38.6143L3.21455 38.0465H0.63031V30.6012H3.27758C4.28607 27.3203 6.49213 24.3548 9.64364 22.2096L5.92485 18.2977C10.0218 16.4048 12.543 18.55 14.7491 19.6227C17.2703 18.7393 20.1067 18.1715 23.0691 18.1715C33.7842 18.1715 42.6085 24.8596 43.3018 33.2512H43.3648C43.3648 33.2512 46.0121 30.9167 48.5333 33.3143C50.0461 34.7655 49.7939 38.1726 47.4618 37.9203C44.5624 37.6048 45.5079 33.756 51.937 31.7369" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M43.0497 36.469C42.3564 40.5702 39.7721 44.1666 36.0533 46.6904L37.9442 52.369H31.3891L30.3806 49.4035C28.1115 50.0976 25.5903 50.5392 23.0061 50.5392C21.3673 50.5392 19.7285 50.3499 18.2158 50.0976" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M38.3224 36.3428C37.7552 38.3618 35.8012 40.8856 34.2255 42.0213" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M20.3588 23.219H26.5358" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                    <path d="M9.95877 27.6987L8.44604 29.9071" stroke="white" stroke-width="2" stroke-miterlimit="10"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect width="52" height="53" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg></div>
                        <div class="product__leftHeaderText">Система скидок для оптовиков и фитнес-клубов</div>
                    </div>
                    <div class="product__leftText">Помогаем в открытии фитнес-центров, делаем 3D-макеты с расстановкой оборудования, а в числе наших оптовых партнеров – оффлайн и онлайн магазины.
                        <div class="linkSpan" data-fancybox data-src="#callback"><span>Запросить предложение</span></div>
                    </div>
                </div>
                <div class="product__leftItem">
                    <div class="product__leftHeader">
                        <div class="product__leftHeaderIcon"><svg width="35" height="47" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)" stroke="#fff" stroke-width="2" stroke-miterlimit="10"><path d="M17.466 28.741c5.677 0 10.279-4.632 10.279-10.347 0-5.714-4.602-10.347-10.279-10.347-5.676 0-10.278 4.633-10.278 10.347 0 5.715 4.602 10.347 10.278 10.347z"/><path d="M17.466 36.112c-1.746 0-3.023-2.908-4.635-3.449-1.612-.54-4.367 1.082-5.71.068-1.41-1.014-.74-4.125-1.747-5.478-1.007-1.352-4.165-1.69-4.702-3.381-.538-1.623 1.814-3.72 1.814-5.478 0-1.758-2.352-3.854-1.814-5.477.537-1.623 3.695-1.962 4.702-3.382 1.008-1.42.336-4.53 1.747-5.477 1.343-1.015 4.098.608 5.71.067 1.612-.54 2.889-3.449 4.635-3.449 1.747 0 3.023 2.908 4.636 3.45 1.612.54 4.366-1.083 5.71-.068 1.41 1.014.739 4.125 1.746 5.477 1.008 1.353 4.166 1.69 4.703 3.382.537 1.623-1.814 3.719-1.814 5.477 0 1.759 2.351 3.855 1.814 5.478-.537 1.623-3.695 1.961-4.703 3.381-1.007 1.42-.335 4.531-1.746 5.478-1.344 1.014-4.098-.609-5.71-.068-1.613.541-2.889 3.45-4.636 3.45z"/><path d="M17.466 21.37l3.36 1.758-.672-3.72 2.687-2.637-3.695-.54-1.68-3.382-1.612 3.381-3.762.541 2.687 2.638-.604 3.719 3.291-1.758zM25.192 35.233l2.62 11.09H7.188l2.62-11.09M12.966 43.078l.738-5.478M21.296 37.6l.739 5.478"/></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h35v47H0z"/></clipPath></defs></svg></div>
                        <div class="product__leftHeaderText">Официальный дилер <br> <?=$model->brand->name?></div>
                    </div>
                    <div class="product__leftText">KSG - официальный дилер <?=$model->brand->name?> на территории Российской федерации, это значит, что проблем с гарантийным обслуживанием у вас не возникнет. Покупать у нас - безопасно!</div>
                </div>
            </div>
            <div class="product__middle">
                <div class="product__art">Артикул: <?=$currentVariant->artikul?>
                    &nbsp;&nbsp;//&nbsp;&nbsp;Код товара: <?=$model->id?></div>
                <h1 itemprop="name" class="product__name"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>
                <div class="product__afterH1">
                    <div class="product__brand">
                        <?php /* ?><div class="product__brandImageContainer">
                            <?php $filename = explode('.', basename($brand->image)); ?>
                            <img src="/images/thumbs/<?=$filename[0]?>-60-30.<?=$filename[1]?>" alt="<?=$model->name?>" class="product__brandImage">
                        </div><?php */ ?>
                        <div class="product__brandText">
                            Бренд: <a href="<?=$brand->url?>" class="link"><?=$brand->name?></a>
                        </div>
                    </div>
                    <?=$this->render('@frontend/views/catalog/_compare', ['model' => $model])?>
                </div>
                <div class="product__sliderWrapper<?=$empty ? ' product__slider_preorder' : ''?>">
                    <div class="product__slider owl-carousel" rel="noreferrer">
                        <?php foreach($model->images as $index => $imageModel) {
                        $image = '';
                        $filename = explode('.', basename($imageModel->image));

                        if (isset($filename[1])) {
                            $image = '/images/thumbs/'.$filename[0].'-770-553.'.$filename[1];
                        }
                        $var = '';

                        foreach($model->productParams as $pp) {
                            if ($pp->image_number == $index) {
                                $var = $pp;
                            }
                        }
                        ?>
                        <div class="product__sliderItem" data-index="<?=$index?>">
                            <img src="<?=$image?>"
                                 class="product__sliderImage"
                                 data-paramsv="<?=($var !== null) ? $var->paramsv : ''?>"
                                 data-currentVariant="<?=$var->paramsv === $currentVariant->paramsv ? '1' : '0'?>"
                                 data-header="<?=$model->name?>"
                                 data-text="<?=$imageModel->text?>"
                                 data-image="<?=$image?>"
                                 data-fancybox="productImages"
                                 data-src="#productImages">
                        </div>
                        <?php } ?>
                    </div>
                    <?php /*if ($empty) { ?>
                        <div class="button button222 product__preorder js-product-preorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"></polygon></g></svg>
                            <span>оформить предзаказ</span>
                        </div>
                    <?php }*/ ?>
                </div>
                <div class="product__sliderThumbs owl-carousel" rel="noreferrer">
                    <?php foreach($model->images as $index => $imageModel) {
                        $image = '';
                        $filename = explode('.', basename($imageModel->image));

                        if (isset($filename[1])) {
                            $image = '/images/thumbs/'.$filename[0].'-770-553.'.$filename[1];
                        }
                        $var = '';

                        foreach($model->productParams as $pp) {
                            if ($pp->image_number == $index) {
                                $var = $pp;
                            }
                        }
                        ?>
                        <div class="product__sliderThumbsItem" data-index="<?=$index?>">
                            <img src="<?=$image?>">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="product__right">
                <?php if (!$empty) { ?>
                    <div class="product__available active">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 23.1"><g><polygon points="16.1 0 13.6 1 6.8 17.9 2.8 12.7 0.3 12.4 0 15 6.3 23.1 8.6 23.1 17 2.4 16.1 0"/></g></svg>
                        <span>Есть в наличии</span>
                    </div>
                <?php } ?>
                <div class="product__prices">
                    <div class="product__price">
                        <?php if ($model->price == 0) { ?>
                            По запросу
                        <?php } else { ?>
                            <?=number_format($model->price, 0, '', ' ')?>
                            <span class="rubl">₽</span>
                        <?php } ?>
                    </div>
                    <?php if (!empty($model->price_old)) { ?>
                        <div class="product__oldPrice">
                            <?=number_format($model->price_old, 0, '', ' ')?>
                            <span class="rubl">₽</span></div>
                    <?php } ?>
                </div>
                <div class="product__wantLess">
                    Нашли дешевле? <span class="linkSpan" data-fancybox data-src="#callback"><span>Снизим цену!</span></span>
                </div>
                <button class="product__toCart js-product-in-js" id="product-to-cart-add" data-fancybox data-src="#addToCart">
                    <span>добавить в корзину</span>
                </button>
                <?php if (!$empty) { ?>
                    <div class="product__requestSale" data-fancybox="oneClick" data-src="#oneClick"><span>Купить в один клик</span></div>
                <?php } ?>
                <?=$this->render('@frontend/views/catalog/selects', ['model' => $model])?>
                <hr class="product__delimiter">
                <div class="product__rightHeader">Способы оплаты</div>
                <div class="product__rightItem">– Наличными  при получении</div>
                <div class="product__rightItem">– Банковской картой при получении</div>
                <div class="product__rightItem">– Онлайн на сайте</div>
                <div class="product__rightDelayPayment">
                    <div class="product__rightDelayPaymentInner">
                        <div class="product__rightItem" style="margin-bottom: 0;">– В рассрочку 0-0-12 от <span><?=number_format($model->delayPrice, 0, '', ' ')?> ₽/мес</span></div>
                    </div>
                    <div class="product__rightDelayPaymentIcons">
                        <div class="product__rightDelayPaymentIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 60px;" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 439.8 106.1" ><style type="text/css">.st0{fill:#FFF}</style><g> <path class="st0" d="M184,32.6h-27.9c0,0-0.8,0.1-0.8,0.8c0,0-0.6,3.7-1.3,9.5c-3.3-7.7-9.5-13.1-19.1-13.1 c-18.3,0-30.2,16.8-32.6,35.7c-2.4,18.5,5,39.3,22.6,39.3c9.8,0,18.1-6.6,24-15.6c0.6,9.8,7.4,15.7,17,15.7c7.8,0,16-5.4,18-9.8 c1.8-3.7-8.2,1-5.6-21l0,0c1.3-9.5,6.1-41,6.1-41C184.4,32.7,184,32.6,184,32.6z M151.9,67.2c-1.3,10.3-6,18.6-12.8,18.6 c-6.8,0-9.3-8.3-8.1-18.6c1.3-10.3,5.9-18.8,12.7-18.8C150.5,48.4,153.2,56.8,151.9,67.2z"/> <path class="st0" d="M311.2,46.9c56.9-6.2,47.7-47.7,19.5-46.9c-32.6,0.8-50.6,40.7-50.6,70.8c0,19,11.4,34.8,32.5,34.8 c21.6,0,39.4-15.2,37.8-37.5c-1.5-19.6-24-23.7-39.9-18.3v0L311.2,46.9z M325.7,18.1L325.7,18.1c3.5,0,3.6,1.9,3.5,3.7 c-1.1,8.4-14.9,14.6-14.9,14.6C315.7,31.6,319.7,18.1,325.7,18.1z M316.4,61.1c7,1.2,9.2,6.1,8.8,13.5l0,0 c-0.1,4-3.6,15.3-10.9,15.3c-10.2,0-7.1-21.9-6-28C308.3,61.9,312.7,60.6,316.4,61.1z"/> <path class="st0" d="M273.4,33.8h0.1c-21.7-4.4-41.4-4.1-60.6,0c-0.1,0-0.6,0.1-0.6,0.7c0,0-2.6,22.2-6.8,33 c-7.9,19.9-16.6,20.8-16.9,23.4c-0.4,2.9,3.1,15.2,16,15.2c11.3,0,19.1-7.2,23.3-23.7c2.8-10.9,4.5-23,5-35.9l11.3,0 c-2.5,20.4-7,55.9-7,55.9c0,0.7,0.6,0.7,0.6,0.7l26.9,0c0,0,0.6,0,0.6-0.7c0,0,8.1-64.8,8.5-68l0,0 C273.9,33.9,273.6,33.8,273.4,33.8z"/> <path class="st0" d="M106.5,21.5C106.8,9.3,98-0.3,84.1,1c-12.8,1.1-16.7,9.7-15.7,10.6c2.9,2.8,11.1,21.8-3.2,30.1L50.6,5.1 c0,0-0.3-0.8-1-0.8H14.4c-1.1,0-0.8,1-0.8,1l22.6,44.6C16.3,55.5,0.9,69.9,0,84.2c-0.7,12.1,8.1,21.9,20.2,21.9 c12.8,0,19.9-11.3,18.8-13.1c-2.6-2.8-10-17.7,3.3-27l15,36.4c0,0,0.1,0.7,0.8,0.7h37.6c0.8,0,0.4-0.7,0.4-0.7l0,0L71.9,56.6 C92.1,50.6,106.2,36,106.5,21.5z"/> <path class="st0" d="M439.4,32.6h-27.9c0,0-0.8,0.1-0.8,0.8c0,0-0.6,3.7-1.3,9.5c-3.3-7.7-9.5-13.1-19.1-13.1 c-18.3,0-30.2,16.8-32.6,35.7c-2.4,18.5,5,39.3,22.6,39.3c9.8,0,18.1-6.6,24-15.6c0.6,9.8,7.4,15.7,17,15.7c7.8,0,16-5.4,18-9.8 c1.8-3.7-8.2,1-5.6-21h0c1.3-9.5,6.1-41,6.1-41C439.8,32.7,439.4,32.6,439.4,32.6z M407.4,67.2c-1.3,10.3-6,18.6-12.8,18.6 c-6.8,0-9.3-8.3-8.1-18.6c1.3-10.3,5.9-18.8,12.7-18.8C406,48.4,408.6,56.8,407.4,67.2z"/> </g> </svg>
                        </div>
                        <div class="product__rightDelayPaymentIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 130px;" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 760.9 255.1"><style type="text/css">.st2{fill:none}.st1{fill:#FFF}</style><rect class="st2" width="760.9" height="255.1"/> <g> <g> <g> <g> <g> <path class="st1" d="M173.6,85c-23.9,0-43.5,18.9-43.5,42.5c0,23.7,19.6,42.5,43.5,42.5c23.6,0,43.2-18.1,43.2-42.5 C216.8,103.2,197.2,85,173.6,85 M137.6,127.6c0-19.8,16.1-36,36-36c19.8,0,36,16.1,36,36c0,19.8-16.1,35.9-36,35.9 C153.7,163.5,137.6,147.4,137.6,127.6 M286.1,127.6c0-14.3-11-25.3-25.6-25.3c-14.8,0-25.7,11-25.7,25.3 c0,14.4,10.9,25.3,25.7,25.3C275.1,152.8,286.1,142,286.1,127.6 M324.2,152h14.7c9.5,0,17.9-3.6,17.9-13.5 c0-7.5-4.2-10.7-8.7-11.9c4.9-2.3,7.2-5.5,7.2-10.9c0-9.4-8-12.6-16.1-12.6h-15.1V152z M278.3,127.6c0,10.9-7.3,18.6-17.7,18.6 c-10.5,0-17.9-7.7-17.9-18.6c0-10.9,7.3-18.6,17.9-18.6C270.9,109,278.3,116.7,278.3,127.6 M598.8,152h15.5 c9.3,0,16.5-5,16.5-14.5c0-9.9-7.7-14.7-16.5-14.7h-8v-19.6h-7.5V152z M398,152h28v-6.8h-20.5v-14.9h18.6v-7.1h-18.6V110H426 v-6.8h-28V152z M157.6,127.6c0,10.5,7.1,18.4,18.4,18.4c6.3,0,11.1-2.7,13.9-5.4v8.6c-5,2.9-10.8,3.6-14.1,3.6 c-14.6,0-26-9.9-26-25.3c0-15.4,11.5-25.3,26-25.3c3.3,0,9.1,0.7,14.1,3.6v8.7c-2.8-2.7-7.6-5.4-13.9-5.4 C164.7,109.1,157.6,117,157.6,127.6 M469.3,127.6c0-10.5,7.1-18.4,18.4-18.4c6.3,0,11.1,2.7,13.9,5.4v-8.7 c-5-2.9-10.8-3.6-14.1-3.6c-14.6,0-26,9.9-26,25.3c0,15.4,11.4,25.3,26,25.3c3.3,0,9.1-0.7,14.1-3.6v-8.6 c-2.8,2.6-7.6,5.4-13.9,5.4C476.4,146,469.3,138.1,469.3,127.6 M566.5,110v-6.8H531v6.8h14v42h7.5v-42H566.5z M331.7,130.2h7.6 c6.6,0,9.6,2.3,9.6,7.3c0,6.9-6.4,7.7-11.8,7.7h-5.4V130.2z M606.3,130h7.4c8,0,9.6,4.1,9.6,7.6c0,7.5-7.7,7.5-9.8,7.5h-7.2 V130z M331.7,110h7.5c5,0,8.5,2.1,8.5,6.6c0,5.5-4.4,7-8.6,7h-7.4V110z"/> </g> </g> </g> </g> </g> </svg>
                        </div>
                        <div class="product__rightDelayPaymentIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 100px;" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 792 80"><style type="text/css">.st4{fill:#FFF}</style><path class="st4" d="M54.7,76.8V23.5h31.5V4.1H0.3v19.4h31.4v53.3H54.7z M117.4,46.4V4.1H95.3v72.7h19.5L153,34.5v42.3h22.1V4.1 h-19.5L117.4,46.4z M249.6,49.8v27h22.1V4.1h-22.1v26.6h-35.6V4.1h-22.1v72.7h22.1v-27H249.6z M333.4,76.8c5,0,9.6-0.5,13.9-1.7 c11.5-3.2,18.9-12.5,18.9-25.2c0-12.1-6.4-20.5-16.6-24.3c-4.9-1.8-10.7-2-16.2-2h-22.7V4.1h-22.1v72.7H333.4z M329.6,40.8 c3.1,0,6,0,8.5,0.9c3.7,1.2,5.8,4.3,5.8,7.9c0,3.8-2.1,7-5.6,8.5c-2.4,1.1-4.9,1.1-8.7,1.1h-18.9V40.8H329.6z M405.9,49.3l26.4,27.5 h29.5L425,38.9l35.4-34.8h-27.8l-26.7,27.3h-6.1V4.1h-22.1v72.7h22.1V49.3H405.9z M507.4,2.1c-29.8,0-47.6,16.8-47.6,38.5 s17.9,38.5,47.6,38.5c29.6,0,47.5-16.8,47.5-38.5S537,2.1,507.4,2.1z M507.4,61.4c-14.8,0-24.3-8.9-24.3-20.8S492.5,20,507.4,20 c14.7,0,24.3,8.7,24.3,20.6S522,61.4,507.4,61.4z M628.6,0h-22.1v7.3C578.6,7.9,562,19.7,562,40.5c0,20.8,16.6,31.6,44.4,32.2V80 h22.1v-7.3c27.9-0.6,44.6-11.5,44.6-32.2c0-20.8-16.6-32.5-44.6-33.1V0z M606.4,57.1c-15.3-0.6-22-6.9-22-16.6 c0-9.8,6.7-16.8,22-17.4V57.1z M628.6,23.1c15.4,0.6,22,7.6,22,17.4c0,9.8-6.6,16-22,16.6V23.1z M746.8,0h-22.1v7.3 c-27.8,0.6-44.4,12.4-44.4,33.1c0,20.8,16.6,31.6,44.4,32.2V80h22.1v-7.3c27.9-0.6,44.6-11.5,44.6-32.2c0-20.8-16.6-32.5-44.6-33.1 V0z M724.7,57.1c-15.3-0.6-22-6.9-22-16.6c0-9.8,6.7-16.8,22-17.4V57.1z M746.8,23.1c15.4,0.6,22,7.6,22,17.4c0,9.8-6.6,16-22,16.6 V23.1z"/> </svg>
                        </div>
                    </div>
                    <div class="product__rightDelayPaymentInner">
                        <div class="product__rightDelayPaymentButton" data-fancybox data-src="#delayPayment">оформить рассрочку</div>
                    </div>
                </div>
                <?php
                list($moscowPrice, $otherPrice) = \common\models\Delivery::getDeliveryPrice($model->price);
                ?>
                <div class="product__rightHeader">Условия доставки</div>
                <div class="product__rightItem product__rightItem_delivery">– По Москве: 1-3 дня, <span><?=$moscowPrice > 0 ? number_format($moscowPrice, 0, '', ' ').' ₽' : 'бесплатно'?></span></div>
                <div class="product__rightItem product__rightItem_delivery">– Московская область: 1-3 дня, <span><?=$otherPrice > 0 ? number_format($otherPrice, 0, '', ' ').' ₽' : 'бесплатно'?></span></div>
                <div class="product__rightItem product__rightItem_delivery">– По России: 3-7 дней, <span><?=$otherPrice > 0 ? number_format($otherPrice, 0, '', ' ').' ₽' : 'бесплатно'?></span></div>
                <?php foreach($model->getPresents() as $product) {
                    $filename = explode('.', basename($product->present_image));

                    if (isset($filename[1])) {
                        $image = "/images/thumbs/$filename[0]-39-50.$filename[1]";
                    } else {
                        $image = '';
                    }
                    ?>
                    <div class="product__rightHeader">Закажите сейчас и получите подарок!</div>
                    <div class="product__present">
                        <div class="product__presentImage" style="background-image: url(<?=$image?>)"></div>
                        <div class="product__presentInfo">
                            <div class="product__presentPrices">
                                <div class="product__presentPrice"><?=$product->price?> ₽</div>
                                /
                                <div class="product__presentFree">бесплатно!</div>
                            </div>
                            <a href="<?=$product->url?>" target="_blank" class="product__presentText linkSpanReverse"><span><?=$product->name?></span></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>