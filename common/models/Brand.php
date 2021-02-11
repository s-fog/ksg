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
        return $this->hasMany(Product::className(), ['brand_id' => 'id'])
            ->joinWith(['productParams' => function($q) {
                $q->andWhere([ProductParam::tableName().'.available' => 10]);
            }])
            ->with([
                'category',
                'category.features',
                'category.features.featurevalues',
                'params',
                'brand',
                'images',
                'features',
                'features.featurevalues'
            ]);
    }

    public function getFilterFeatures ($category_id) {
        return FilterFeature::find()->where(['category_id' => $category_id])->orderBy(['name' => SORT_ASC])->all();
    }

    public static function sortBrands($filterBrands, $get) {
        ArrayHelper::multisort($filterBrands, ['name'], [SORT_ASC]);
        $filterBrandsIndexedById = [];
        $return = [];

        foreach($filterBrands as $filterBrand) {
            $filterBrandsIndexedById[$filterBrand['id']] = $filterBrand;
        }

        if (isset($get['brands'])) {
            foreach($get['brands'] as $brand_id) {
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

    public static function getAlphabetList() {
        $result = [];
        $brands = Brand::find()->orderBy(['name' => SORT_ASC])->all();
        $alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','А-Я'];
        $russianAlphabet = ['А','Б','В','Г','Д','Е','Ж','З','И','К','Д','М','Н','О','П','Р','С','Т','У','Ф','Ч','Ц','Ч','Ш','Щ','Э','Ю','Я'];

        foreach($brands as $brand) {
            foreach($alphabet as $letter) {
                if ($letter == 'А-Я') {
                    if (in_array(mb_strtoupper(mb_substr($brand->name, 0, 1)), $russianAlphabet)) {
                        $result[$letter][] = $brand;
                    }
                } else {
                    if (stristr($brand->name[0], $letter)) {
                        $result[$letter][] = $brand;
                    }
                }
            }
        }

        return $result;
    }
}
