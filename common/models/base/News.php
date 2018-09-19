<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "news".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $seo_h1
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $sort_order
 * @property string $html
 * @property string $html2
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class News extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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
            [['name'], 'required'],
            [['seo_description', 'html', 'html2', 'image'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255]
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
            'alias' => 'Урл',
            'created_at' => 'Дата создания',
            'updated_at' => 'Updated At',
            'seo_h1' => 'Seo H1',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'sort_order' => 'Sort Order',
            'html' => 'Контент(колоночный)',
            'html2' => 'Контент(обычный)',
            'image' => 'Изображение(260x150)',
            'introtext' => 'Введение',
        ];
    }




}