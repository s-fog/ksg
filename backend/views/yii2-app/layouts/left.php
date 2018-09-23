<?php
use common\models\Callback;
use common\models\Order;

$callbackCount = Callback::find()->where(['status' => 0])->count();
if ($callbackCount == 0) $callbackCount = '';
$callbackTemplate = '<a href="{url}">
    <i class="fa fa-circle-o"></i>
    <span>{label}</span>
    <span class="pull-right-container">
              <span class="label label-primary pull-right">'.$callbackCount.'</span>
            </span>
</a>';

$ordersCount = Order::find()->where(['status' => 0])->count();
if ($ordersCount == 0) $ordersCount = '';
$ordersTemplate = '<a href="{url}">
    <i class="fa fa-circle-o"></i>
    <span>{label}</span>
    <span class="pull-right-container">
              <span class="label label-primary pull-right">'.$ordersCount.'</span>
            </span>
</a>';
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Главная страница', 'url' => ['/site/index']],
                    ['label' => 'Текстовые страницы', 'url' => ['/textpage/index']],
                    ['label' => 'Справочники',
                        'items' => [
                            ['label' => 'Поставщики', 'url' => ['/supplier/index']],
                            ['label' => 'Брэнды', 'url' => ['/brand/index']],
                            ['label' => 'Параметры', 'url' => ['/param/index']],
                            ['label' => 'Советчики', 'url' => ['/adviser/index']],
                            ['label' => 'Клиенты', 'url' => ['/client/index']],
                            ['label' => 'Валюты', 'url' => ['/currency/index']],
                        ]
                    ],
                    ['label' => 'Категории', 'url' => ['/category/index']],
                    [
                        'label' => 'Формы обратной связи',
                        'url' => ['/callback/index'],
                        'template' => $callbackTemplate,
                    ],
                    ['label' => 'Товары', 'url' => ['/product/index']],
                    ['label' => 'Слайдер на главной', 'url' => ['/mainslider/index']],
                    ['label' => 'Сборка', 'url' => ['/build/index']],
                    ['label' => 'Гарантия', 'url' => ['/waranty/index']],
                    ['label' => 'Подарки', 'url' => ['/present/index']],
                    [
                        'label' => 'Заказы',
                        'url' => ['/order/index'],
                        'template' => $ordersTemplate,
                    ],
                    ['label' => 'Новости', 'url' => ['/news/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
