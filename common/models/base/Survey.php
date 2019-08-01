<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "survey".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $seo_h1
 * @property string $seo_title
 * @property string $seo_description
 * @property string $under_header
 * @property string $youtube
 * @property string $youtube_text
 * @property string $button_text
 * @property string $button2_text
 * @property string $cupon_header
 * @property string $cupon_text
 * @property string $cupon_image
 * @property string $cupon_button
 * @property string $preview_image
 * @property string $introtext
 * @property string $success_header
 * @property string $success_image
 * @property string $success_button
 * @property string $success_text
 * @property string $success_link_text
 * @property string $success_link
 * @property string $step_header
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Survey extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sort_order'
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seo_description', 'under_header', 'youtube_text', 'cupon_text', 'introtext', 'success_text', 'success_link'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'youtube', 'button_text', 'button2_text', 'cupon_header', 'cupon_image', 'cupon_button', 'preview_image', 'success_header', 'success_image', 'success_button', 'success_link_text', 'step_header'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'alias' => 'Alias',
            'seo_h1' => 'Seo H1',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'under_header' => 'Under Header',
            'youtube' => 'Youtube',
            'youtube_text' => 'Youtube Text',
            'button_text' => 'Button Text',
            'button2_text' => 'Button2 Text',
            'cupon_header' => 'Cupon Header',
            'cupon_text' => 'Cupon Text',
            'cupon_image' => 'Cupon Image',
            'cupon_button' => 'Cupon Button',
            'preview_image' => 'Preview Image',
            'introtext' => 'Introtext',
            'success_header' => 'Success Header',
            'success_image' => 'Success Image',
            'success_button' => 'Success Button',
            'success_text' => 'Success Text',
            'success_link_text' => 'Success Link Text',
            'success_link' => 'Success Link',
            'step_header' => 'Step Header',
            'sort_order' => 'Sort Order',
        ];
    }




}
