<?php

use yii\db\Migration;

/**
 * Handles the creation of table `step`.
 */
class m190729_094214_create_step_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('step', [
            'id' => $this->primaryKey(),
            'survey_id' => $this->integer(),
            'name' => $this->string(),
            'text' => $this->text(),
            'icon' => $this->text(),
            'options' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('step');
    }
}
