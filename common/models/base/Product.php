<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $code
 * @property integer $hit
 * @property integer $parent_id
 * @property integer $brand_id
 * @property integer $supplier
 * @property integer $price
 * @property integer $price_old
 * @property integer $currency_id
 * @property string $description
 * @property integer $adviser_id
 * @property string $adviser_text
 * @property string $instruction
 * @property string $video
 * @property string $disallow_xml
 * @property string $seo_h1
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $sort_order
 * @property integer $popular
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Product extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
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
            [['name', 'hit', 'parent_id', 'brand_id', 'supplier', 'price', 'currency_id', 'description', 'disallow_xml'], 'required'],
            [['hit', 'parent_id', 'brand_id', 'supplier', 'price', 'price_old', 'currency_id', 'adviser_id', 'sort_order', 'popular'], 'integer'],
            [['description', 'adviser_text', 'seo_description'], 'string'],
            [['name', 'alias', 'code', 'instruction', 'video', 'disallow_xml', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255]
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
            'code' => 'Сгенерированный код товара',
            'hit' => 'Хит продаж?',
            'parent_id' => 'Выберите родительскую категорию',
            'brand_id' => 'Бренд',
            'supplier' => 'Поставщик',
            'price' => 'Цена',
            'price_old' => 'Старая цена',
            'currency_id' => 'Валюта',
            'description' => 'Описание товара',
            'adviser_id' => 'Советчик',
            'adviser_text' => 'Текст советчика',
            'instruction' => 'Инструкция к товару',
            'video' => 'id видео на youtube',
            'disallow_xml' => 'Запретить выгрузку в xml?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'seo_h1' => 'Seo H1',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'sort_order' => 'Sort Order',
            'popular' => 'Popular',
            'present_image' => 'Изображение, если этот товар подарок(39x50)',
        ];
    }




}
