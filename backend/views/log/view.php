<?php

$this->title = 'Логи';

?>
<div class="table-responsive">
    <div class="grid-view">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th style="width: 33%;">Тип</th>
                <th style="width: 33%;">Артикулы</th>
                <th style="width: 33%;">Сообщение</th>
            </tr>
            <?php foreach ($array as $item) {

                ?>
                <tr<?=($item['type'] == 'error') ? ' style="background-color: #ff6565;"' : ''?>>
                    <td style="width: 33%;"><?=$item['type']?></td>
                    <td style="width: 33%;"><?=$item['artikul']?></td>
                    <td style="width: 33%;"><?=$item['message']?></td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>