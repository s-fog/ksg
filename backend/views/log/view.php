<?php

$this->title = 'Логи';

?>
<div class="table-responsive">
    <div class="grid-view">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Тип</th>
                <th>Артикулы</th>
                <th>Сообщение</th>
            </tr>
            <?php foreach ($array as $item) {

                ?>
                <tr<?=($item['type'] == 'error') ? ' style="background-color: #ff6565;"' : ''?>>
                    <td><?=$item['type']?></td>
                    <td><?=$item['artikul']?></td>
                    <td><?=$item['message']?></td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>

<style>
    .grid-view td {
        white-space: normal;
    }
</style>