<?php

use yii\db\Migration;

/**
 * Class m210210_172901_add_Indexes
 */
class m210210_172901_add_Indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('category_alias_index', 'category', 'alias');
        $this->createIndex('product_alias_index', 'product', 'alias');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210210_172901_add_Indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210210_172901_add_Indexes cannot be reverted.\n";

        return false;
    }
    */
}
