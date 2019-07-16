<?php

use yii\db\Migration;

/**
 * Handles adding some to table `product`.
 */
class m190716_154329_add_some_columns_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'mmodel', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product', 'mmodel');
    }
}
