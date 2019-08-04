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
                    ['label' => 'Магазин',
                        'items' => [
                            [
                                'label' => 'Заказы',
                                'url' => ['/order/index'],
                                'template' => $ordersTemplate,
                            ],
                            [
                                'label' => 'Формы обратной связи',
                                'url' => ['/callback/index'],
                                'template' => $callbackTemplate,
                            ],
                            ['label' => 'Подписки', 'url' => ['/subscribe/index']],
                            ['label' => 'Клиенты', 'url' => ['/client/index']],
                            ['label' => 'Импорт цены и наличия', 'url' => ['/simpleexcel/index']],
                        ]
                    ],
                    ['label' => 'Каталог',
                        'items' => [
                            ['label' => 'Товары', 'url' => ['/product/index']],
                            ['label' => 'Категории', 'url' => ['/category/index']],
                            ['label' => 'Параметры', 'url' => ['/param/index']],
                            ['label' => 'Подарки', 'url' => ['/present/index']],
                            ['label' => 'Сборка', 'url' => ['/build/index']],
                            ['label' => 'Гарантия', 'url' => ['/waranty/index']],
                        ]
                    ],
                    ['label' => 'Справочники',
                        'items' => [
                            ['label' => 'Брэнды', 'url' => ['/brand/index']],
                            ['label' => 'Поставщики', 'url' => ['/supplier/index']],
                            ['label' => 'Логи поставщиков', 'url' => ['/log/index']],
                            ['label' => 'Валюты', 'url' => ['/currency/index']],
                            ['label' => 'Советчики', 'url' => ['/adviser/index']],
                            ['label' => 'Главная страница', 'url' => ['/mainpage/index']],
                            ['label' => 'Слайдер на главной', 'url' => ['/mainslider/index']],
                        ]
                    ],
                    ['label' => 'Контент',
                        'items' => [
                            ['label' => 'Новости', 'url' => ['/news/index']],
                            ['label' => 'Текстовые страницы', 'url' => ['/textpage/index']],
                        ]
                    ],
                    ['label' => 'Опросы',
                        'items' => [
                            ['label' => 'Опросы', 'url' => ['/survey/index']],
                            ['label' => 'Заполненные опросы', 'url' => ['/survey-form/index']],
                        ]
                    ],
                    [
                        'label' => 'Логи изменений',
                        'url' => ['/changer/index']
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
