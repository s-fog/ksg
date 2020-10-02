<?php

$this->title = 'Логи';

?>
<div class="btn btn-success js-reload-logs" data-href="/xml/import">Обновить логи</div>
<br>
<br>
<div class="table-responsive">
    <div class="grid-view">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th></th>
                <th>Название</th>
                <th>Дата изменения файла</th>
                <th>Кол-во ошибок</th>
                <th>Кол-во успехов</th>
            </tr>
            <?php foreach (glob("{$_SERVER['DOCUMENT_ROOT']}/www/logs/*.log") as $filename) {
                $name = str_replace('.log', '', basename($filename));
                $date = date('d-m-Y H:i',filemtime($filename));

                $str = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/www/logs/$name.log");
                $errors = 0;
                $successes = 0;

                foreach(explode("\r\n", $str) as $index => $item) {
                    if ($index != 0 && !empty($item)) {
                        $arr = explode(';', $item);

                        if ($arr[0] == 'error') {
                            $errors++;
                        }

                        if ($arr[0] == 'success') {
                            $successes++;
                        }
                    }
                }

                ?>
                <tr>
                    <td nowrap="nowrap">
                        <div class="action-buttons">
                            <a href="/officeback/index.php?r=log/view&name=<?=$name?>">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </div>
                    </td>
                    <td><?=$name?></td>
                    <td><?=$date?></td>
                    <td><?=$errors?></td>
                    <td><?=$successes?></td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>

<?php
$script = <<< JS
    $('.js-reload-logs').click(function() {
        var button = $(this);
        button.text('Выполняется');
        
        $.post(button.data('href'), '', function() {
            button.text('Обновить логи');
        });
    });
JS;
$this->registerJs($script);
?>