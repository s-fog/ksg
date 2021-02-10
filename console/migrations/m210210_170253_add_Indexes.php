<?php

use yii\db\Migration;

/**
 * Class m210210_170253_add_Indexes
 */
class m210210_170253_add_Indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('category_updated_at_index', 'category', 'updated_at');
        $this->createIndex('category_created_at_index', 'category', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210210_170253_add_Indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210210_170253_add_Indexes cannot be reverted.\n";

        return false;
    }
    */
}
