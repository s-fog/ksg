<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%supplier}}`.
 */
class m210408_094443_add_columns_to_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('supplier', 'xml_url', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
