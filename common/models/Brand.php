<?php

namespace common\models;

use Yii;
use \common\models\base\Brand as BaseBrand;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "brand".
 */
class Brand extends BaseBrand
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => SluggableBehavior::className(),
                    'attribute' => 'name',
                    'slugAttribute' => 'alias'
                ],
            ]
        );
    }

    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['image'], 'required', 'on' => 'create'],
            [['description', 'link'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['image'], 'image', 'maxSize' => 1000000,  'minWidth' => 280, 'minHeight' => 140, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function getProductCount() {
        $productsCount = Product::find()->where(['brand_id' => $this->id])->select('id')->count();

        return $productsCount;
    }

    public function getBreadcrumbs() {
        $parent = Textpage::findOne(2);
        $items[Url::to(['site/index', 'alias' => $parent->alias])] = $parent->name;
        $items[0] = $this->name;
        return $items;
    }

    public function getUrl() {
        return Url::to(['brand/view', 'alias' => $this->alias]);
    }

    public function getProducts () {
        return $this->hasMany(Product::className(), ['brand_id' => 'id']);
    }

    public function getFilterFeatures ($category_id) {
        return FilterFeature::find()->where(['category_id' => $category_id])->orderBy(['name' => SORT_ASC])->all();
    }

    public static function sortBrands($filterBrands) {
        ArrayHelper::multisort($filterBrands, ['name'], [SORT_ASC]);
        $filterBrandsIndexedById = [];
        $return = [];

        foreach($filterBrands as $filterBrand) {
            $filterBrandsIndexedById[$filterBrand['id']] = $filterBrand;
        }

        if (isset($_GET['brands'])) {
            foreach($_GET['brands'] as $brand_id) {
                $return[intval($brand_id)] = $filterBrandsIndexedById[intval($brand_id)];
            }
        }

        foreach($filterBrandsIndexedById as $brand_id => $brandArray) {
            if (!array_key_exists($brand_id, $return)) {
                $return[$brand_id] = $brandArray;
            }
        }

        return $return;
    }
}
