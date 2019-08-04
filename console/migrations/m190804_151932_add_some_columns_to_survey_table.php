<?php

use yii\db\Migration;

/**
 * Handles adding some to table `survey`.
 */
class m190804_151932_add_some_columns_to_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('survey', 'email_step_header', $this->text());
        $this->addColumn('survey', 'email_step_text', $this->text());
        $this->addColumn('survey', 'phone_step_text', $this->text());
        $this->addColumn('survey', 'phone_step_header', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('survey', 'email_step_header');
        $this->dropColumn('survey', 'email_step_text');
        $this->dropColumn('survey', 'phone_step_text');
        $this->dropColumn('survey', 'phone_step_header');
    }
}
