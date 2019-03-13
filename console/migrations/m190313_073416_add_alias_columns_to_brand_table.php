<?php

use yii\db\Migration;

/**
 * Handles adding alias to table `brand`.
 */
class m190313_073416_add_alias_columns_to_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('brand', 'alias', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('brand', 'alias');
    }
}
