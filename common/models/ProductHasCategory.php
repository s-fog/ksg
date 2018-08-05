<?php

namespace common\models;

use Yii;
use \common\models\base\ProductHasCategory as BaseProductHasCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_has_category".
 */
class ProductHasCategory extends BaseProductHasCategory
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
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
    
    public static function getValues($product_id) {
        $category_ids = ArrayHelper::map(
            ProductHasCategory::findAll(['product_id' => $product_id]),
            'category_id',
            'category_id'
        );

        $categories = Category::findAll($category_ids);
        return ArrayHelper::map($categories, 'id', 'id');
    }
}
