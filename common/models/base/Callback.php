<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the base-model class for table "callback".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $comment
 * @property integer $status
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $aliasModel
 */
abstract class Callback extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'callback';
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
            [['status'], 'required'],
            [['status', 'sort_order'], 'integer'],
            [['name', 'phone', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort_order' => 'Sort Order',
        ];
    }




}
