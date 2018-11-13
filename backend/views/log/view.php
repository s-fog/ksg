<?php

$this->title = 'Логи';

?>
<div class="table-responsive">
    <div class="grid-view">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th style="width: 20%;">Тип</th>
                <th style="width: 40%;">Артикулы</th>
                <th style="width: 40%;">Сообщение</th>
            </tr>
            <?php foreach ($array as $item) {
                if ($item['type'] == 'error') {
                    $bg = ' style="background-color: #ff6565;"';
                } else if ($item['type'] == 'attention') {
                    $bg = ' style="background-color: #e4ff00;"';
                } else {
                    $bg = '';
                }
                ?>
                <tr<?=$bg?>>
                    <td style="width: 20%;"><?=$item['type']?></td>
                    <td style="width: 40%;"><?=$item['artikul']?></td>
                    <td style="width: 40%;"><?=$item['message']?></td>
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