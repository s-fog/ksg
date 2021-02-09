<?php

use yii\db\Migration;

/**
 * Class m210209_103823_add_indexes
 */
class m210209_103823_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('feature_value_feature_id_index', 'feature_value', 'feature_id');
        $this->createIndex('feature_product_id_index', 'feature', 'product_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210209_103823_add_indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210209_103823_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
