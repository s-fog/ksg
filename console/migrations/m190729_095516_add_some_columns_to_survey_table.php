<?php

use yii\db\Migration;

/**
 * Handles adding some to table `survey`.
 */
class m190729_095516_add_some_columns_to_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('survey', 'sort_order', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('survey', 'sort_order');
    }
}
