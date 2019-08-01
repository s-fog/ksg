<?php

use yii\db\Migration;

/**
 * Handles the creation of table `step_option`.
 */
class m190729_111703_create_step_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('step_option', [
            'id' => $this->primaryKey(),
            'step_id' => $this->integer(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('step_option');
    }
}
