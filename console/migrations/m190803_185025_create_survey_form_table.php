<?php

use yii\db\Migration;

/**
 * Handles the creation of table `survey_form`.
 */
class m190803_185025_create_survey_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('survey_form', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'survey_id' => $this->integer(),
            'options' => $this->text(),
            'email' => $this->string(),
            'phone' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('survey_form');
    }
}
