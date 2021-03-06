<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $link
 * @property integer $sort_order
 * @property string $alias
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Brand extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
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
            [['name', 'link'], 'required'],
            [['description', 'link'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'image', 'alias'], 'string', 'max' => 255]
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
            'image' => 'Логотип(280x140)',
            'description' => 'Описание',
            'link' => 'Ссылка',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort_order' => 'Sort Order',
            'alias' => 'Урл',
        ];
    }




}
