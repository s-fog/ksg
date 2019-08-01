<?php

use yii\db\Migration;

/**
 * Handles adding some to table `step`.
 */
class m190729_095547_add_some_columns_to_step_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('step', 'sort_order', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('step', 'sort_order');
    }
}
