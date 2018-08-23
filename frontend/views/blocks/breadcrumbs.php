<?php if ($items) { ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumbs__inner">
                <li><a href="/" class="breadcrumbs__item"><span>Главная</span></a></li>
                <?php
                    foreach($items as $url => $name) {
                        if ($url == 0 && is_integer($url)) {
                            echo '<li><span class="breadcrumbs__item">'.$name.'</span></li>';
                        } else {
                            echo '<li><a href="'.$url.'" class="breadcrumbs__item"><span>'.$name.'</span></a></li>';
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>