<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "build".
 *
 * @property integer $id
 * @property string $name
 * @property string $seo_h1
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $sort_order
 * @property integer $category_id
 * @property string $text
 * @property integer $price
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Build extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'build';
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
            [['seo_description', 'text'], 'string'],
            [['sort_order', 'category_id', 'price'], 'integer'],
            [['category_id', 'text', 'price'], 'required'],
            [['name', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'seo_h1' => 'Seo H1',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'sort_order' => 'Sort Order',
            'category_id' => 'Категория',
            'text' => 'Текст',
            'price' => 'Цена',
        ];
    }




}
