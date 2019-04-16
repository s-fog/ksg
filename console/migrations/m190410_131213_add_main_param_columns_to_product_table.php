<?php

use yii\db\Migration;

/**
 * Handles adding main_param to table `product`.
 */
class m190410_131213_add_main_param_columns_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'main_param', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product', 'main_param');
    }
}
