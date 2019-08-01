<?php

use yii\db\Migration;

/**
 * Handles adding some to table `step_option`.
 */
class m190729_111927_add_some_columns_to_step_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('step_option', 'sort_order', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('step_option', 'sort_order');
    }
}
