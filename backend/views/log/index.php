<?php

$this->title = 'Логи';

?>
<div class="table-responsive">
    <div class="grid-view">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th></th>
                <th>Название</th>
            </tr>
            <?php foreach (glob("{$_SERVER['DOCUMENT_ROOT']}/www/logs/*.log") as $filename) {
                $name = str_replace('.log', '', basename($filename));
                ?>
                <tr>
                    <td nowrap="nowrap">
                        <div class="action-buttons">
                            <a href="/officeback/log/view?name=<?=$name?>">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </div>
                    </td>
                    <td><?=$name?></td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>