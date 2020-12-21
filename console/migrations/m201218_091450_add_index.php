<?php

use yii\db\Migration;

/**
 * Class m201218_091450_add_index
 */
class m201218_091450_add_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('product_product_index_unique',
            'product_product', ['product_id', 'product_brother_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201218_091450_add_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201218_091450_add_index cannot be reverted.\n";

        return false;
    }
    */
}
