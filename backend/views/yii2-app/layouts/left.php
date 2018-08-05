<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Главная страница', 'url' => ['/site/index']],
                    ['label' => 'Поставщики', 'url' => ['/supplier/index']],
                    ['label' => 'Брэнды', 'url' => ['/brand/index']],
                    ['label' => 'Параметры', 'url' => ['/param/index']],
                    ['label' => 'Советчики', 'url' => ['/adviser/index']],
                    ['label' => 'Клиенты', 'url' => ['/client/index']],
                    ['label' => 'Валюты', 'url' => ['/currency/index']],
                    ['label' => 'Категории', 'url' => ['/category/index']],
                    ['label' => 'Формы обратной связи', 'url' => ['/callback/index']],
                    ['label' => 'Товары', 'url' => ['/product/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
