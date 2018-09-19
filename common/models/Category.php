<?php

namespace common\models;

use Yii;
use \common\models\base\Category as BaseCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 */
class Category extends BaseCategory
{

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
            [['text_advice', 'descr', 'seo_description'], 'string'],
            [['name', 'alias', 'image_catalog', 'image_menu', 'video', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
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
        return Feature::find()
            ->where(['category_id' => $this->id])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
    }

    public function getInnerIds() {
        $ids = [];
        $innerCategories = $this->getInnerCategories();

        foreach($innerCategories as $ccc) {
            $ids[] = $ccc->id;
        }

        return $ids;
    }

    public function getInnerCategories() {
        $categories = [];
        $level = $this->getLevel();

        if ($level) {
            if ($level == 3) {
                $categories[] = $this;
            } else if ($level == 2) {
                $categories[] = $this;
                $cats = Category::findAll(['parent_id' => $this->id]);

                foreach($cats as $cat) {
                    $categories[] = $cat;
                }
            } else if ($level == 1) {
                $categories[] = $this;
                $cats = Category::findAll(['parent_id' => $this->id]);

                foreach($cats as $cat) {
                    $categories[] = $cat;

                    foreach(Category::findAll(['parent_id' => $cat->id]) as $item) {
                        $categories[] = $item;
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
            return false;//Не Категория
        }


        if ($this->parent_id == 0) {
            return 1;
        } else {
            $cat = Category::find()->where(['id' => $this->parent_id, 'type' => 0])->one();

            if ($cat->parent_id == 0) {
                return 2;
            } else {
                $cat = Category::find()->where(['id' => $cat->parent_id, 'type' => 0])->one();

                if ($cat->parent_id == 0) {
                    return 3;
                }
            }

            return false;
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
            $parent0Url = Url::to(['catalog/index', 'alias' => $parent0->alias]);
            $items[$parent0Url] = $parent0->name;
        } else {
            $parent1 = Category::findOne(['id' => $parent0->parent_id]);
            $items = [];

            if ($parent1->parent_id == 0) {
                $parent1Url = Url::to(['catalog/index', 'alias' => $parent1->alias]);
                $parent0Url = Url::to(['catalog/index', 'alias' => $parent1->alias, 'alias2' => $parent0->alias]);
                $items[$parent1Url] = $parent1->name;
                $items[$parent0Url] = $parent0->name;
            } else {
                $parent2 = Category::findOne(['id' => $parent1->parent_id]);
                $items = [];

                if ($parent2->parent_id == 0) {
                    $parent2Url = Url::to(['catalog/index', 'alias' => $parent2->alias]);
                    $parent1Url = Url::to(['catalog/index', 'alias' => $parent2->alias, 'alias2' => $parent1->alias]);
                    $parent0Url = Url::to(['catalog/index', 'alias' => $parent2->alias, 'alias2' => $parent1->alias, 'alias3' => $parent0->alias]);
                    $items[$parent2Url] = $parent2->name;
                    $items[$parent1Url] = $parent1->name;
                    $items[$parent0Url] = $parent0->name;
                } else {
                    $parent3 = Category::findOne(['id' => $parent2->parent_id]);
                    $items = [];

                    if ($parent3->parent_id == 0) {
                        $parent3Url = Url::to(['catalog/index', 'alias' => $parent3->alias]);
                        $parent2Url = Url::to(['catalog/index', 'alias' => $parent3->alias, 'alias2' => $parent2->alias]);
                        $parent1Url = Url::to([
                            'catalog/index',
                            'alias' => $parent3->alias,
                            'alias2' => $parent2->alias,
                            'alias3' => $parent1->alias
                        ]);
                        $parent0Url = Url::to([
                            'catalog/index',
                            'alias' => $parent3->alias,
                            'alias2' => $parent2->alias,
                            'alias3' => $parent1->alias,
                            'alias4' => $parent0->alias,
                        ]);
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
        $categories = Category::find()->where(['parent_id' => $this->id, 'type' => 0])->all();

        if (!empty($categories)) {
            return $categories;
        } else {
            return false;
        }
    }

    public function getUrl() {
        if ($this->type == 1) {
            $parent0 = Category::findOne(['id' => $this->parent_id]);

            if ($parent0->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent0->alias,
                    'alias2' => 'tag',
                    'alias3' => $this->alias,
                ]);
            }
            ////////////////////////////////////////////////////////////
            $parent1 = Category::findOne(['id' => $parent0->parent_id]);

            if ($parent1->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent1->alias,
                    'alias2' => $parent0->alias,
                    'alias3' => 'tag',
                    'alias4' => $this->alias,
                ]);
            }
            ////////////////////////////////////////////////////////////
            $parent2 = Category::findOne(['id' => $parent1->parent_id]);

            if ($parent2->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent2->alias,
                    'alias2' => $parent1->alias,
                    'alias3' => $parent0->alias,
                    'alias4' => 'tag',
                    'alias5' => $this->alias,
                ]);
            }
        } else {
            $parent0 = Category::findOne(['id' => $this->parent_id]);

            if ($parent0->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent0->alias,
                    'alias2' => $this->alias,
                ]);
            }
            ////////////////////////////////////////////////////////////
            $parent1 = Category::findOne(['id' => $parent0->parent_id]);

            if ($parent1->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent1->alias,
                    'alias2' => $parent0->alias,
                    'alias3' => $this->alias,
                ]);
            }
            ////////////////////////////////////////////////////////////
            $parent2 = Category::findOne(['id' => $parent1->parent_id]);

