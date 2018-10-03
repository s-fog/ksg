<?php
$this->params['order'] = $order;
$this->params['products'] = unserialize(base64_decode($order->products));
?>