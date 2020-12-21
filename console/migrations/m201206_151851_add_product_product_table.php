<?php

use yii\db\Migration;

/**
 * Class m201206_151851_add_product_product_table
 */
class m201206_151851_add_product_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_product', [
            'product_id' => $this->integer(),
            'product_brother_id' => $this->integer(),
        ]);

        $this->createIndex('product_product_id_index', 'product_product', ['product_id']);
        $this->createIndex('product_product_brother_id_index', 'product_product', ['product_brother_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201206_151851_add_product_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201206_151851_add_product_product_table cannot be reverted.\n";

        return false;
    }
    */
}