            if ($parent2->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent2->alias,
                    'alias2' => $parent1->alias,
                    'alias3' => $parent0->alias,
                    'alias4' => $this->alias,
                ]);
            }
            ////////////////////////////////////////////////////////////
            $parent3 = Category::findOne(['id' => $parent2->parent_id]);

            if ($parent3->parent_id == 0) {
                return Url::to([
                    'catalog/index',
                    'alias' => $parent3->alias,
                    'alias2' => $parent2->alias,
                    'alias3' => $parent1->alias,
                    'alias4' => $parent0->alias,
                    'alias5' => $this->alias,
                ]);
            }
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

            if ($parent_id != 0) {
                $model = Category::findOne(['alias' => $alias, 'parent_id' => $parent_id, 'active' => 1]);
            } else {
                $model = Category::findOne(['alias' => $alias, 'active' => 1]);
            }
        }

        return $model;
    }

    public function getProductCount() {
        $innerIdsWhere = [];
        $innerIds = $this->getInnerIds();

        if (!empty($innerIds)) {
            $innerIdsWhere = ['parent_id' => $innerIds];
        }
        /////////////////////////////////////////////////////////
        $otherIds = [];
        $otherIdsWhere = [];

        if ($this->type != 2) {
            foreach ($innerIds as $category_id) {
                foreach (ProductHasCategory::findAll(['category_id' => $category_id]) as $productHasCategory) {
                    $otherIds[] = $productHasCategory->product_id;
                }
            }
        } else {
            foreach (Category::find()
                ->where(['parent_id' => $this->id, 'type' => 3])
                ->orWhere(['id' => $this->id])
                ->all() as $category) {
                foreach (ProductHasCategory::findAll(['category_id' => $category->id]) as $productHasCategory) {
                    $otherIds[] = $productHasCategory->product_id;
                }
            }
        }

        if (!empty($otherIds)) {
            $otherIdsWhere = ['id' => $otherIds];
        }

        if ($this->type == 0) {//Если категория
            $products = Product::find()
                ->orWhere($otherIdsWhere)
                ->orWhere($innerIdsWhere);
        } else {
            $idsTags = [];
            $andWhereTags = ['id' => ''];

            foreach (ProductHasCategory::findAll(['category_id' => $this->id]) as $productHasCategory) {
                $idsTags[] = $productHasCategory->product_id;
            }

            if (!empty($idsTags)) {
                $andWhereTags = ['id' => $idsTags];
            }
            $products = Product::find()
                ->where($andWhereTags)
                ->orWhere($otherIdsWhere);
        }

        return $products->count();
    }
}
