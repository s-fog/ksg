<?php

namespace frontend\models;

use Yii;

class Sort
{
    public static function getOrderBy($model, $get) {
        $orderBy = [];

        if (
            ($model::className() == 'common\models\Brand') ||
            ($model::className() == 'common\models\Category' && ($model->level === 3 || in_array($model->type, [1, 2, 3, 4])))
        ) {
            if (isset($get['sort'])) {
                $sort = explode('_', $get['sort']);

                if ($sort[0] == 'price') {
                    if ($sort[1] == 'desc') {
                        $orderBy = [$sort[0] => SORT_DESC];
                    } else if ($sort[1] == 'asc') {
                        $orderBy = [$sort[0] => SORT_ASC];
                    }
                } else if ($sort[0] == 'popular') {
                    if ($sort[1] == 'desc') {
                        $orderBy = [$sort[0] => SORT_DESC];
                    } else if ($sort[1] == 'asc') {
                        $orderBy = [$sort[0] => SORT_ASC];
                    }
                }
            } else {
                $orderBy = ['price' => SORT_ASC];
            }
        } else {
            if (isset($get['sort'])) {
                $sort = explode('_', $get['sort']);

                if ($sort[0] == 'price') {
                    if ($sort[1] == 'desc') {
                        $orderBy = [$sort[0] => SORT_DESC];
                    } else if ($sort[1] == 'asc') {
                        $orderBy = [$sort[0] => SORT_ASC];
                    }
                }
            } else {
                $orderBy = ['popular' => SORT_DESC];
            }
        }

        return $orderBy;
    }
}