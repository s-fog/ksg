<?php

namespace common\models;

use Yii;
use \common\models\base\Param as BaseParam;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "param".
 */
class Param extends BaseParam
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return [
            [['name', 'name_en'], 'required'],
            [['name', 'name_en'], 'unique'],
            [['variants'], 'safe'],
            [['sort_order'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 255]
        ];
    }

    public function beforeValidate()
    {
        if ($_POST) {
            $this->variants = implode(',', $this->variants);
        }

        return parent::beforeValidate();
    }

    public static function getList() {
        $result = [];
        $params = Param::find()->orderBy(['name' => SORT_ASC])->all();

        foreach($params as $param) {
            foreach(explode(',', $param->variants) as $item) {
                $v = "{$param->name} -> $item";
                $result[$param->name][$v] = $v;
            }
        }

        return $result;
    }
}
