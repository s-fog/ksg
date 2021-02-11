<?php

namespace common\models;

use backend\models\CategoryCaching;
use backend\models\Sitemap;
use backend\models\UML;
use frontend\models\Sort;
use Yii;
use \common\models\base\Category as BaseCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 */
class Category extends BaseCategory
{

    public static function find() {
        return new CategoryQuery(get_called_class());
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => \nsept\behaviors\CyrillicSlugBehavior::className(),
                    'attribute' => 'name',
                    'slugAttribute' => 'alias'
                ],
            ]
        );
    }

    public function rules()
    {
        return [
            [['aksses_ids'], 'safe'],
            [['name', 'type'], 'required'],
            [['type', 'sort_order', 'parent_id', 'priority', 'disallow_xml', 'brand_id', 'active'], 'integer'],
            [['text_advice', 'descr', 'seo_description', 'filter_url'], 'string'],
            [['name', 'alias', 'image_catalog', 'image_menu', 'video', 'video_header', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            ['parent_id', 'compare', 'compareValue' => 0, 'operator' => '!=', 'type' => 'number', 'when' => function ($model) {
                $result = false;
                $val = $model->type;

                if ($val == 1 || $val == 2 || $val == 3 || $val == 4) {
                    $result = true;
                }

                return $result;
            }, 'whenClient' => "function (attribute, value) {
                    var result = false;
                    var val = $('#category-parent_id').val();
                    
                    if (val == 1 || val == 2 || val == 3 || val == 4) {
                        result = true;
                    }
                    
                    return result;
                }"],
            ['brand_id', 'required', 'when' => function ($model) {
                return false;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#category-type').val() == 2;
                }"],
        ];
    }

    public function beforeSave($insert)
    {
        if (!empty($this->filter_url)) {
            $this->filter_url = preg_replace('#(.*)&sort=.+$#siU', '$1', $this->filter_url);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function beforeValidate()
    {
        /*if (!empty($this->features)) {
            $this->features = json_encode($this->features);
        }*/

        if (!empty($this->aksses_ids)) {
            $this->aksses_ids = json_encode($this->aksses_ids);
        }

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    public static function getCategoryChain($model = NULL) {
        $parents = ['0' => 'Нет родителя'];

        foreach(Category::find()
            ->where(['type' => [0, 2]])//категория
            ->orderBy(['name' => SORT_ASC])
            ->all() as $item) {
            if ($model == NULL || $model->id != $item->id) {
                $parents[$item->id] = $item->chain;
            }
        }

        asort($parents, SORT_STRING);

        return $parents;
    }

    public static function getCategoryChain3rdLevel() {
        $array = [];
        $parents = Category::getCategoryChain();

        foreach($parents as $id => $name) {
            if (substr_count($name, '->') == 2) {
                $array[$id] = $name;
            }
        }

        return $array;
    }

    public function getChain() {
        $item = $this;
        $name = $item->name;

        while($item->parent_id != 0) {
            $item = Category::findOne($item->parent_id);
            $name = "{$item->name} -> $name";
        }

        return $name;
    }

    public static function getList() {
        $result = [];

        foreach(Yii::$app->params['categoryTypes'] as $type => $typeName) {
            $categories = Category::find()
                ->where(['type' => $type])
                ->orderBy(['name' => SORT_ASC])
                ->all();

            foreach($categories as $category) {
                $result[$typeName][$category->id] = $category->chain;
            }
        }

        $sortedResult = [];

        foreach($result as $name => $gg) {
            $arr = $gg;
            asort($arr, SORT_STRING);
            $sortedResult[$name] = $arr;
        }

        return $sortedResult;
    }

    public function getFeatures() {
        return $this->hasMany(Feature::className(), ['category_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC]);
        /*return Feature::find()
            ->where(['category_id' => $this->id])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();*/
    }

    public function getInnerIds() {
        return ArrayHelper::getColumn($this->getInnerCategories(), 'id');
    }

    public function getInnerCategories() {
        $categories = [];
        $level = $this->getLevel();

        if ($level) {
            $categoriesFull = Yii::$app->cache->getOrSet('categories', function() {
                return Category::find()->all();
            }, 10);
            if ($level == 3) {
                $categories[] = $this;
            } else if ($level == 2) {
                $categories[] = $this->getParent0();
                $cats = [];

                foreach($categoriesFull as $cc) {
                    if ($cc->parent_id == $this->id) {
                        $cats[] = $cc;
                    }
                }

                foreach($cats as $cat) {
                    $categories[] = $cat;
                }
            } else if ($level == 1) {
                $categories[] = $this;
                $cats = [];

                foreach($categoriesFull as $cc) {
                    if ($cc->parent_id == $this->id) {
                        $cats[] = $cc;
                    }
                }

                foreach($cats as $cat) {
                    $categories[] = $cat;

                    foreach($categoriesFull as $cc) {
                        if ($cc->parent_id == $cat->id) {
                            $categories[] = $cc;
                        }
                    }
                }
            } else {
                return $categories;
            }
        } else {
            return $categories;
        }

        return $categories;
    }

    public function getLevel() {
        if ($this->type != 0) {
            return [];//Не Категория
        }

        if ($this->parent_id == 0) {
            return [1];
        } else {
            $cat = Category::find()->where(['id' => $this->parent_id, 'type' => 0])->one();

            if ($cat->parent_id == 0) {
                return [2, $cat];
            } else {
                $catt = Category::find()->where(['id' => $cat->parent_id, 'type' => 0])->one();

                if ($catt->parent_id == 0) {
                    return [3, $cat, $catt];
                }
            }

            return [];
        }
    }

    public function getBreadcrumbs() {
        //$items = ['/catalog' => 'Каталог'];
        $items = [];
        $parent0 = Category::findOne(['id' => $this->parent_id]);

        if (!$parent0) {
            $items[0] = $this->name;
            return $items;
        }

        if ($parent0->parent_id == 0) {
            $parent0Url = $parent0->url;
            $items[$parent0Url] = $parent0->name;
        } else {
            $parent1 = Category::findOne(['id' => $parent0->parent_id]);
            $items = [];

            if ($parent1->parent_id == 0) {
                $parent1Url = $parent1->url;
                $parent0Url = $parent0->url;
                $items[$parent1Url] = $parent1->name;
                $items[$parent0Url] = $parent0->name;
            } else {
                $parent2 = Category::findOne(['id' => $parent1->parent_id]);
                $items = [];

                if ($parent2->parent_id == 0) {
                    $parent2Url = $parent2->url;
                    $parent1Url = $parent1->url;
                    $parent0Url = $parent0->url;
                    $items[$parent2Url] = $parent2->name;
                    $items[$parent1Url] = $parent1->name;
                    $items[$parent0Url] = $parent0->name;
                } else {
                    $parent3 = Category::findOne(['id' => $parent2->parent_id]);
                    $items = [];

                    if ($parent3->parent_id == 0) {
                        $parent3Url = $parent3->url;
                        $parent2Url = $parent2->url;
                        $parent1Url = $parent1->url;
                        $parent0Url = $parent0->url;
                        $items[$parent3Url] = $parent3->name;
                        $items[$parent2Url] = $parent2->name;
                        $items[$parent1Url] = $parent1->name;
                        $items[$parent0Url] = $parent0->name;
                    }
                }
            }
        }

        $items[0] = $this->name;
        return $items;
    }

    public function getChildrenCategories() {
        $categories = Category::find()->where(['parent_id' => $this->id, 'type' => 0])->active()->all();

        if (!empty($categories)) {
            return $categories;
        } else {
            return [];
        }
    }

    public function getParent0() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id'])->with('parent1');
    }

    public function getParent1() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id'])->with('parent2');
    }

    public function getParent2() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id'])->with('parent3');
    }

    public function getParent3() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getUrl() {
        if (in_array($this->type, [1, 2, 4])) {
            $parent = Category::findOne(['id' => $this->parent_id]);

            return "/{$parent->alias}/{$this->alias}";
        } else if ($this->type === 3) {
            $parentBrand = Category::findOne(['id' => $this->parent_id]);
            $parent = Category::findOne(['id' => $parentBrand->parent_id]);

            return "/{$parent->alias}/{$this->alias}";
        } else {
            return "/{$this->alias}";
        }
    }

    public static function isAliasesEmpty($aliases) {
        $result = true;

        foreach($aliases as $alias) {
            if (!empty($alias)) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    public static function getCurrentCategory($aliases) {
        $model = '';
        $parent_id = '';
        $aliasesWithoutEmpty = [];
        $categories = Category::find()->active()
            ->with('productHasCategories')
            ->all();

        foreach($aliases as $alias) {
            if (empty($alias)) {
                break;
            }

            $aliasesWithoutEmpty[] = $alias;
        }

        foreach($aliasesWithoutEmpty as $alias) {
            if ($alias == 'tag') {
                continue;
            }

            if (!empty($parent_id)) {
                foreach($categories as $category) {
                    if ($category->alias == $alias && $category->parent_id == $parent_id) {
                        $model = $category;
                        $parent_id = $model->id;
                        break;
                    }
                }
            } else {
                foreach($categories as $category) {
                    if ($category->alias == $alias) {
                        $model = $category;
                        $parent_id = $model->id;
                        break;
                    }
                }
            }
        }

        return $model;
    }

    public function getWheres() {
        $innerIdsWhere = [];
        $innerIds = $this->getInnerIds();
        if (!empty($innerIds)) {
            $innerIdsWhere = [Product::tableName().'.parent_id' => $innerIds];
        }

        $otherIdsWhere = [];
        if ($this->type != 2) {
            $otherIds = ArrayHelper::getColumn(ProductHasCategory::findAll(['category_id' => $innerIds]), 'product_id');
        } else {
            $catsIds = ArrayHelper::getColumn(Category::find()
                ->where(['parent_id' => $this->id, 'type' => 3])
                ->orWhere(['id' => $this->id])
                ->all(), 'id');
            $otherIds = ArrayHelper::getColumn(ProductHasCategory::findAll(['category_id' => $catsIds]), 'product_id');
        }
        if (!empty($otherIds)) {
            $otherIdsWhere = [Product::tableName().'.id' => $otherIds];
        }

        return [$innerIdsWhere, $otherIdsWhere];
    }

    public function getProductHasCategories() {
        return $this->hasMany(ProductHasCategory::className(), ['category_id' => 'id']);
    }

    public function getProductCount() {
        return $this->getProducts()->count();
    }

    public function getFilterFeaturesS () {
        return $this->hasMany(FilterFeature::className(), ['category_id' => 'id'])
            ->with('filterFeatureValues')
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    public function getFilterFeatures () {
        return $this->hasMany(FilterFeature::className(), ['category_id' => 'id'])
            ->with('filterFeatureValues')
            ->orderBy(['sort_order' => SORT_ASC])
            ->asArray();
    }

    public function getSteps () {
        return $this->hasMany(Step::className(), ['category_id' => 'id'])->orderBy(['sort_order' => SORT_ASC]);
    }

    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
        Yii::$app->queue_default->push(new Sitemap());
    }

    public static function clearEmptyFeatures(&$filterFeatures, $allProductsQuery) {
        foreach($allProductsQuery->join as $index => $item) {
            if (strpos($item[1], 'product_has_filter_feature_value') !== false) {
                unset($allProductsQuery->join[$index]);
            }
        }

        foreach($allProductsQuery->where as $index => $item) {
            if (is_array($item)) {
                foreach($item as $index2 => $item2) {
                    if (strpos($index2, 'filter_feature_value_id') !== false) {
                        unset($allProductsQuery->where[$index]);
                    }
                }
            }
        }

        $products = $allProductsQuery->with(['productHasFilterFeatureValue'])->asArray()->all();

        foreach($filterFeatures as $filterFeatureIndex => $filterFeature) {
            foreach($filterFeature['filterFeatureValues'] as $filterFeatureValueIndex => $filterFeatureValue) {
                $found = false;

                foreach($products as $product) {
                    foreach($product['productHasFilterFeatureValue'] as $pfv) {
                        if ($pfv['filter_feature_value_id'] === $filterFeatureValue['id']) {
                            $found = true;
                            break 2;
                        }
                    }
                }

                if (!$found) {
                    unset($filterFeatures[$filterFeatureIndex]['filterFeatureValues'][$filterFeatureValueIndex]);
                }
            }
        }
    }

    public function getTags() {
        return $this->hasMany(Category::class, ['parent_id' => 'id'])
            ->with(['parent0', 'productHasCategories'])
            ->active()
            ->andWhere(['type' => 1])
            ->orderBy(['sort_order' => SORT_DESC]);
    }

    public function getYears() {
        return $this->hasMany(Category::class, ['parent_id' => 'id'])
            ->with(['parent0', 'productHasCategories'])
            ->active()
            ->andWhere(['type' => 4])
            ->orderBy(['sort_order' => SORT_DESC]);
    }

    public function getBrandCategories() {
        return $this->hasMany(Category::class, ['parent_id' => 'id'])
            ->with(['parent0', 'brand', 'productHasCategories'])
            ->active()
            ->andWhere(['type' => 2])
            ->orderBy(['name' => SORT_ASC]);
    }

    public function getBrandsSerial($brandCategories) {
        return $this->hasMany(Category::class, ['parent_id' => 'id'])
            ->with(['parent0', 'brand', 'productHasCategories'])
            ->active()
            ->andWhere([
                'parent_id' => ArrayHelper::getColumn($brandCategories, 'id'),
                'type' => 3
            ])
            ->orderBy(['name' => SORT_ASC]);
    }

    public function getParentCategory() {
        if (in_array($this->type, [1, 2, 4])) {
            return Category::findOne(['id' => $this->parent_id]);
        } else if ($this->type === 3) {
            $parentBrand = Category::findOne(['id' => $this->parent_id]);
            return Category::findOne(['id' => $parentBrand->parent_id]);
        } else {
            return $this;
        }
    }

    public function getCategoriesNestedToThisCategoryIds($forceCache = false) {
        $cache = Yii::$app->cache;
        $key = 'categoriesNestedToThisCategoryIds_'.$this->id;
        $categoriesNestedToThisCategoryIds = $cache->get($key);

        if (!is_array($categoriesNestedToThisCategoryIds) || $forceCache === true) {
            if (in_array($this->type, [1, 2, 4])) {
                $category = Category::findOne(['id' => $this->parent_id]);
            } else if ($this->type === 3) {
                $parentBrand = Category::findOne(['id' => $this->parent_id]);
                $category = Category::findOne(['id' => $parentBrand->parent_id]);
            } else {
                $category = $this;
            }

            $levelAndCats = $category->getLevel();
            $categories = [];

            if ($levelAndCats[0] === 1) {
                $categories[] = $category;
                $childrenCats = $category->getChildrenCategories();
                $categories = array_merge($categories, $childrenCats);

                foreach($childrenCats as $child) {
                    $categories = array_merge($categories, $child->getChildrenCategories());
                }
            } else if ($levelAndCats[0] === 2) {
                $categories[] = $category;
                $categories[] = $levelAndCats[1];
                $categories = array_merge($categories, $category->getChildrenCategories());
            } else if ($levelAndCats[0] === 3) {
                $categories[] = $category;
                $categories[] = $levelAndCats[1];
                $categories[] = $levelAndCats[2];
            }

            $categoriesNestedToThisCategoryIds = ArrayHelper::getColumn($categories, 'id');
            $cache->set($key, $categoriesNestedToThisCategoryIds);
        }

        return $categoriesNestedToThisCategoryIds;
    }

    public function getProducts() {
        $orderBy = array_merge([ProductParam::tableName().'.available' => SORT_DESC], Sort::getOrderBy($this, $_GET));
        $categoryIds = $this->getCategoriesNestedToThisCategoryIds();

        $productsQuery = Product::find()
            ->joinWith(['productParams' => function($q) {
                $q->andWhere([ProductParam::tableName().'.available' => 10]);
            }])
            ->with(['category',
                'category.features',
                'category.features.featurevalues',
                'params',
                'brand',
                'images',
                'features',
                'features.featurevalues'])
            ->andWhere(['parent_id' => $categoryIds])
            ->orderBy($orderBy);

        return $productsQuery;
    }

    public static function getFirstLevelCategories() {
        $cache = Yii::$app->cache;

        if (!$firstLevelCategories = $cache->get('firstLevelCategories')){
            $firstLevelCategories = Category::find()
                ->where(['parent_id' => 0, 'type' => 0, 'active' => 1])
                ->orderBy(['sort_order' => SORT_DESC])
                ->all();
            $cache->set('firstLevelCategories', $firstLevelCategories, 3600);
        }

        return $firstLevelCategories;
    }

    public static function getSecondLevelCategories($firstLevelCategory) {
        $cache = Yii::$app->cache;

        if (!$secondLevelCategories = $cache->get('secondLevelCategories'.$firstLevelCategory->id)){
            $secondLevelCategories = Category::find()
                ->where(['parent_id' => $firstLevelCategory->id, 'type' => 0, 'active' => 1])
                ->orderBy(['sort_order' => SORT_DESC])
                ->all();
            $cache->set('secondLevelCategories'.$firstLevelCategory->id, $secondLevelCategories, 3600);
        }

        return $secondLevelCategories;
    }

    public static function getThirdLevelCategories($secondLevelCategory) {
        $cache = Yii::$app->cache;

        if (!$thirdLevelCategories = $cache->get('thirdLevelCategories'.$secondLevelCategory->id)){
            $thirdLevelCategories = Category::find()
                ->where(['parent_id' => $secondLevelCategory->id, 'type' => 0, 'active' => 1])
                ->orderBy(['sort_order' => SORT_DESC])
                ->all();
            $cache->set('thirdLevelCategories'.$secondLevelCategory->id, $thirdLevelCategories, 3600);
        }

        return $thirdLevelCategories;
    }

    public function caching() {
        Yii::$app->queue_default->push(new CategoryCaching([
            'category_id' => $this->id
        ]));

        if ($this->parent_id !== 0) {
            $parent = Category::findOne($this->parent_id);
            $parent->caching();
        }
    }
}
