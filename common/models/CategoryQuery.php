<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery {
    public function active($int = 1) {
        $this->andWhere(['active' => $int]);

        return $this;
    }
}
?>