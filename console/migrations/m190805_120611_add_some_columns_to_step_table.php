<?php

use yii\db\Migration;

/**
 * Handles adding some to table `step`.
 */
class m190805_120611_add_some_columns_to_step_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('step', 'inner_header', $this->text());
        $this->addColumn('step', 'inner_text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('step', 'inner_header');
        $this->dropColumn('step', 'inner_text');
    }
}
