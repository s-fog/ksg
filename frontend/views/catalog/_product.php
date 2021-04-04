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
                <?php if ($empty) { ?>
                    <div class="product__available">
                        <?=file_get_contents(Yii::getAlias('@www').'/img/no.svg')?>
                        <span style="display: inline-block; transform: translate(5px, -3px)">Нет в наличии</span>
                    </div>
                <?php } else { ?>
                    <div class="product__available active">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 23.1"><g><polygon points="16.1 0 13.6 1 6.8 17.9 2.8 12.7 0.3 12.4 0 15 6.3 23.1 8.6 23.1 17 2.4 16.1 0"/></g></svg>
                        <span>Есть в наличии</span>
                    </div>
                <?php } ?>
                <div class="product__prices">
                    <div class="product__price">
                        <?=number_format($model->price, 0, '', ' ')?>
                        <span class="rubl">₽</span></div>
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
                    <span><?=$empty === true ? 'предзаказ' : 'добавить в корзину'?></span>
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
                        <div class="product__rightItem">– В рассрочку 0-0-12 от <span><?=number_format($model->delayPrice, 0, '', ' ')?> ₽/мес</span></div>
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

<!--
<div class="product" data-id="<?=$model->id?>">
    <div class="container">
        <div class="product__inner">
            <div class="product__left">
                <div class="product__callback">
                    <div class="product__header">Ответим на любой вопрос!</div>
                    <div class="product__callbackText">Акции и скидки магазина, условия покупки и сборки, особенности эксплуатации, аналоги и акесссуары: узнайте подробнее по телефону <?=Yii::$app->params['cities']['Москва']['phone']?> (бесплатно для Москвы)<br>
                        <?=Yii::$app->params['cities']['Others']['phone']?> (бесплатно по России) или заказав у нас <span style="cursor: pointer;" data-fancybox data-src="#callback" class="link lightRedColor">бесплатный обратный звонок</span></div>
                </div>
                <?php if (!empty($model->category->video_header)) { ?>
                    <br>
                    <div class="product__header"><?=$model->category->video_header?></div>
                    <div class="product__categoryVideo">
                        <iframe src="https://www.youtube.com/embed/<?=$model->category->video?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                <?php } ?>
                <?php if (!empty($model->instruction)) { ?>
                    <a href="<?=$model->instruction?>" target="_blank" class="product__seeInstruction">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.8 37.8"><g><path d="M18.9,0A18.9,18.9,0,1,0,37.8,18.9,18.95,18.95,0,0,0,18.9,0Zm0,35A16.1,16.1,0,1,1,35,18.9,16.09,16.09,0,0,1,18.9,35Z"/><path d="M14.8,14H29.2a1.4,1.4,0,1,0,0-2.8H14.8a1.4,1.4,0,0,0,0,2.8Z"/><path d="M29.2,17.5H14.8a1.4,1.4,0,1,0,0,2.8H29.2a1.37,1.37,0,0,0,1.4-1.4A1.43,1.43,0,0,0,29.2,17.5Z"/><path d="M29.2,23.9H14.8a1.4,1.4,0,0,0,0,2.8H29.2a1.37,1.37,0,0,0,1.4-1.4A1.43,1.43,0,0,0,29.2,23.9Z"/><path d="M10.7,11.1H9.3a1.4,1.4,0,0,0,0,2.8h1.4a1.4,1.4,0,0,0,0-2.8Z"/><path d="M10.7,17.5H9.3a1.4,1.4,0,1,0,0,2.8h1.4a1.4,1.4,0,1,0,0-2.8Z"/><path d="M10.7,23.9H9.3a1.4,1.4,0,1,0,0,2.8h1.4a1.4,1.4,0,0,0,0-2.8Z"/></g></svg>
                        <span>смотреть инструкцию</span>
                    </a>
                <?php } ?>
                <?php if (!empty($mainpage->banner_image) && $mainpage->is_banner == 1) { ?>
                    <img class="product__banner" src="<?=$mainpage->banner_image?>">
                <?php } ?>
            </div>
            <div class="product__middle">
                <h1 itemprop="name" class="product__name"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>
                <div class="product__art">
                    <div class="product__artText">Артикул: <?=$currentVariant->artikul?>&nbsp;&nbsp;//&nbsp;&nbsp;Код товара: <?=$model->id?></div>
                    <?php /* ?>
                    <div class="catalog__itemTop">
                        <a href="#"
                           class="catalog__itemCart hint hint_tocart js-add-to-cart"
                           data-id="<?=$model->id?>"
                           data-paramsV="<?=($currentVariant->params) ? implode('|', $currentVariant->params) : ''?>"
                           data-quantity="1"
                           data-title="Добавить в корзину"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg></a>
                        <a href="#"
                           class="catalog__itemFavourite hint hint_tofavourite js-add-to-favourite"
                           data-id="<?=$model->id?>"
                           data-title="<?=($inFavourite) ? 'Товар в избранном' : 'Добавить в избранное'?>">
                            <svg<?=($inFavourite) ? ' class="active"' : ''?> xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg></a>
                        <a href="#"
                           class="catalog__itemCompare hint hint_tocompare js-add-to-compare"
                           data-id="<?=$model->id?>"
                           data-title="<?=($inCompare) ? 'Товар в сравнении' : 'Добавить в сравнение'?>">
                            <svg<?=($inCompare) ? ' class="active"' : ''?> xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg></a>
                    </div>
                    <?php */ ?>
                </div>
                <div class="product__underArt">
                    <div class="product__brand">
                        <?php $filename = explode('.', basename($brand->image)); ?>
                        <img src="/images/thumbs/<?=$filename[0]?>-60-30.<?=$filename[1]?>" alt="<?=$model->name?>" class="product__brandImage">
                        <div class="product__brandText">
                            Бренд: <a href="<?=$brand->url?>" class="link"><?=$brand->name?></a>
                        </div>
                    </div>
                    <?php
                    $textAdd = 'Добавить к сравнению';
                    $textDelete = 'Удалить из сравнения';
                    ?>
                    <?=$this->render('@frontend/views/catalog/_compare', ['model' => $model])?>
                </div>
                <?php
                $image0 = $model->images[$currentVariant->image_number];
                $filename = explode('.', basename($image0->image)); ?>
                <div class="product__sliderWrapper"<?=isset($pswHeight) ? 'style="height: '.$pswHeight.'px"' : ''?>>
                    <div class="product__slider owl-carousel<?=$empty ? ' product__slider_preorder' : ''?>" rel="noreferrer">
                        <img src="/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>"
                             class="product__sliderImage product__mainImage"
                             data-paramsv="<?=($currentVariant->params) ? implode('|', $currentVariant->params) : ''?>"
                             data-header="<?=$model->name?>"
                             data-text="<?=$image0->text?>"
                             data-image="/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>"
                             data-fancybox="productImages"
                             data-src="#productImages">
                        <?php foreach($model->images as $index => $imageModel) {
                            if ($index != $currentVariant->image_number) {
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
                                <img src="<?=$image?>"
                                     class="product__sliderImage"
                                     data-paramsv="<?=($var) ? implode('|', $var->params) : ''?>"
                                     data-header="<?=$model->name?>"
                                     data-text="<?=$imageModel->text?>"
                                     data-image="<?=$image?>"
                                     data-fancybox="productImages"
                                     data-src="#productImages">
                            <?php }
                        } ?>
                    </div>
                    <?php if ($empty) { ?>
                        <div class="button button222 product__preorder js-product-preorder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"></polygon></g></svg>
                            <span>оформить предзаказ</span>
                        </div>
                    <?php } ?>
                </div>
                <div class="product__images">
                    <img src="/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>" alt="<?=$model->name?> Фото 1" itemprop="image">
                    <?php foreach($model->images as $index => $imageModel) {
                        if ($index != $currentVariant->image_number) {
                            $image = '';
                            $filename = explode('.', basename($imageModel->image));

                            if (isset($filename[1])) {
                                $image = '/images/thumbs/'.$filename[0].'-770-553.'.$filename[1];
                            }
                            ?>
                            <img src="<?=$image?>" alt="<?=$model->name?> Фото <?=($index+1)?>" style="display: none;">
                        <?php }
                    } ?>
                    <div class="product__itemImageShadow"></div>
                </div>
            </div>
            <div class="product__right">
                <div class="product__rightBorder">
                    <div class="product__rightBorderInner">
                        <div class="product__toCart">
                            <div class="product__toCartLeft">
                                <?php if (!empty($model->price_old)) { ?>
                                    <div class="product__oldPrice"><?=number_format($model->price_old, 0, '', ' ')?> <span class="rubl">₽</span></div>
                                <?php } ?>
                                <div class="product__price"><?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
                            </div>
                            <?php if (!$empty) { ?>
                                <div class="product__toCartRight">
                                    <button class="button button4 js-product-in-js" id="product-to-cart-add" data-fancybox data-src="#addToCart">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 36"><polygon points="132 0 7.58 0 0 7.58 0 36 124.21 36 132 28.35 132 0"/></svg>
                                        <span>Купить</span>
                                    </button>
                                </div>
                            <?php } else { ?>
                                <div class="product__toCartRight">
                                    <button class="button button4 js-product-in-js" id="product-to-cart-add" data-fancybox data-src="#addToCart">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 36"><polygon points="132 0 7.58 0 0 7.58 0 36 124.21 36 132 28.35 132 0"/></svg>
                                        <span>Предзаказ</span>
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="product__req">
                            <?php if ($empty) { ?>
                                <div class="product__available">
                                    <?=file_get_contents(Yii::getAlias('@www').'/img/no.svg')?>
                                    <span style="display: inline-block; transform: translate(5px, -3px)">Нет в наличии</span>
                                </div>
                            <?php } else { ?>
                                <div class="product__available active">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 23.1"><g><polygon points="16.1 0 13.6 1 6.8 17.9 2.8 12.7 0.3 12.4 0 15 6.3 23.1 8.6 23.1 17 2.4 16.1 0"/></g></svg>
                                    <span>Есть в наличии</span>
                                </div>
                                &nbsp;/&nbsp;
                            <?php } ?>
                            <?php if (!$empty) { ?>
                                <div class="product__requestSale" data-fancybox="oneClick" data-src="#oneClick">Купить в один клик</div>
                            <?php } ?>
                        </div>
                        <?=$this->render('@frontend/views/catalog/selects', ['model' => $model])?>
                    </div>
                </div>
                <?php
                $productPresents = $model->getPresents();

                if (!empty($productPresents)) {
                ?>
                    <div class="product__presents">
                        <div class="product__presentIcon">
                            <svg class="notanimated" xmlns="http://www.w3.org/2000/svg" viewBox="-14.5 -14 50 50" id="el_SyGqzxv2m" height="50" width="50"><style>#el_SyfGqzlD3m{fill: #e83b4b;}</style><defs/><title>podarok</title><g id="el_Byxf5zgP2Q" data-name="Слой 2"><g id="el_HJ-M5zxv37" data-name="Слой 1"><path d="M20.29,5H16.92A6.25,6.25,0,0,0,18.07,3.9a2.46,2.46,0,0,0,.6-2.71,2,2,0,0,0-1.25-1A6.58,6.58,0,0,0,13,.73a8.45,8.45,0,0,0-2.29,2.42A8.19,8.19,0,0,0,8.38.73,6.55,6.55,0,0,0,3.93.18a2,2,0,0,0-1.26,1C2.13,2.36,2.86,3.82,4.44,5H1a1,1,0,0,0-1,1v4.94a1,1,0,0,0,1,1h.27V21.9a1,1,0,0,0,1,1H19.06a1,1,0,0,0,1-1V11.83h.27a1,1,0,0,0,1-1V5.93A1,1,0,0,0,20.29,5Zm-1,4.94H11.59v-3h7.74ZM13.91,2.4a4.81,4.81,0,0,1,3-.4c.05.22-.5,1.21-2.11,2l-2.4,0A6.29,6.29,0,0,1,13.91,2.4ZM5.26,1.92a4.79,4.79,0,0,1,2.17.48A6,6,0,0,1,8.93,4L6.53,4A4.2,4.2,0,0,1,4.36,2.08,1.72,1.72,0,0,1,5.26,1.92Zm-3.34,5H9.67v3H1.92Zm1.23,4.94H9.67v9.11H3.15Zm15,9.11H11.59V11.83H18.1Z" id="el_SyfGqzlD3m"/></g></g></svg>
                            <svg class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="-14.5 -14 50 50" id="el_SyGqzxv2m" height="50" width="50"><style>@-webkit-keyframes el_SyfGqzlD3m_HyLSVgPhm_Animation{
                                                                                                                                                                   0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                                                                                                                                                   6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                                                                                                                                                   13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(-5deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(-5deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                                                                                                                                                   16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                                                                                                                                                   20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(5deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(5deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                                                                                                                                                   23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                                                                                                                                                   100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}}
                                    @keyframes el_SyfGqzlD3m_HyLSVgPhm_Animation{
                                        0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                        6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                        13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(-5deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(-5deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                        16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                        20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(5deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(5deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                        23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}
                                        100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);transform: translate(10.664999961853027px, 11.456446766853333px) rotate(0deg) translate(-10.664999961853027px, -11.456446766853333px);}}
                                    @-webkit-keyframes el_SyfGqzlD3m_SJyhGxP3Q_Animation{
                                        0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                                        6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);}
                                        16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);}
                                        23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        33.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        41.11%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                                        66.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                                        100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}}
                                    @keyframes el_SyfGqzlD3m_SJyhGxP3Q_Animation{
                                        0%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                                        6.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        13.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(-3px, -5px);}
                                        16.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        20%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(3px, -5px);}
                                        23.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        33.33%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, -5px);}
                                        41.11%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                                        66.67%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}
                                        100%{-webkit-transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);transform: translate(10.664999961853027px, 11.456446766853333px) translate(-10.664999961853027px, -11.456446766853333px) translate(0px, 0px);}}
                                    #el_SyGqzxv2m *{-webkit-animation-duration: 3s;animation-duration: 3s;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}
                                    #el_SyfGqzlD3m{fill: #e83b4b;}
                                    #el_SyfGqzlD3m_SJyhGxP3Q{-webkit-animation-name: el_SyfGqzlD3m_SJyhGxP3Q_Animation;animation-name: el_SyfGqzlD3m_SJyhGxP3Q_Animation;}
                                    #el_SyfGqzlD3m_HyLSVgPhm{-webkit-animation-name: el_SyfGqzlD3m_HyLSVgPhm_Animation;animation-name: el_SyfGqzlD3m_HyLSVgPhm_Animation;}</style><defs/><title>podarok</title><g id="el_Byxf5zgP2Q" data-name="Слой 2"><g id="el_HJ-M5zxv37" data-name="Слой 1"><g id="el_SyfGqzlD3m_SJyhGxP3Q" data-animator-group="true" data-animator-type="0"><g id="el_SyfGqzlD3m_HyLSVgPhm" data-animator-group="true" data-animator-type="1"><path d="M20.29,5H16.92A6.25,6.25,0,0,0,18.07,3.9a2.46,2.46,0,0,0,.6-2.71,2,2,0,0,0-1.25-1A6.58,6.58,0,0,0,13,.73a8.45,8.45,0,0,0-2.29,2.42A8.19,8.19,0,0,0,8.38.73,6.55,6.55,0,0,0,3.93.18a2,2,0,0,0-1.26,1C2.13,2.36,2.86,3.82,4.44,5H1a1,1,0,0,0-1,1v4.94a1,1,0,0,0,1,1h.27V21.9a1,1,0,0,0,1,1H19.06a1,1,0,0,0,1-1V11.83h.27a1,1,0,0,0,1-1V5.93A1,1,0,0,0,20.29,5Zm-1,4.94H11.59v-3h7.74ZM13.91,2.4a4.81,4.81,0,0,1,3-.4c.05.22-.5,1.21-2.11,2l-2.4,0A6.29,6.29,0,0,1,13.91,2.4ZM5.26,1.92a4.79,4.79,0,0,1,2.17.48A6,6,0,0,1,8.93,4L6.53,4A4.2,4.2,0,0,1,4.36,2.08,1.72,1.72,0,0,1,5.26,1.92Zm-3.34,5H9.67v3H1.92Zm1.23,4.94H9.67v9.11H3.15Zm15,9.11H11.59V11.83H18.1Z" id="el_SyfGqzlD3m"/></g></g></g></g></svg>
                        </div>
                        <div class="product__header">Выберите подарок к покупке</div>
                        <?php foreach($productPresents as $index => $product) {
                            $filename = explode('.', basename($product->present_image));
                            if (isset($filename[1])) {
                                $image = "/images/thumbs/$filename[0]-39-50.$filename[1]";
                            } else {
                                $image = '';
                            }
                            ?>
                            <label class="product__present">
                                <input type="radio" name="present_artikul" value="<?=$product->artikul?>"<?=($index == 0) ? ' checked': '' ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 23.1"><g><polygon points="16.1 0 13.6 1 6.8 17.9 2.8 12.7 0.3 12.4 0 15 6.3 23.1 8.6 23.1 17 2.4 16.1 0"></polygon></g></svg>
                                <span class="product__presentWrapper">
                                    <span class="product__presentImage">
                                        <img src="<?=$image?>" alt="">
                                    </span>
                                    <span class="product__presentInfo">
                                        <span class="product__presentInfoTop">
                                            <span class="product__presentPrice"><?=number_format($product->price, 0, '', ' ')?> <span class="rubl">₽</span></span>
                                             /
                                            <span class="product__presentFree">Бесплатно!</span>
                                        </span>
                                        <span class="product__presentText"><span><?=$product->name?></span></span>
                                    </span>
                                </span>
                            </label>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="product__features">
                    <div class="product__feature">
                        <div class="product__featureIcon product__featureIcon_1">
                            <svg class="notanimated" xmlns="http://www.w3.org/2000/svg" viewBox="-16 0 104 29" height="29" width="100"><defs/><g data-animator-group="true" data-animator-type="0"><g data-name="Слой 2"><g data-name="Слой 1"><path d="M19.55,8.7h-8a1.25,1.25,0,0,0,0,2.5h8a1.25,1.25,0,0,0,0-2.5Z" id="el_rkMw0wev3m"/><path d="M18.46,4.2H5.38a1.25,1.25,0,0,0,0,2.5H18.46a1.25,1.25,0,0,0,0-2.5Z"/><path d="M17,0H1.21a1.25,1.25,0,0,0,0,2.5H17A1.25,1.25,0,0,0,17,0Z"/><path d="M66.73,11.84c-1.74-2-3.75-2.31-5-4.2-1.45-2.2-2.57-4.71-3.83-7A1.26,1.26,0,0,0,56.82,0H20.38a1.26,1.26,0,0,0-1.21,1.58C20.64,6,22,9.42,22,13.9c0,3.81-.38,9.51,4.35,10.26a6.87,6.87,0,0,0,6.7,5.69,7,7,0,0,0,6.73-5.6H52.28A6.84,6.84,0,0,0,59,29.85a6.94,6.94,0,0,0,6.75-5.73C70.61,23,69.16,14.68,66.73,11.84ZM50.09,8.7a3.73,3.73,0,0,1,0-1.29C50.49,5.69,51.62,6,52.83,6H58c.41.85.82,1.82,1.3,2.71ZM28.73,23c.3-5.58,8.71-5.63,8.71,0S29,28.58,28.73,23ZM54.6,23c.3-5.58,8.71-5.63,8.71,0S54.9,28.58,54.6,23Zm11-1.52a6.92,6.92,0,0,0-6.37-5.32,6.83,6.83,0,0,0-7,5.59H39.81a6.91,6.91,0,0,0-6.42-5.59,6.81,6.81,0,0,0-6.94,5.36c-1.1-.46-1.64-1.69-1.88-3.22a1.21,1.21,0,0,0,1.49-1.18V15.83a1.22,1.22,0,0,0-1.66-1.14,44,44,0,0,0,.1-4.9A38.88,38.88,0,0,0,22.15,2.5h28.4a53.88,53.88,0,0,0,5.54,0c.19.32.37.64.55,1-1.8,0-3.62-.11-5.4,0-3.77.28-3.68,3.57-3.49,6.46A1.28,1.28,0,0,0,49,11.2H61.28a20.14,20.14,0,0,1,2.93,2,8.75,8.75,0,0,1,1.7,2.07h-.07a1.25,1.25,0,0,0,0,2.5h.57V18C66.34,19,66.69,20.8,65.63,21.48Z"/><path d="M43.14,8.7H27a1.25,1.25,0,0,0,0,2.5H43.14A1.25,1.25,0,0,0,43.14,8.7Z"/><path d="M52.46,12.68H49.13a1.25,1.25,0,0,0,0,2.5h3.33A1.25,1.25,0,0,0,52.46,12.68Z"/><circle cx="33.08" cy="23" r="1.75"/><circle cx="58.96" cy="23" r="1.75"/></g></g></g></svg>
                            <svg class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="-16 0 104 29" id="el_rJwCwxwnQ" height="29" width="100"><style>@-webkit-keyframes el_HyEvCDxw3Q_Animation{0%{opacity: 0;}13.33%{opacity: 1;}30%{opacity: 0.3;}46.67%{opacity: 1;}63.33%{opacity: 0.3;}80%{opacity: 1;}96.67%{opacity: 0;}100%{opacity: 0;}}@keyframes el_HyEvCDxw3Q_Animation{0%{opacity: 0;}13.33%{opacity: 1;}30%{opacity: 0.3;}46.67%{opacity: 1;}63.33%{opacity: 0.3;}80%{opacity: 1;}96.67%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_rJXP0PlwhQ_Animation{0%{opacity: 0;}13.33%{opacity: 1;}30%{opacity: 0.3;}46.67%{opacity: 1;}63.33%{opacity: 0.3;}80%{opacity: 1;}96.67%{opacity: 0;}100%{opacity: 0;}}@keyframes el_rJXP0PlwhQ_Animation{0%{opacity: 0;}13.33%{opacity: 1;}30%{opacity: 0.3;}46.67%{opacity: 1;}63.33%{opacity: 0.3;}80%{opacity: 1;}96.67%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_rkMw0wev3m_Animation{0%{opacity: 0;}13.33%{opacity: 1;}30%{opacity: 0.3;}46.67%{opacity: 1;}63.33%{opacity: 0.3;}80%{opacity: 1;}96.67%{opacity: 0;}100%{opacity: 0;}}@keyframes el_rkMw0wev3m_Animation{0%{opacity: 0;}13.33%{opacity: 1;}30%{opacity: 0.3;}46.67%{opacity: 1;}63.33%{opacity: 0.3;}80%{opacity: 1;}96.67%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_HJlw0Dxv2Q_rJbbugDhX_Animation{0%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);}13.33%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);}30%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);}46.67%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);}63.33%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);}80%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);}96.67%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);}100%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);}}@keyframes el_HJlw0Dxv2Q_rJbbugDhX_Animation{0%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);}13.33%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);}30%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);}46.67%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);}63.33%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(8px, 0px);}80%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(12px, 0px);}96.67%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);}100%{-webkit-transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -7.5101851848558e-8px) translate(0.039999932050704956px, 7.5101851848558e-8px) translate(0px, 0px);}}#el_rJwCwxwnQ *{-webkit-animation-duration: 3s;animation-duration: 3s;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_rkMw0wev3m{fill: #e83b4b;-webkit-animation-name: el_rkMw0wev3m_Animation;animation-name: el_rkMw0wev3m_Animation;}#el_rJXP0PlwhQ{fill: #e83b4b;-webkit-animation-name: el_rJXP0PlwhQ_Animation;animation-name: el_rJXP0PlwhQ_Animation;}#el_HyEvCDxw3Q{fill: #e83b4b;-webkit-animation-name: el_HyEvCDxw3Q_Animation;animation-name: el_HyEvCDxw3Q_Animation;}#el_rkBPAPlDhm{fill: #e83b4b;}#el_BJLwRvlwh7{fill: #e83b4b;}#el_SyvP0Dxv2X{fill: #e83b4b;}#el_SJ_vRvlvh7{fill: #e83b4b;}#el_SJYvAveP3X{fill: #e83b4b;}#el_HJlw0Dxv2Q_rJbbugDhX{-webkit-animation-name: el_HJlw0Dxv2Q_rJbbugDhX_Animation;animation-name: el_HJlw0Dxv2Q_rJbbugDhX_Animation;}</style><defs/><g id="el_HJlw0Dxv2Q_rJbbugDhX" data-animator-group="true" data-animator-type="0"><g id="el_HJlw0Dxv2Q" data-name="Слой 2"><g id="el_HJZPAvevnQ" data-name="Слой 1"><path d="M19.55,8.7h-8a1.25,1.25,0,0,0,0,2.5h8a1.25,1.25,0,0,0,0-2.5Z"/><path d="M18.46,4.2H5.38a1.25,1.25,0,0,0,0,2.5H18.46a1.25,1.25,0,0,0,0-2.5Z" id="el_rJXP0PlwhQ"/><path d="M17,0H1.21a1.25,1.25,0,0,0,0,2.5H17A1.25,1.25,0,0,0,17,0Z" id="el_HyEvCDxw3Q"/><path d="M66.73,11.84c-1.74-2-3.75-2.31-5-4.2-1.45-2.2-2.57-4.71-3.83-7A1.26,1.26,0,0,0,56.82,0H20.38a1.26,1.26,0,0,0-1.21,1.58C20.64,6,22,9.42,22,13.9c0,3.81-.38,9.51,4.35,10.26a6.87,6.87,0,0,0,6.7,5.69,7,7,0,0,0,6.73-5.6H52.28A6.84,6.84,0,0,0,59,29.85a6.94,6.94,0,0,0,6.75-5.73C70.61,23,69.16,14.68,66.73,11.84ZM50.09,8.7a3.73,3.73,0,0,1,0-1.29C50.49,5.69,51.62,6,52.83,6H58c.41.85.82,1.82,1.3,2.71ZM28.73,23c.3-5.58,8.71-5.63,8.71,0S29,28.58,28.73,23ZM54.6,23c.3-5.58,8.71-5.63,8.71,0S54.9,28.58,54.6,23Zm11-1.52a6.92,6.92,0,0,0-6.37-5.32,6.83,6.83,0,0,0-7,5.59H39.81a6.91,6.91,0,0,0-6.42-5.59,6.81,6.81,0,0,0-6.94,5.36c-1.1-.46-1.64-1.69-1.88-3.22a1.21,1.21,0,0,0,1.49-1.18V15.83a1.22,1.22,0,0,0-1.66-1.14,44,44,0,0,0,.1-4.9A38.88,38.88,0,0,0,22.15,2.5h28.4a53.88,53.88,0,0,0,5.54,0c.19.32.37.64.55,1-1.8,0-3.62-.11-5.4,0-3.77.28-3.68,3.57-3.49,6.46A1.28,1.28,0,0,0,49,11.2H61.28a20.14,20.14,0,0,1,2.93,2,8.75,8.75,0,0,1,1.7,2.07h-.07a1.25,1.25,0,0,0,0,2.5h.57V18C66.34,19,66.69,20.8,65.63,21.48Z" id="el_rkBPAPlDhm"/><path d="M43.14,8.7H27a1.25,1.25,0,0,0,0,2.5H43.14A1.25,1.25,0,0,0,43.14,8.7Z" id="el_BJLwRvlwh7"/><path d="M52.46,12.68H49.13a1.25,1.25,0,0,0,0,2.5h3.33A1.25,1.25,0,0,0,52.46,12.68Z" id="el_SyvP0Dxv2X"/><circle cx="33.08" cy="23" r="1.75" id="el_SJ_vRvlvh7"/><circle cx="58.96" cy="23" r="1.75" id="el_SJYvAveP3X"/></g></g></g></svg>
                        </div>
                        <div class="product__featureHeader">
                            <div class="product__featureHeaderText">
                                <?php if ($mainpage->delivery_free_from >= $model->price) { ?>
                                    Доставим к
                                <?php } else { ?>
                                    <?php if (!$empty) { ?>
                                        Бесплатно доставим к
                                    <?php } else { ?>
                                        Бесплатно доставим
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <?php if (!$empty) { ?>
                                <select name="delivery_date" class="select-jquery-ui">
                                    <?php foreach($model->getNearDates() as $index => $date) { ?>
                                        <option value="<?=$date?>"<?=($index == 0) ? ' selected' : ''?>><?=$date?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($build = Build::findOne(['category_id' => $model->parent_id])) {
                        $buildPrice = $build->thisPrice($model->price)
                        ?>
                        <div class="product__feature">
                            <div class="product__featureIcon product__featureIcon_2">
                                <svg class="notanimated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39 39" height="39" width="39"><style>@-webkit-keyframes el_BJE_VAew3X_r198Clv27_Animation{0%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}100%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}}@keyframes el_BJE_VAew3X_r198Clv27_Animation{0%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}100%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}}@-webkit-keyframes el_B1z_VAlP2Q_HyxDReDnm_Animation{0%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}100%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}}@keyframes el_B1z_VAlP2Q_HyxDReDnm_Animation{0%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}100%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}}#el_By_4Cxw2m *{-webkit-animation-duration: 100ms;animation-duration: 100ms;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_B1z_VAlP2Q{fill: #e83a4a;}#el_HkmO4AgvnX{fill: #e83a4a;}#el_BJE_VAew3X{fill: #e83a4a;}#el_B1z_VAlP2Q_HyxDReDnm{-webkit-animation-name: el_B1z_VAlP2Q_HyxDReDnm_Animation;animation-name: el_B1z_VAlP2Q_HyxDReDnm_Animation;}#el_BJE_VAew3X_r198Clv27{-webkit-animation-name: el_BJE_VAew3X_r198Clv27_Animation;animation-name: el_BJE_VAew3X_r198Clv27_Animation;}</style><defs/><g data-name="Слой 2"><g data-name="Слой 1"><g data-animator-group="true" data-animator-type="0"><path d="M20.38,20.33a1.3,1.3,0,0,0-1.86,0,1.32,1.32,0,0,0,0,1.86l11,11a1.31,1.31,0,1,0,1.86-1.85Z"/></g><path d="M29.64,23a11.56,11.56,0,0,0,10-13.69,1.34,1.34,0,0,0-.91-1,1.32,1.32,0,0,0-1.31.33l-6.08,6.08-4.9-1.32-1.31-4.9,6.07-6.07a1.34,1.34,0,0,0,.33-1.32,1.31,1.31,0,0,0-1-.9A11.53,11.53,0,0,0,17.27,14.85L16.09,16,7.66,7.6,5.76,9.42l8.47,8.47L.4,31.72a1.32,1.32,0,0,0,0,1.86l5.9,5.89a1.28,1.28,0,0,0,.93.38,1.31,1.31,0,0,0,.93-.38L18.7,28.93l8.86,8.86a5.71,5.71,0,0,0,4,1.67,5.65,5.65,0,0,0,4-1.67l.35-.35h0a5.71,5.71,0,0,0,0-8.07ZM22,5.24A8.84,8.84,0,0,1,27.24,2.7L22.75,7.19a1.32,1.32,0,0,0-.34,1.27l1.71,6.37a1.29,1.29,0,0,0,.93.92l6.37,1.71a1.28,1.28,0,0,0,1.27-.34l4.49-4.49a8.93,8.93,0,0,1-9.91,7.77,1.93,1.93,0,0,0-.24,0l-6.58-6.58a1.27,1.27,0,0,0-.82-.35A8.91,8.91,0,0,1,22,5.24ZM7.23,36.68l-4-4L12.8,23l4,4Zm26.9-1.1-.36.35a3.13,3.13,0,0,1-4.35,0L14.81,21.33l4.71-4.71L34.13,31.23a3.08,3.08,0,0,1,0,4.35Z"/><g data-animator-group="true" data-animator-type="2"><polygon points="5.82 9.47 0 6.77 4.95 1.82 7.71 7.65 5.82 9.47"/></g></g></g></svg>
                                <svg class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39 39" id="el_By_4Cxw2m" height="39" width="39"><style>@-webkit-keyframes el_BJE_VAew3X_r198Clv27_Animation{0%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}30%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}100%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}}@keyframes el_BJE_VAew3X_r198Clv27_Animation{0%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}30%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}100%{-webkit-transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);transform: translate(3.8550000190734863px, 5.645000219345093px) scale(1, 1) translate(-3.8550000190734863px, -5.645000219345093px);}}@-webkit-keyframes el_B1z_VAlP2Q_HyxDReDnm_Animation{0%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}30%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(3px, -3px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(3px, -3px);}50%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}70%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(-3px, 4px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(-3px, 4px);}90%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}100%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}}@keyframes el_B1z_VAlP2Q_HyxDReDnm_Animation{0%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}30%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(3px, -3px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(3px, -3px);}50%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}70%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(-3px, 4px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(-3px, 4px);}90%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}100%{-webkit-transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);transform: translate(18.136747360229492px, 19.9383487701416px) translate(-18.136747360229492px, -19.9383487701416px) translate(0px, 0px);}}#el_By_4Cxw2m *{-webkit-animation-duration: 1s;animation-duration: 1s;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_B1z_VAlP2Q{fill: #e83a4a;}#el_HkmO4AgvnX{fill: #e83a4a;}#el_BJE_VAew3X{fill: #e83a4a;}#el_B1z_VAlP2Q_HyxDReDnm{-webkit-animation-name: el_B1z_VAlP2Q_HyxDReDnm_Animation;animation-name: el_B1z_VAlP2Q_HyxDReDnm_Animation;}#el_BJE_VAew3X_r198Clv27{-webkit-animation-name: el_BJE_VAew3X_r198Clv27_Animation;animation-name: el_BJE_VAew3X_r198Clv27_Animation;}</style><defs/><g id="el_rklOV0gw27" data-name="Слой 2"><g id="el_r1b_EAew3m" data-name="Слой 1"><g id="el_B1z_VAlP2Q_HyxDReDnm" data-animator-group="true" data-animator-type="0"><path d="M20.38,20.33a1.3,1.3,0,0,0-1.86,0,1.32,1.32,0,0,0,0,1.86l11,11a1.31,1.31,0,1,0,1.86-1.85Z" id="el_B1z_VAlP2Q"/></g><path d="M29.64,23a11.56,11.56,0,0,0,10-13.69,1.34,1.34,0,0,0-.91-1,1.32,1.32,0,0,0-1.31.33l-6.08,6.08-4.9-1.32-1.31-4.9,6.07-6.07a1.34,1.34,0,0,0,.33-1.32,1.31,1.31,0,0,0-1-.9A11.53,11.53,0,0,0,17.27,14.85L16.09,16,7.66,7.6,5.76,9.42l8.47,8.47L.4,31.72a1.32,1.32,0,0,0,0,1.86l5.9,5.89a1.28,1.28,0,0,0,.93.38,1.31,1.31,0,0,0,.93-.38L18.7,28.93l8.86,8.86a5.71,5.71,0,0,0,4,1.67,5.65,5.65,0,0,0,4-1.67l.35-.35h0a5.71,5.71,0,0,0,0-8.07ZM22,5.24A8.84,8.84,0,0,1,27.24,2.7L22.75,7.19a1.32,1.32,0,0,0-.34,1.27l1.71,6.37a1.29,1.29,0,0,0,.93.92l6.37,1.71a1.28,1.28,0,0,0,1.27-.34l4.49-4.49a8.93,8.93,0,0,1-9.91,7.77,1.93,1.93,0,0,0-.24,0l-6.58-6.58a1.27,1.27,0,0,0-.82-.35A8.91,8.91,0,0,1,22,5.24ZM7.23,36.68l-4-4L12.8,23l4,4Zm26.9-1.1-.36.35a3.13,3.13,0,0,1-4.35,0L14.81,21.33l4.71-4.71L34.13,31.23a3.08,3.08,0,0,1,0,4.35Z" id="el_HkmO4AgvnX"/><g id="el_BJE_VAew3X_r198Clv27" data-animator-group="true" data-animator-type="2"><polygon points="5.82 9.47 0 6.77 4.95 1.82 7.71 7.65 5.82 9.47" id="el_BJE_VAew3X"/></g></g></g></svg>
                            </div>
                            <div class="product__featureHeader">
                                <div class="product__featureHeaderText">
                                    <?php if ($buildPrice > 0) { ?>
                                        Соберём и настроим
                                    <?php } else { ?>
                                        Бесплатно соберём и настроим
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="product__feature">
                        <div class="product__featureIcon product__featureIcon_3">
                            <svg class="notanimated" xmlns="http://www.w3.org/2000/svg" viewBox="0 -9.5 36 60" height="60" width="36"><style>@-webkit-keyframes el_SkOpyWWv27_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SkOpyWWv27_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_ByDpkZbwn7_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_ByDpkZbwn7_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SJITyWbwhX_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SJITyWbwhX_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_BJrp1-bv3m_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_BJrp1-bv3m_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_S1V6kbZwhX_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_S1V6kbZwhX_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_rylaJ-WPhQ_rJOb-ZD3m_Animation{0%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}100%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}}@keyframes el_rylaJ-WPhQ_rJOb-ZD3m_Animation{0%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}100%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}}#el_ryTybbDnX *{-webkit-animation-duration: 100ms;animation-duration: 100ms;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_rJG6y-bvn7{fill: #e83a4a;}#el_S1QayZZvh7{fill: #e83a4a;}#el_S1V6kbZwhX{fill: #e83a4a;-webkit-animation-name: el_S1V6kbZwhX_Animation;animation-name: el_S1V6kbZwhX_Animation;}#el_BJrp1-bv3m{fill: #e83a4a;-webkit-animation-name: el_BJrp1-bv3m_Animation;animation-name: el_BJrp1-bv3m_Animation;}#el_SJITyWbwhX{fill: #e83a4a;-webkit-animation-name: el_SJITyWbwhX_Animation;animation-name: el_SJITyWbwhX_Animation;}#el_ByDpkZbwn7{fill: #e83a4a;-webkit-animation-name: el_ByDpkZbwn7_Animation;animation-name: el_ByDpkZbwn7_Animation;}#el_SkOpyWWv27{fill: #e83a4a;-webkit-animation-name: el_SkOpyWWv27_Animation;animation-name: el_SkOpyWWv27_Animation;}#el_rylaJ-WPhQ_rJOb-ZD3m{-webkit-animation-name: el_rylaJ-WPhQ_rJOb-ZD3m_Animation;animation-name: el_rylaJ-WPhQ_rJOb-ZD3m_Animation;}</style><defs/><g data-animator-group="true" data-animator-type="0"><g data-name="Слой 2"><g data-name="Слой 1"><path d="M30,37.05l-4.27-10a2,2,0,0,0,.5-.38A2.21,2.21,0,0,0,26.57,24a.33.33,0,0,1,0-.35.35.35,0,0,1,.3-.17h.05A2.26,2.26,0,0,0,28,19.19a.34.34,0,0,1-.17-.3.32.32,0,0,1,.17-.3,2.27,2.27,0,0,0-1.09-4.25h0a.32.32,0,0,1-.31-.17.33.33,0,0,1,0-.35,2.26,2.26,0,0,0-3.1-3.1.33.33,0,0,1-.35,0,.35.35,0,0,1-.17-.3,2.26,2.26,0,0,0-4.24-1.14h0a.33.33,0,0,1-.29.18.36.36,0,0,1-.31-.18,2.26,2.26,0,0,0-4.24,1.14.32.32,0,0,1-.17.3.35.35,0,0,1-.35,0,2.26,2.26,0,0,0-3.1,3.1.33.33,0,0,1,0,.35.33.33,0,0,1-.3.17h0A2.26,2.26,0,0,0,8.8,18.58a.35.35,0,0,1,0,.61,2.26,2.26,0,0,0,1.09,4.24h0a.35.35,0,0,1,.31.17.33.33,0,0,1,0,.35,2.23,2.23,0,0,0,.34,2.77,2,2,0,0,0,.44.33l-4.21,10a1,1,0,0,0,1.07,1.31l4.6-.92L15,41.38a1,1,0,0,0,.81.43h.08a1,1,0,0,0,.8-.58l1.62-3.86,1.76,3.88a1,1,0,0,0,.8.56H21a1,1,0,0,0,.81-.43l2.55-3.93,4.6.92A1,1,0,0,0,30,37.05ZM9.94,21.51h0a.31.31,0,0,1-.32-.26.3.3,0,0,1,.16-.38,2.26,2.26,0,0,0,0-4,.31.31,0,0,1-.16-.39.31.31,0,0,1,.33-.26,2.31,2.31,0,0,0,2-1.13,2.26,2.26,0,0,0,0-2.3.34.34,0,0,1,.47-.47,2.26,2.26,0,0,0,3.43-2,.35.35,0,0,1,.65-.17,2.26,2.26,0,0,0,2,1.17h0a2.24,2.24,0,0,0,2-1.17.31.31,0,0,1,.39-.16.31.31,0,0,1,.26.33,2.26,2.26,0,0,0,3.43,2,.34.34,0,0,1,.47.47,2.28,2.28,0,0,0,0,2.3,2.26,2.26,0,0,0,2,1.13.31.31,0,0,1,.33.26.31.31,0,0,1-.16.39,2.26,2.26,0,0,0,0,3.95.32.32,0,0,1,.16.4.3.3,0,0,1-.33.25,2.26,2.26,0,0,0-2,3.43.34.34,0,0,1-.47.47,2.26,2.26,0,0,0-3.43,2,.33.33,0,0,1-.26.34.33.33,0,0,1-.39-.17,2.23,2.23,0,0,0-2-1.16h0a2.25,2.25,0,0,0-2,1.16.35.35,0,0,1-.65-.17,2.26,2.26,0,0,0-3.43-2,.34.34,0,0,1-.47-.47,2.26,2.26,0,0,0-1.94-3.43Zm5.71,17.3-1.92-3a1,1,0,0,0-1-.42l-3.46.7L13,27.21a3,3,0,0,0,.31-.15.34.34,0,0,1,.35,0,.32.32,0,0,1,.17.31,2.23,2.23,0,0,0,.7,1.68l2.7,6Zm8.42-3.38a1,1,0,0,0-1,.42l-2,3-4.23-9.33a2.19,2.19,0,0,0,1.21-1,.34.34,0,0,1,.31-.17h0a.34.34,0,0,1,.3.17,2.22,2.22,0,0,0,1.95,1.17,2.49,2.49,0,0,0,.61-.08A2.23,2.23,0,0,0,23,27.36a.36.36,0,0,1,.17-.31.31.31,0,0,1,.35,0l.24.12c0,.05,0,.1,0,.15l3.78,8.8Z"/><path d="M18.26,24.41a5.53,5.53,0,1,0-5.52-5.52A5.52,5.52,0,0,0,18.26,24.41Zm0-9.13a3.61,3.61,0,1,1-3.6,3.61A3.61,3.61,0,0,1,18.26,15.28Z"/></g></g></g></svg>
                            <svg class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="0 -9.5 36 60" id="el_ryTybbDnX" height="60" width="36"><style>@-webkit-keyframes el_SkOpyWWv27_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@keyframes el_SkOpyWWv27_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@-webkit-keyframes el_ByDpkZbwn7_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@keyframes el_ByDpkZbwn7_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@-webkit-keyframes el_SJITyWbwhX_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@keyframes el_SJITyWbwhX_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@-webkit-keyframes el_BJrp1-bv3m_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@keyframes el_BJrp1-bv3m_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@-webkit-keyframes el_S1V6kbZwhX_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@keyframes el_S1V6kbZwhX_Animation{0%{opacity: 0;}50%{opacity: 1;}100%{opacity: 0;}}@-webkit-keyframes el_rylaJ-WPhQ_rJOb-ZD3m_Animation{0%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}50%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, -10px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, -10px);}100%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}}@keyframes el_rylaJ-WPhQ_rJOb-ZD3m_Animation{0%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}50%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, -10px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, -10px);}100%{-webkit-transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);transform: translate(-0.039999932050704956px, -0.03999995440244675px) translate(0.039999932050704956px, 0.03999995440244675px) translate(0px, 0px);}}#el_ryTybbDnX *{-webkit-animation-duration: 2s;animation-duration: 2s;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_rJG6y-bvn7{fill: #e83a4a;}#el_S1QayZZvh7{fill: #e83a4a;}#el_S1V6kbZwhX{fill: #e83a4a;-webkit-animation-name: el_S1V6kbZwhX_Animation;animation-name: el_S1V6kbZwhX_Animation;}#el_BJrp1-bv3m{fill: #e83a4a;-webkit-animation-name: el_BJrp1-bv3m_Animation;animation-name: el_BJrp1-bv3m_Animation;}#el_SJITyWbwhX{fill: #e83a4a;-webkit-animation-name: el_SJITyWbwhX_Animation;animation-name: el_SJITyWbwhX_Animation;}#el_ByDpkZbwn7{fill: #e83a4a;-webkit-animation-name: el_ByDpkZbwn7_Animation;animation-name: el_ByDpkZbwn7_Animation;}#el_SkOpyWWv27{fill: #e83a4a;-webkit-animation-name: el_SkOpyWWv27_Animation;animation-name: el_SkOpyWWv27_Animation;}#el_rylaJ-WPhQ_rJOb-ZD3m{-webkit-animation-name: el_rylaJ-WPhQ_rJOb-ZD3m_Animation;animation-name: el_rylaJ-WPhQ_rJOb-ZD3m_Animation;}</style><defs/><g id="el_rylaJ-WPhQ_rJOb-ZD3m" data-animator-group="true" data-animator-type="0"><g id="el_rylaJ-WPhQ" data-name="Слой 2"><g id="el_HJba1--D3m" data-name="Слой 1"><path d="M30,37.05l-4.27-10a2,2,0,0,0,.5-.38A2.21,2.21,0,0,0,26.57,24a.33.33,0,0,1,0-.35.35.35,0,0,1,.3-.17h.05A2.26,2.26,0,0,0,28,19.19a.34.34,0,0,1-.17-.3.32.32,0,0,1,.17-.3,2.27,2.27,0,0,0-1.09-4.25h0a.32.32,0,0,1-.31-.17.33.33,0,0,1,0-.35,2.26,2.26,0,0,0-3.1-3.1.33.33,0,0,1-.35,0,.35.35,0,0,1-.17-.3,2.26,2.26,0,0,0-4.24-1.14h0a.33.33,0,0,1-.29.18.36.36,0,0,1-.31-.18,2.26,2.26,0,0,0-4.24,1.14.32.32,0,0,1-.17.3.35.35,0,0,1-.35,0,2.26,2.26,0,0,0-3.1,3.1.33.33,0,0,1,0,.35.33.33,0,0,1-.3.17h0A2.26,2.26,0,0,0,8.8,18.58a.35.35,0,0,1,0,.61,2.26,2.26,0,0,0,1.09,4.24h0a.35.35,0,0,1,.31.17.33.33,0,0,1,0,.35,2.23,2.23,0,0,0,.34,2.77,2,2,0,0,0,.44.33l-4.21,10a1,1,0,0,0,1.07,1.31l4.6-.92L15,41.38a1,1,0,0,0,.81.43h.08a1,1,0,0,0,.8-.58l1.62-3.86,1.76,3.88a1,1,0,0,0,.8.56H21a1,1,0,0,0,.81-.43l2.55-3.93,4.6.92A1,1,0,0,0,30,37.05ZM9.94,21.51h0a.31.31,0,0,1-.32-.26.3.3,0,0,1,.16-.38,2.26,2.26,0,0,0,0-4,.31.31,0,0,1-.16-.39.31.31,0,0,1,.33-.26,2.31,2.31,0,0,0,2-1.13,2.26,2.26,0,0,0,0-2.3.34.34,0,0,1,.47-.47,2.26,2.26,0,0,0,3.43-2,.35.35,0,0,1,.65-.17,2.26,2.26,0,0,0,2,1.17h0a2.24,2.24,0,0,0,2-1.17.31.31,0,0,1,.39-.16.31.31,0,0,1,.26.33,2.26,2.26,0,0,0,3.43,2,.34.34,0,0,1,.47.47,2.28,2.28,0,0,0,0,2.3,2.26,2.26,0,0,0,2,1.13.31.31,0,0,1,.33.26.31.31,0,0,1-.16.39,2.26,2.26,0,0,0,0,3.95.32.32,0,0,1,.16.4.3.3,0,0,1-.33.25,2.26,2.26,0,0,0-2,3.43.34.34,0,0,1-.47.47,2.26,2.26,0,0,0-3.43,2,.33.33,0,0,1-.26.34.33.33,0,0,1-.39-.17,2.23,2.23,0,0,0-2-1.16h0a2.25,2.25,0,0,0-2,1.16.35.35,0,0,1-.65-.17,2.26,2.26,0,0,0-3.43-2,.34.34,0,0,1-.47-.47,2.26,2.26,0,0,0-1.94-3.43Zm5.71,17.3-1.92-3a1,1,0,0,0-1-.42l-3.46.7L13,27.21a3,3,0,0,0,.31-.15.34.34,0,0,1,.35,0,.32.32,0,0,1,.17.31,2.23,2.23,0,0,0,.7,1.68l2.7,6Zm8.42-3.38a1,1,0,0,0-1,.42l-2,3-4.23-9.33a2.19,2.19,0,0,0,1.21-1,.34.34,0,0,1,.31-.17h0a.34.34,0,0,1,.3.17,2.22,2.22,0,0,0,1.95,1.17,2.49,2.49,0,0,0,.61-.08A2.23,2.23,0,0,0,23,27.36a.36.36,0,0,1,.17-.31.31.31,0,0,1,.35,0l.24.12c0,.05,0,.1,0,.15l3.78,8.8Z" id="el_rJG6y-bvn7"/><path d="M18.26,24.41a5.53,5.53,0,1,0-5.52-5.52A5.52,5.52,0,0,0,18.26,24.41Zm0-9.13a3.61,3.61,0,1,1-3.6,3.61A3.61,3.61,0,0,1,18.26,15.28Z" id="el_S1QayZZvh7"/><path d="M31,20.14h4.5a1.25,1.25,0,0,0,0-2.5H31a1.25,1.25,0,0,0,0,2.5Z" id="el_S1V6kbZwhX"/><path d="M19.51,5.71V1.21a1.25,1.25,0,0,0-2.5,0v4.5a1.25,1.25,0,0,0,2.5,0Z" id="el_BJrp1-bv3m"/><path d="M1.21,20.14h4.5a1.25,1.25,0,0,0,0-2.5H1.21a1.25,1.25,0,0,0,0,2.5Z" id="el_SJITyWbwhX"/><path d="M28.21,10.81,31.4,7.63a1.25,1.25,0,0,0-1.77-1.77L26.45,9.05a1.25,1.25,0,0,0,1.76,1.76Z" id="el_ByDpkZbwn7"/><path d="M10.3,9.05,7.12,5.86A1.25,1.25,0,0,0,5.35,7.63l3.18,3.18A1.25,1.25,0,0,0,10.3,9.05Z" id="el_SkOpyWWv27"/></g></g></g></svg>
                        </div>
                        <div class="product__featureHeader">
                            <div class="product__featureHeaderText">Нашли дешевле? <a href="#" data-fancybox data-src="#callback" class="link">Снизим цену!</a></div>
                        </div>
                    </div>
                    <div class="product__feature">
                        <div class="product__featureIcon product__featureIcon_4">
                            <svg class="notanimated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 51 33" height="33" width="50"><style>@-webkit-keyframes el_By7x04bw3X_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_By7x04bw3X_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_Bkdx0Ebwn7_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_Bkdx0Ebwn7_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_r1DeCVbv37_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_r1DeCVbv37_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SkUe0VbvhQ_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SkUe0VbvhQ_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SJrl0V-DhQ_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SJrl0V-DhQ_Animation{0%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SkVlCEWv2m_Animation{0%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SkVlCEWv2m_Animation{0%{opacity: 0;}100%{opacity: 0;}}#el_SygR4ZvhX *{-webkit-animation-duration: 100ms;animation-duration: 100ms;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_rkzxAEbvn7{fill: #e83a4a;}#el_By7x04bw3X{fill: #e83a4a;-webkit-animation-name: el_By7x04bw3X_Animation;animation-name: el_By7x04bw3X_Animation;}#el_SkVlCEWv2m{fill: #e83a4a;-webkit-animation-name: el_SkVlCEWv2m_Animation;animation-name: el_SkVlCEWv2m_Animation;}#el_SJrl0V-DhQ{fill: #e83a4a;-webkit-animation-name: el_SJrl0V-DhQ_Animation;animation-name: el_SJrl0V-DhQ_Animation;}#el_SkUe0VbvhQ{fill: #e83a4a;-webkit-animation-name: el_SkUe0VbvhQ_Animation;animation-name: el_SkUe0VbvhQ_Animation;}#el_r1DeCVbv37{fill: #e83a4a;-webkit-animation-name: el_r1DeCVbv37_Animation;animation-name: el_r1DeCVbv37_Animation;}#el_Bkdx0Ebwn7{fill: #e83a4a;-webkit-animation-name: el_Bkdx0Ebwn7_Animation;animation-name: el_Bkdx0Ebwn7_Animation;}</style><defs/><g data-name="Слой 2"><g data-name="Слой 1"><path d="M20.06,24.66a9.09,9.09,0,0,0,1.65-1,7.22,7.22,0,0,0,7.08-7.2,12.45,12.45,0,0,0-24.89,0,1,1,0,1,0,1.92,0,10.53,10.53,0,0,1,21.05,0A5.27,5.27,0,0,1,24,21.14a8.9,8.9,0,0,0,1.31-4.66,9,9,0,1,0-12.7,8.18c-7.32.82-12.63,4-12.63,8a1,1,0,0,0,1.92,0c0-3,5.8-6.28,14.42-6.28s14.42,3.25,14.42,6.28a1,1,0,1,0,1.92,0C32.68,28.7,27.37,25.48,20.06,24.66ZM9.27,16.48a7.07,7.07,0,1,1,11.8,5.25,5.28,5.28,0,0,1-2.85-1.2,2.09,2.09,0,0,0,.12-.67,2,2,0,1,0-2,2,2.71,2.71,0,0,0,.41,0,7.26,7.26,0,0,0,2,1.29,7.07,7.07,0,0,1-9.52-6.63Z"/></g></g></svg>
                            <svg class="animated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 51 33" id="el_SygR4ZvhX" height="33" width="50"><style>@-webkit-keyframes el_Bkdx0Ebwn7_Animation{0%{opacity: 0;}28.00%{opacity: 0;}36%{opacity: 1;}44%{opacity: 0.3;}52%{opacity: 0.6;}60%{opacity: 0;}100%{opacity: 0;}}@keyframes el_Bkdx0Ebwn7_Animation{0%{opacity: 0;}28.00%{opacity: 0;}36%{opacity: 1;}44%{opacity: 0.3;}52%{opacity: 0.6;}60%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_r1DeCVbv37_Animation{0%{opacity: 0;}28.00%{opacity: 0;}36%{opacity: 0.6;}44%{opacity: 1;}52%{opacity: 0.3;}60%{opacity: 0;}100%{opacity: 0;}}@keyframes el_r1DeCVbv37_Animation{0%{opacity: 0;}28.00%{opacity: 0;}36%{opacity: 0.6;}44%{opacity: 1;}52%{opacity: 0.3;}60%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SkUe0VbvhQ_Animation{0%{opacity: 0;}28.00%{opacity: 0;}36%{opacity: 0.3;}44%{opacity: 0.6;}52%{opacity: 1;}60%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SkUe0VbvhQ_Animation{0%{opacity: 0;}28.00%{opacity: 0;}36%{opacity: 0.3;}44%{opacity: 0.6;}52%{opacity: 1;}60%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SJrl0V-DhQ_Animation{0%{opacity: 0;}60%{opacity: 0;}68%{opacity: 1;}76%{opacity: 1;}84%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SJrl0V-DhQ_Animation{0%{opacity: 0;}60%{opacity: 0;}68%{opacity: 1;}76%{opacity: 1;}84%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_SkVlCEWv2m_Animation{0%{opacity: 0;}12%{opacity: 1;}20%{opacity: 1;}28.00%{opacity: 0;}100%{opacity: 0;}}@keyframes el_SkVlCEWv2m_Animation{0%{opacity: 0;}12%{opacity: 1;}20%{opacity: 1;}28.00%{opacity: 0;}100%{opacity: 0;}}@-webkit-keyframes el_By7x04bw3X_Animation{0%{opacity: 0;}12%{opacity: 1;}76%{opacity: 1;}84%{opacity: 0;}100%{opacity: 0;}}@keyframes el_By7x04bw3X_Animation{0%{opacity: 0;}12%{opacity: 1;}76%{opacity: 1;}84%{opacity: 0;}100%{opacity: 0;}}#el_SygR4ZvhX *{-webkit-animation-duration: 2.5s;animation-duration: 2.5s;-webkit-animation-iteration-count: infinite;animation-iteration-count: infinite;-webkit-animation-timing-function: cubic-bezier(0, 0, 1, 1);animation-timing-function: cubic-bezier(0, 0, 1, 1);}#el_rkzxAEbvn7{fill: #e83a4a;}#el_By7x04bw3X{fill: #e83a4a;-webkit-animation-name: el_By7x04bw3X_Animation;animation-name: el_By7x04bw3X_Animation;}#el_SkVlCEWv2m{fill: #e83a4a;-webkit-animation-name: el_SkVlCEWv2m_Animation;animation-name: el_SkVlCEWv2m_Animation;}#el_SJrl0V-DhQ{fill: #e83a4a;-webkit-animation-name: el_SJrl0V-DhQ_Animation;animation-name: el_SJrl0V-DhQ_Animation;}#el_SkUe0VbvhQ{fill: #e83a4a;-webkit-animation-name: el_SkUe0VbvhQ_Animation;animation-name: el_SkUe0VbvhQ_Animation;}#el_r1DeCVbv37{fill: #e83a4a;-webkit-animation-name: el_r1DeCVbv37_Animation;animation-name: el_r1DeCVbv37_Animation;}#el_Bkdx0Ebwn7{fill: #e83a4a;-webkit-animation-name: el_Bkdx0Ebwn7_Animation;animation-name: el_Bkdx0Ebwn7_Animation;}</style><defs/><g id="el_Byex04bw3X" data-name="Слой 2"><g id="el_rJZlCNbvhX" data-name="Слой 1"><path d="M20.06,24.66a9.09,9.09,0,0,0,1.65-1,7.22,7.22,0,0,0,7.08-7.2,12.45,12.45,0,0,0-24.89,0,1,1,0,1,0,1.92,0,10.53,10.53,0,0,1,21.05,0A5.27,5.27,0,0,1,24,21.14a8.9,8.9,0,0,0,1.31-4.66,9,9,0,1,0-12.7,8.18c-7.32.82-12.63,4-12.63,8a1,1,0,0,0,1.92,0c0-3,5.8-6.28,14.42-6.28s14.42,3.25,14.42,6.28a1,1,0,1,0,1.92,0C32.68,28.7,27.37,25.48,20.06,24.66ZM9.27,16.48a7.07,7.07,0,1,1,11.8,5.25,5.28,5.28,0,0,1-2.85-1.2,2.09,2.09,0,0,0,.12-.67,2,2,0,1,0-2,2,2.71,2.71,0,0,0,.41,0,7.26,7.26,0,0,0,2,1.29,7.07,7.07,0,0,1-9.52-6.63Z" id="el_rkzxAEbvn7"/><path d="M45,18.89H30.39a1,1,0,0,1-.8-1.6L32,14V5.94A6,6,0,0,1,38,0h7a6,6,0,0,1,5.94,5.94v7A6,6,0,0,1,45,18.89Zm-12.59-2H45a4,4,0,0,0,3.94-4v-7A4,4,0,0,0,45,2H38A4,4,0,0,0,34,5.94v8.42a1,1,0,0,1-.2.6Z" id="el_By7x04bw3X"/><path d="M38.53,7a2.14,2.14,0,0,1,.36-1.13,2.66,2.66,0,0,1,1-.94,3.29,3.29,0,0,1,1.6-.38,3.44,3.44,0,0,1,1.5.32,2.4,2.4,0,0,1,1,.85,2.07,2.07,0,0,1,.36,1.17,1.86,1.86,0,0,1-.2.87,2.71,2.71,0,0,1-.49.65c-.18.18-.51.49-1,.92a3.19,3.19,0,0,0-.32.32,1.19,1.19,0,0,0-.18.25,1.09,1.09,0,0,0-.09.23c0,.07-.06.21-.1.4a.65.65,0,0,1-.7.61.73.73,0,0,1-.51-.2.77.77,0,0,1-.21-.59,2.19,2.19,0,0,1,.15-.85,2.34,2.34,0,0,1,.41-.64,9.19,9.19,0,0,1,.68-.64c.25-.22.43-.39.54-.5a1.44,1.44,0,0,0,.28-.37.89.89,0,0,0,.12-.45,1.05,1.05,0,0,0-.35-.79,1.29,1.29,0,0,0-.9-.32,1.27,1.27,0,0,0-1,.32,2.69,2.69,0,0,0-.52,1c-.13.44-.38.67-.75.67a.74.74,0,0,1-.56-.24A.69.69,0,0,1,38.53,7Zm2.86,6.42a.91.91,0,0,1-.63-.23.82.82,0,0,1-.26-.64.85.85,0,0,1,.25-.63.93.93,0,0,1,.64-.25.89.89,0,0,1,.62.25.85.85,0,0,1,.25.63.84.84,0,0,1-.26.64A.88.88,0,0,1,41.39,13.43Z" id="el_SkVlCEWv2m"/><path d="M40.73,9.58l-.18-2.81c0-.54-.06-.94-.06-1.18a1.05,1.05,0,0,1,.26-.75.85.85,0,0,1,.67-.28.67.67,0,0,1,.67.35,2.27,2.27,0,0,1,.17,1,6.91,6.91,0,0,1,0,.78L42,9.59a2.3,2.3,0,0,1-.18.79.49.49,0,0,1-.88,0A2.89,2.89,0,0,1,40.73,9.58Zm.65,3.85a.9.9,0,0,1-.62-.23.8.8,0,0,1-.27-.64.84.84,0,0,1,.26-.62.88.88,0,0,1,1.25,0,.89.89,0,0,1,0,1.26A.89.89,0,0,1,41.38,13.43Z" id="el_SJrl0V-DhQ"/><path d="M37.63,13.45a.92.92,0,0,1-.63-.24.83.83,0,0,1-.26-.65.84.84,0,0,1,.25-.62.88.88,0,0,1,1.25,0,.8.8,0,0,1,.26.62.82.82,0,0,1-.26.65A.85.85,0,0,1,37.63,13.45Z" id="el_SkUe0VbvhQ"/><path d="M41.39,13.45a.92.92,0,0,1-.63-.24.8.8,0,0,1-.26-.65.87.87,0,0,1,.87-.88.86.86,0,0,1,.63.26.84.84,0,0,1,.26.62.86.86,0,0,1-.26.65A.87.87,0,0,1,41.39,13.45Z" id="el_r1DeCVbv37"/><path d="M45.14,13.45a.88.88,0,0,1-.62-.24.8.8,0,0,1-.27-.65.89.89,0,0,1,.25-.62.86.86,0,0,1,.63-.26.89.89,0,0,1,.63.26.84.84,0,0,1,.26.62.86.86,0,0,1-.26.65A.89.89,0,0,1,45.14,13.45Z" id="el_Bkdx0Ebwn7"/></g></g></svg>
                        </div>
                        <div class="product__featureHeader">
                            <div class="product__featureHeaderText">Поможем <a href="#" data-fancybox="oneClick" data-src="#oneClick" class="link">заказать по телефону</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->