<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%category}}`.
 */
class m201006_111719_add_some_columns_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'filter_url', $this->text());
        $this->createIndex('catagory_filter_url_index', 'category', 'filter_url');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
