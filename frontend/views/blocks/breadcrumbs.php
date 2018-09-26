<?php if ($items) { ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumbs__inner" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope
                    itemtype="http://schema.org/ListItem">
                    <a href="/" class="breadcrumbs__item" itemscope itemtype="http://schema.org/Thing"
                       itemprop="item" itemid="/"><span itemprop="name">Главная</span></a><meta itemprop="position" content="1" /></li>
                <?php
                    $i = 2;
                    foreach($items as $url => $name) {
                        if ($url == 0 && is_integer($url)) {
                            echo '<li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem">
      <span class="breadcrumbs__item" itemprop="name">'.$name.'</span>
       <meta itemprop="position" content="'.$i.'" />
      </li>';
                        } else {
                            echo '<li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem"><a href="'.$url.'" class="breadcrumbs__item" itemid="'.$url.'" itemscope itemtype="http://schema.org/Thing"
       itemprop="item">
       <span itemprop="name">'.$name.'</span>
       </a>
       <meta itemprop="position" content="'.$i.'" />
       </li>';
                        }
                        $i++;
                    }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>