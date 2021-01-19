<?php

namespace common\models;

use backend\models\Sitemap;
use backend\models\UML;
use common\models\Feature;
use frontend\models\Filter;
use Yii;
use \common\models\base\Product as BaseProduct;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

/**
 * This is the model class for table "product".
 */
class Product extends BaseProduct implements CartPositionInterface
{
    use CartPositionTrait;

    public $categories_ids;
    public $paramsV;
    public $build_cost;
    public $waranty_cost;
    public $link;
    public $filterValues;
    public $present;
    public $present_artikul;
    public $delivery_date;
    public $artikul;
    public $brothers_ids = [];
    public $selects = [];
    public $selectsDirty = [];

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return md5(serialize([$this->id, $this->paramsV]));
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => \nsept\behaviors\CyrillicSlugBehavior::className(),
                    'attribute' => 'name',
                    'slugAttribute' => 'alias',
                    'immutable' => true,
                    'ensureUnique' => true,
                ],
            ]
        );
    }

    public function rules()
    {
        return [
            [['name', 'hit', 'parent_id', 'brand_id', 'supplier', 'price', 'currency_id', 'description', 'disallow_xml'], 'required'],
            [['hit', 'parent_id', 'brand_id', 'supplier', 'price', 'price_old', 'currency_id', 'adviser_id', 'sort_order', 'popular'], 'integer'],
            [['description', 'adviser_text', 'seo_description'], 'string'],
            [['main_param'], 'integer'],
            [['name', 'alias', 'code', 'video', 'disallow_xml', 'seo_h1', 'seo_title', 'seo_keywords', 'mmodel'], 'string', 'max' => 255],
            [['code', 'alias'], 'unique'],
            [['parent_id'], 'compare', 'compareValue' => 0, 'operator' => '!=', 'type' => 'number'],
            [['instruction'], 'file'],
            [['brothers_ids'], 'safe'],
            [['present_image'], 'image', 'maxSize' => 1000000,  'minWidth' => 39, 'minHeight' => 50, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Category::className(), 'targetAttribute' => ['parent_id' => 'id'], 'message' => 'Нельзя удалить категорию, в ней есть товары']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'alias' => 'Урл',
            'code' => 'Сгенерированный код товара',
            'hit' => 'Хит продаж?',
            'parent_id' => 'Выберите родительскую категорию',
            'brand_id' => 'Бренд',
            'supplier' => 'Поставщик',
            'price' => 'Цена',
            'price_old' => 'Старая цена',
            'currency_id' => 'Валюта',
            'description' => 'Описание товара',
            'adviser_id' => 'Советчик',
            'adviser_text' => 'Текст советчика',
            'instruction' => 'Инструкция к товару',
            'video' => 'id видео на youtube',
            'disallow_xml' => 'Запретить выгрузку в xml?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'seo_h1' => 'Seo H1',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'sort_order' => 'Sort Order',
            'popular' => 'Popular',
            'present_image' => 'Изображение, если этот товар подарок(39x50)',
            'mmodel' => 'Модель (поле для Яндекс)',
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getCategoryProducts() {
        return $this->hasMany(ProductHasCategory::className(), ['product_id' => 'id']);
    }

    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->via('categoryProducts');
    }

    public function getSupplierModel() {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier']);
    }

    public function getImages() {
        return $this->hasMany(Image::className(), ['product_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getReviews() {
        return ProductReview::find()
            ->where(['product_id' => $this->id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public function getActiveReviews() {
        return ProductReview::find()
            ->where(['product_id' => $this->id, 'active' => 1])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public function generateCode() {
        $code = $this->randCode();

        while (Product::findOne(['code' => $code])) {
            $code = $this->randCode();
        }

        $this->code = $code;
    }

    private function randCode() {
        $base = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $code = '';

        for ($i = 0; $i <= 5; $i++) {
            $randDigit = rand(0, 35);
            $code .= $base[$randDigit];
        }

        return $code;
    }

    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
        Sitemap::doIt();
        UML::doIt();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        $this->getMainFeatures(true);
        $this->getCompilationCategoryIds(true);
    }

    public function beforeDelete()
    {
        $modelsImage = Image::findAll(['product_id' => $this->id]);

        foreach ($modelsImage as $modelImage) {
            $firstPartOfFilename = basename(explode('.', $modelImage->image)[0]);

            $uploadPath = Yii::getAlias('@uploadPath');
            $uploadPaths = glob($uploadPath . '/*');

            foreach ($uploadPaths as $fileItem) {
                if (is_file($fileItem)) {
                    if (strstr($fileItem, $firstPartOfFilename)) {
                        unlink($fileItem);
                    }
                }
            }

            $thumbsPath = Yii::getAlias('@thumbsPath');
            $thumbsPaths = glob($thumbsPath . '/*');

            foreach ($thumbsPaths as $fileItem) {
                if (is_file($fileItem)) {
                    if (strstr($fileItem, $firstPartOfFilename)) {
                        unlink($fileItem);
                    }
                }
            }

            $modelImage->delete();
        }

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function getFeatures() {
        return $this->hasMany(Feature::className(), ['product_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getProductHasFilterFeatureValue() {
        return $this->hasMany(ProductHasFilterFeatureValue::className(), ['product_id' => 'id']);
    }

    public function getParams() {
        return ProductParam::find()
            ->where(['product_id' => $this->id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public function getParam() {
        return $this->hasMany(ProductParam::className(), ['product_id', 'id']);
    }

    public static function sortAvailable($products) {
        $availableItems = [];
        $unAvailableItems = [];

        foreach($products as $product) {
            $availableBoolean = false;

            foreach($product->productParams as $productParam) {
                if ($productParam->available > 0) {
                    $availableBoolean = true;
                }
            }

            if ($availableBoolean) {
                $availableItems[] = $product;
            } else {
                $unAvailableItems[] = $product;
            }
        }

        return array_merge($availableItems, $unAvailableItems);
    }

    public static function getBrandsByProducts($products) {
        $brands = [];

        foreach($products as $product) {
            $brand = Brand::findOne($product->brand_id);

            if (!array_key_exists ($brand->id, $brands)) {
                $brands[$brand->id] = $brand;
            }
        }

        return $brands;
    }

    public static function getBrandsCategoriesBrands($categoriesBrands) {
        $brands = [];

        foreach($categoriesBrands as $categoryBrand) {
            $brand = Brand::findOne($categoryBrand->brand_id);

            if (!array_key_exists ($brand->id, $brands)) {
                $brands[$brand->id] = $brand;
            }
        }

        return $brands;
    }
    
    public static function in_array_in($value, $array, $name) {
        $result = false;

        foreach($array[$name] as $item) {
            if ($item['value'] == $value) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    public function getSupplier() {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier']);
    }

    public function getVariant() {
        return $this->hasOne(ProductParam::className(), ['product_id' => 'id'])->orderBy(['product_param.id' => SORT_ASC]);
    }

    public function getAvailable() {
        $available = false;

        foreach($this->productParams as $variant) {
            if (!empty($variant->available)) {
                $available = true;
                break;
            }
        }

        return $available;
    }

    public function getBreadcrumbs() {
        $items = [];
        $parent0 = $this->parent;

        if (!$parent0) {
            $items[0] = $this->name;
            return $items;
        }

        if ($parent0->parent_id == 0) {
            $parent0Url = $parent0->url;
            $items[$parent0Url] = $parent0->name;
        } else {
            $parent1 = $parent0->parent1;
            $items = [];

            if ($parent1->parent_id == 0) {
                $parent1Url = $parent1->url;
                $parent0Url = $parent0->url;
                $items[$parent1Url] = $parent1->name;
                $items[$parent0Url] = $parent0->name;
            } else {
                $parent2 = $parent1->parent2;
                $items = [];

                if ($parent2->parent_id == 0) {
                    $parent2Url = $parent2->url;
                    $parent1Url = $parent1->url;
                    $parent0Url = $parent0->url;
                    $items[$parent2Url] = $parent2->name;
                    $items[$parent1Url] = $parent1->name;
                    $items[$parent0Url] = $parent0->name;
                } else {
                    $parent3 = $parent2->parent3;
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

    public function getUrl() {
        return '/'.$this->alias;
    }

    public function getPresents() {
        $products = [];

        $presents = Present::find()
            ->where(['<=', 'min_price', $this->price])
            ->andWhere(['>=', 'max_price', $this->price])
            ->all();

        foreach($presents as $present) {
            foreach(explode(',', $present->product_artikul) as $artikul) {
                $pp = ProductParam::findOne(['artikul' => $artikul]);
                $product = $pp->product;
                $product->paramsV = $pp->params;
                $product->artikul = $artikul;
                $products[] = $product;
            }
        }

        return $products;
    }

    public function getPresent($present_artikul) {
        if (empty($present_artikul)) {
            return false;
        } else {
            $pp = ProductParam::findOne(['artikul' => $present_artikul]);
            $product = $pp->product;
            $product->paramsV = $pp->params;
            $product->artikul = $present_artikul;

            return $product;
        }
    }

    public static function getNearDates() {
        $dates = [];

        for ($i = 1; $i <= 7; $i++) {
            $dates[] = date('d.m.Y', strtotime("+$i day"));
        }

        return $dates;
    }

    public function getProductParams() {
        return $this->hasMany(ProductParam::className(), ['product_id' => 'id'])
            ->orderBy([ProductParam::tableName().'.available' => SORT_DESC, ProductParam::tableName().'.id' => SORT_ASC]);
    }

    public function getParent() {
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

    public static function check404($countAllProducts, $defaultPageSize) {
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        $per_page = (isset($_GET['per_page'])) ? (int) $_GET['per_page'] : $defaultPageSize;

        if ($page <= 0) {
            throw new NotFoundHttpException;
        }

        if ($page >= 2 && $countAllProducts <= $defaultPageSize) {
            throw new NotFoundHttpException;
        }

        if ($countAllProducts != 0) {
            if (($per_page * $page) - $countAllProducts > $per_page) {
                throw new NotFoundHttpException;
            }
        }
    }




    public static function checkDisabled($disabled, $name, $value) {
        $return = false;

        foreach($disabled as $n => $values) {
            if ($n == $name) {
                foreach($values as $v) {
                    if (strstr($v, $value['value'])) {
                        $return = $v;
                    }
                }
            }
        }

        return $return;
    }

    public function selectsDirty() {
        if (empty($this->selectsDirty)) {
            $this->selectsDirty = [];
            $brothers = $this->getBrothersAll();

            foreach($brothers as $brother) {
                foreach($brother->params as $currentBrotherParam) {
                    foreach($currentBrotherParam->params as $p) {
                        list($name, $value) = explode(' -> ', $p);

                        $this->selectsDirty[$brother->id]['available'] = $currentBrotherParam->available > 0;
                        $this->selectsDirty[$brother->id]['items'][] = [
                            'name' => $name,
                            'value' => $value,
                        ];
                    }
                }
            }

            $mainParam = Param::findOne($this->main_param);

            foreach($this->selectsDirty as $brotherId => $selectDirty) {
                foreach($selectDirty['items'] as $item) {
                    if ($item['name'] !== $mainParam->name) {
                        $this->selectsDirty[$brotherId]['items'] = array_reverse($selectDirty['items']);
                    }
                }
            }
        }

        return $this->selectsDirty;
    }

    private function isSelectItemSelected(string $nameToChec, string $valueToCheck) {
        $selected = false;

        foreach($this->params[0]->params as $thisP) {
            list($name, $value) = explode(' -> ', $thisP);

            if ($nameToChec === $name && $valueToCheck === $value) {
                $selected = true;
                break;
            }
        }

        return $selected;
    }

    private function isSelectItemDisabled(Param $mainParam,
                                          $thisBrotherMainParamName,
                                          $thisBrotherMainParamValue,
                                          $paramName,
                                          $paramValue) {
        $disabledReason = '';
        $disabledText = '';
        $thisProductMainParamValue = null;

        foreach($this->params[0]->params as $param) {
            list($name, $value) = explode(' -> ', $param);

            if ($name === $mainParam->name) {
                $thisProductMainParamValue = $value;
                break;
            }
        }

        if ($paramName === null && $paramValue === null) {
            $available = false;

            foreach($this->selectsDirty() as $select2Dirty) {
                if ($select2Dirty['items'][0]['value'] === $thisBrotherMainParamValue) {
                    if ($select2Dirty['available'] === true) {
                        $available = true;
                    }
                }
            }

            $disabled = !$available;
            $disabledReason = $available === false ? 'availability' : '';
            $disabledText = $available === false ? 'Нет в наличии' : '';
        } else {
            $available = false;
            $found = false;
            $foundInDifferentMainParamValue = '';

            foreach($this->selectsDirty() as $select2Dirty) {
                if ($select2Dirty['items'][1]['value'] === $paramValue) {
                    if ($select2Dirty['items'][0]['value'] === $thisProductMainParamValue) {
                        $found = true;
                    } else {
                        $foundInDifferentMainParamValue = $select2Dirty['items'][0]['value'];
                    }

                    if ($select2Dirty['available'] === true) {
                        $available = true;
                    }
                }
            }

            $disabled = !($available && $found);

            if ($found === false && $available === true) {
                $disabledReason = 'not-found';
                $disabledText = 'Не найден ('.$foundInDifferentMainParamValue.')';
            } else if ($found === true && $available === false) {
                $disabledReason = 'availability';
                $disabledText = 'Нет в наличии';
            } else if ($found === false && $available === false) {
                $disabledReason = 'availability';
                $disabledText = 'Нет в наличии';
            }

        }



        return [$disabled, $disabledReason, $disabledText];
    }

    public function selects() {
        if (empty($this->selects)) {
            $this->selects = [];

            if (empty($this->params[0]->params)) {
                return [];
            }

            if (count($this->params[0]->params) === 1) {
                list($name, $value) = explode(' -> ', $this->params[0]->params[0]);
                $mainParam = Param::findOne(['name' => $name]);
            } else {
                $mainParam = Param::findOne($this->main_param);
            }
            $thisBrotherMainParamName = null;
            $thisBrotherMainParamValue = null;

            foreach($this->getBrothersAll() as $brother) {
                foreach($brother->params as $currentBrotherParam) {
                    foreach($currentBrotherParam->params as $p) {
                        list($name, $value) = explode(' -> ', $p);
                        $paramModel = Param::findOne(['name' => $name]);
                        $paramName = $paramValue = null;

                        if ($mainParam->name === $name) {
                            $thisBrotherMainParamName = $name;
                            $thisBrotherMainParamValue = $value;
                        } else {
                            $paramName = $name;
                            $paramValue = $value;
                        }
                        ////////////////////////////////////////////////////////////////////////////////////////////
                        if (!isset($this->selects[$paramModel->id]['items'])) {
                            $this->selects[$paramModel->id]['items'] = [];
                        }
                        ////////////////////////////////////////////////////////////////////////////////////////////
                        $alreadyIsset = false;

                        foreach($this->selects[$paramModel->id]['items'] as $item) {
                            if ($item['value'] === $value) {
                                $alreadyIsset = true;
                                break;
                            }
                        }
                        ////////////////////////////////////////////////////////////////////////////////////////////
                        if ($alreadyIsset === false) {
                            $selected = $this->isSelectItemSelected($name, $value);
                            list($disabled, $disabledReason, $disabledText) = $this->isSelectItemDisabled($mainParam,
                                $thisBrotherMainParamName, $thisBrotherMainParamValue, $paramName, $paramValue);
                            ////////////////////////////////////////////////////////////////////////////////////////////

                            $this->selects[$paramModel->id]['name'] = $name;
                            $this->selects[$paramModel->id]['name_en'] = $paramModel->name_en;
                            $this->selects[$paramModel->id]['items'][] = [
                                'value' => $value,
                                'selected' => $selected,
                                'disabled' => $disabled,
                                'disabledReason' => $disabledReason,
                                'disabledText' => $disabledText,
                            ];
                        }
                    }
                }
            }

            if (array_key_first($this->selects) !== $this->main_param) {
                $this->selects = array_reverse($this->selects, true);
            }
        }

        return $this->selects;
    }

    public function saveBrothers() {
        if (is_string($this->brothers_ids)) {
            $this->brothers_ids = [];
        } else {
            $this->brothers_ids[] = $this->id;
        }

        $currentIds = ArrayHelper::getColumn($this->getBrothers(), 'product_id');
        $currentBrothersIds = array_merge($currentIds, ArrayHelper::getColumn($this->getBrothers(), 'product_brother_id'));
        $currentBrothersIds = array_unique($currentBrothersIds);

        if (!empty($currentBrothersIds)) {
            Yii::$app
                ->db
                ->createCommand('delete from product_product 
                where product_id IN ('.implode(",", $currentBrothersIds).') OR product_brother_id IN ('.implode(",", $currentBrothersIds).')')
                ->execute();
        }

        foreach($this->brothers_ids as $product_id) {
            foreach($this->brothers_ids as $brother_id) {
                Yii::$app
                    ->db
                    ->createCommand()
                    ->upsert('product_product',
                        [
                            'product_id' => $product_id,
                            'product_brother_id' => $brother_id
                        ])->execute();
            }
        }
    }

    public function getBrothersAll() {
        return Product::find()->where(['id' => $this->getBrothersIds()])->all();
    }

    public function getBrothers() {
        $brothers = (new Query)
            ->select('*')
            ->from('product_product')
            ->where(['product_id' => $this->id])
            ->all();

        return $brothers;
    }

    public function getBrothersIds() {
        return ArrayHelper::getColumn($this->getBrothers(), 'product_brother_id');
    }

    public function setBrothersIds() {
        $this->brothers_ids = $this->getBrothersIds();
    }

    public function getMainFeatures($forceToCache = false) {
        //return [];
        $cache = Yii::$app->cache;
        $key = 'main_features_product_'.$this->id;
        $mainFeaturesValues = $cache->get($key);

        if ($forceToCache === true || empty($mainFeaturesValues)) {
            $mainFeatures = [];
            $mainFeaturesValues = [];

            foreach($this->category->features as $feature) {
                foreach($feature->featurevalues as $featureValue) {
                    if ($featureValue->main_param == 1) {
                        $mainFeatures[$featureValue->name] = $featureValue->toArray();
                    }
                }
            }

            foreach($this->features as $feature) {
                foreach($feature->featurevalues as $featureValue) {
                    if (array_key_exists($featureValue->name, $mainFeatures)) {
                        $mainFeaturesValues[$featureValue->name] = $featureValue->value;
                    }
                }
            }

            $cache->set($key, $mainFeaturesValues, 31104000);
        }

        return $mainFeaturesValues;
    }


    public function getCompilationCategoryIds($forceToCache = false) {
        $cache = Yii::$app->cache;
        $key = 'compilation_category_ids_'.$this->id;
        $ids = $cache->get($key);

        if ($forceToCache === true || empty($ids)) {
            $ids = [];

            $categoriesFound = Category::find()
                ->where(['LIKE', 'filter_url', $this->category->alias])
                ->andWhere(['!=', 'type', 0])
                ->all();

            foreach($categoriesFound as $category) {
                $filter_url_query = parse_url($category->filter_url, PHP_URL_QUERY);
                $filter_url_query = urldecode($filter_url_query);
                parse_str($filter_url_query, $get);

                $productQuery = Product::find()
                    ->distinct()
                    ->select([Product::tableName().'.id'])
                    ->joinWith(['productParams' => function($q) {
                        $q->andWhere([ProductParam::tableName().'.available' => 10]);
                    }]);
                $productQuery = Filter::filter($productQuery, $get);
                $productIdsBelongsToThisCategory = ArrayHelper::getColumn($productQuery->asArray()->all(), 'id');

                if (in_array($this->id, $productIdsBelongsToThisCategory)) {
                    $ids[] = $category->id;
                }
            }

            $cache->set($key, $ids, 31104000);
        }

        return $ids;
    }

    public function getCompilationCategories() {
        return Category::find()->where(['id' => $this->getCompilationCategoryIds()])->all();
    }
}
