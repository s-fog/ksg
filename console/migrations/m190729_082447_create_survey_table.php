<?php

use yii\db\Migration;

/**
 * Handles the creation of table `survey`.
 */
class m190729_082447_create_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('survey', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'seo_h1' => $this->string(),
            'seo_title' => $this->string(),
            'seo_description' => $this->text(),
            'under_header' => $this->text(),
            'youtube' => $this->string(),
            'youtube_text' => $this->text(),
            'button_text' => $this->string(),
            'button2_text' => $this->string(),
            'cupon_header' => $this->string(),
            'cupon_text' => $this->text(),
            'cupon_image' => $this->string(),
            'cupon_button' => $this->string(),
            'preview_image' => $this->string(),
            'introtext' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('survey');
    }
}
