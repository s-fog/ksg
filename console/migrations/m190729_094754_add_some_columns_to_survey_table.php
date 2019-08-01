<?php

use yii\db\Migration;

/**
 * Handles adding some to table `survey`.
 */
class m190729_094754_add_some_columns_to_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('survey', 'success_header', $this->string());
        $this->addColumn('survey', 'success_image', $this->string());
        $this->addColumn('survey', 'success_button', $this->string());
        $this->addColumn('survey', 'success_text', $this->text());
        $this->addColumn('survey', 'success_link_text', $this->string());
        $this->addColumn('survey', 'success_link', $this->text());
        $this->addColumn('survey', 'step_header', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('survey', 'success_header');
        $this->dropColumn('survey', 'success_image');
        $this->dropColumn('survey', 'success_button');
        $this->dropColumn('survey', 'success_text');
        $this->dropColumn('survey', 'success_link_text');
        $this->dropColumn('survey', 'success_link');
        $this->dropColumn('survey', 'step_header');
    }
}
