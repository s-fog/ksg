<?php

namespace frontend\models;

use common\models\ProductParam;
use Yii;

class Sort
{
    public static function getOrderBy($model, $get) {
        $orderBy = ['price' => SORT_ASC];

        if (isset($get['sort'])) {
            $sort = explode('_', $get['sort']);

            if ($get['sort'] === 'available') {
                $orderBy = array_merge([ProductParam::tableName().'.available' => SORT_DESC], $orderBy);
            } else {
                $orderBy = [$sort[0] => $sort[1] == 'desc' ? SORT_DESC : SORT_ASC];
            }
        }

        return $orderBy;
    }
}