<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery}}`.
 */
class m210321_133000_create_delivery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%delivery}}', [
            'id' => $this->primaryKey(),
            'gte' => $this->integer(),
            'lt' => $this->integer(),
            'moscow_price' => $this->integer(),
            'other_price' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery}}');
    }
}
