<?php
$this->params['order'] = $order;
$this->params['products'] = unserialize(base64_decode($order->products));
?>

<?php if ($paying) {
    echo '<div class="h1" style="padding: 30px 0;text-align: center;"><img src="https://www.ksg.ru/img/mail/zakaz_oplachen.png" class="h1__image" alt="" style="display: inline-block;"></div>';
} else {
    echo '<div class="h1" style="padding: 30px 0;text-align: center;"><img src="https://www.ksg.ru/img/mail/thanks.jpg" class="h1__image" alt="" style="display: inline-block;"></div>';
} ?>
