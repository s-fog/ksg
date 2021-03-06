<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "present".
 *
 * @property integer $id
 * @property integer $sort_order
 * @property string $product_artikul
 * @property integer $min_price
 * @property integer $max_price
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Present extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'present';
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
            [['sort_order', 'min_price', 'max_price'], 'integer'],
            [['product_artikul', 'min_price', 'max_price'], 'required'],
            [['product_artikul'], 'string', 'max' => 255]
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
            'sort_order' => 'Sort Order',
            'product_artikul' => 'Артикулы товаров(через запятую, без пробелов)',
            'min_price' => 'Цена от(включительно)',
            'max_price' => 'Цена до',
        ];
    }




}
