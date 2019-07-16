<?php

use yii\db\Migration;

/**
 * Handles the creation of table `changer`.
 */
class m190714_072025_create_changer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('changer', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'product_id' => $this->integer(),
            'old_price' => $this->float(),
            'new_price' => $this->float(),
            'percent' => $this->float(),
            'supplier_id' => $this->integer(),
            'brand_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('changer');
    }
}
