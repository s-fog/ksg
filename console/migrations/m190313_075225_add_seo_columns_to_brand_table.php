<?php

use yii\db\Migration;

/**
 * Handles adding seo to table `brand`.
 */
class m190313_075225_add_seo_columns_to_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('brand', 'seo_h1', $this->string());
        $this->addColumn('brand', 'seo_title', $this->string());
        $this->addColumn('brand', 'seo_keywords', $this->string());
        $this->addColumn('brand', 'seo_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('brand', 'seo_h1');
        $this->dropColumn('brand', 'seo_title');
        $this->dropColumn('brand', 'seo_keywords');
        $this->dropColumn('brand', 'seo_description');
    }
}
