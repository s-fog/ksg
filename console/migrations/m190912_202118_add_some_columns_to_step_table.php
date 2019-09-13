<?php

use yii\db\Migration;

/**
 * Handles adding some to table `step`.
 */
class m190912_202118_add_some_columns_to_step_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('step', 'category_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('step', 'category_id');
    }
}
