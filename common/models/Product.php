<?php

namespace common\models;

use backend\models\Sitemap;
use backend\models\UML;
use common\models\Feature;
use Yii;
use \common\models\base\Product as BaseProduct;
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
            $parent0Url = Url::to(['catalog/index', 'alias' => $parent0->alias]);
            $items[$parent0Url] = $parent0->name;
        } else {
            $parent1 = $parent0->parent1;
            $items = [];

            if ($parent1->parent_id == 0) {
                $parent1Url = Url::to(['catalog/index', 'alias' => $parent1->alias]);
                $parent0Url = Url::to(['catalog/index', 'alias' => $parent1->alias, 'alias2' => $parent0->alias]);
                $items[$parent1Url] = $parent1->name;
                $items[$parent0Url] = $parent0->name;
            } else {
                $parent2 = $parent1->parent2;
                $items = [];

                if ($parent2->parent_id == 0) {
                    $parent2Url = Url::to(['catalog/index', 'alias' => $parent2->alias]);
                    $parent1Url = Url::to(['catalog/index', 'alias' => $parent2->alias, 'alias2' => $parent1->alias]);
                    $parent0Url = Url::to(['catalog/index', 'alias' => $parent2->alias, 'alias2' => $parent1->alias, 'alias3' => $parent0->alias]);
                    $items[$parent2Url] = $parent2->name;
                    $items[$parent1Url] = $parent1->name;
                    $items[$parent0Url] = $parent0->name;
                } else {
                    $parent3 = $parent2->parent3;
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

    public function getSelectsAndDisabled($currentVariant) {
        $selects = [];
        $i = 0;
        $currentParams = [];
        $currentParamName = ($curP = Param::findOne($this->main_param))? $curP->name : '';
        $currentParamValue = '';
        $currentParamParams = [];
        $disabled = [];

        if ($currentVariant->params) {
            foreach($currentVariant->params as $p) {
                $name = explode(' -> ', $p)[0];
                $value = explode(' -> ', $p)[1];
                $currentParams[$name] = $value;

                if ($name == $currentParamName) {
                    $currentParamValue = $value;
                }
            }
        }

        foreach($this->productParams as $index => $v) {
            if ($v->params) {

                foreach($v->params as $param) {
                    $name = explode(' -> ', $param)[0];
                    $value = explode(' -> ', $param)[1];

                    if ($name == $currentParamName && $value == $currentParamValue) {
                        foreach ($v->params as $paramInner) {
                            $nameInner = explode(' -> ', $paramInner)[0];
                            $valueInner = explode(' -> ', $paramInner)[1];
                            $currentParamParams[$nameInner][] = $valueInner;
                        }
                    }
                }
            }
        }

        foreach($this->productParams as $index => $v) {
            if ($v->params) {

                foreach($v->params as $param) {
                    $name = explode(' -> ', $param)[0];
                    $value = explode(' -> ', $param)[1];

                    if (!isset($selects[$name]) || !Product::in_array_in($value, $selects, $name)) {
                        $selects[$name][$i]['value'] = $value;

                        if (isset($currentParams[$name]) && $currentParams[$name] == $value) {
                            $selects[$name][$i]['active'] = true;
                        } else {
                            $selects[$name][$i]['active'] = false;
                        }

                        $i++;
                    }

                    if ($name == $currentParamName && $value != $currentParamValue) {
                        foreach ($v->params as $paramInner) {
                            $nameInner = explode(' -> ', $paramInner)[0];
                            $valueInner = explode(' -> ', $paramInner)[1];

                            if (array_key_exists($nameInner, $currentParamParams) && $nameInner != $currentParamName) {
                                if (!in_array($valueInner, $currentParamParams[$nameInner])) {
                                    $disabled[$nameInner][] = $valueInner.' ('.$name.' - '.$value.')';
                                }
                            }
                        }
                    }
                }
            }
        }

        return [$selects, $disabled];
    }
}
