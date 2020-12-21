<?php
namespace frontend\controllers;

use common\models\Adviser;
use common\models\Brand;
use common\models\Category;
use common\models\Feature;
use common\models\FeatureValue;
use common\models\Mainpage;
use common\models\Mainslider;
use common\models\News;
use common\models\Param;
use common\models\Product;
use common\models\ProductParam;
use common\models\Subscribe;
use common\models\Survey;
use common\models\SurveyForm;
use common\models\Textpage;
use frontend\models\City;
use frontend\models\Compare;
use frontend\models\Favourite;
use frontend\models\Filter;
use frontend\models\StepOptionChoose;
use frontend\models\SubscribeForm;
use frontend\models\Webp;
use Yii;
use yii\base\InvalidParamException;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($alias = '', $alias2 = '', $step = 0)
    {
        City::setCity();
        $cache = Yii::$app->cache;

        $catalog = $this->catalog($alias, $alias2);

        if (!empty($catalog)) {
            return $catalog;
        }

        $product = $this->product($alias);

        if (!empty($product)) {
            return $product;
        }


        if (!empty($step)) {
            $parent = Textpage::findOne(['alias' => $alias]);
            $survey = Survey::findOne(['alias' => $alias2]);

            if ($parent && $survey) {
                $stepCount = count($survey->steps);

                if ($stepCount + 2 < $step) {
                    throw new NotFoundHttpException;
                }

                $isEmailStep = false;
                $isPhoneStep = false;
                $surveyCookieName = 'survey'.$survey->id;
                $surveyFormCookieName = 'survey'.$survey->id.'_form_id';

                if ($stepCount + 2 == $step) {
                    $isPhoneStep = true;
                }

                if ($stepCount + 1 == $step) {
                    $isEmailStep = true;
                }

                if ($step == 'success') {
                    if (isset($_COOKIE[$surveyCookieName]) && isset($_COOKIE[$surveyFormCookieName])) {
                        setcookie($surveyCookieName,"",time()-3600);
                        setcookie($surveyFormCookieName,"",time()-3600);

                        return $this->render('@frontend/views/survey/success', [
                            'model' => $survey,
                        ]);
                    } else {
                        return $this->redirect(Url::to([
                            'site/index',
                            'alias' => $parent->alias,
                            'alias2' => $survey->alias,
                            'step' => $stepCount + 2,
                        ]));
                    }
                }

                if ($lastStep = $survey->getLastStep($step, $isEmailStep, $isPhoneStep, $stepCount, $surveyCookieName, $surveyFormCookieName)) {
                    if ($lastStep != $step && $step > $lastStep) {
                        return $this->redirect(Url::to([
                            'site/index',
                            'alias' => $parent->alias,
                            'alias2' => $survey->alias,
                            'step' => $lastStep,
                        ]));
                    }
                }

                $surveyForm = false;

                if (isset($_COOKIE[$surveyFormCookieName])) {
                    $surveyForm = SurveyForm::findOne($_COOKIE[$surveyFormCookieName]);
                }

                $stepOptionsChoose = new StepOptionChoose;

                if ($stepOptionsChoose->load($_POST) && $stepOptionsChoose->validate()) {
                    if ($isPhoneStep) {
                        if (isset($_COOKIE[$surveyCookieName]) && isset($_COOKIE[$surveyFormCookieName])) {
                            if ($surveyForm) {
                                $surveyForm->phone = $stepOptionsChoose->phone;

                                if ($surveyForm->save() && !empty($surveyForm->phone)) {
                                    Yii::$app
                                        ->mailer
                                        ->compose()
                                        ->setFrom(Yii::$app->params['adminEmail'])
                                        ->setTo(Yii::$app->params['adminEmail'])
                                        ->setSubject('Опрос дополнен телефоном KSG')
                                        ->setHtmlBody('<a href="https://www.ksg.ru/officeback/survey-form/update?id="'.$survey->id.'>Ссылка в админке</a>')
                                        ->send();

                                    return $this->redirect(Url::to([
                                        'site/index',
                                        'alias' => $parent->alias,
                                        'alias2' => $survey->alias,
                                        'step' => 'success',
                                    ]));
                                }
                            }
                        } else {
                            return $this->redirect(Url::to([
                                'site/index',
                                'alias' => $parent->alias,
                                'alias2' => $survey->alias,
                                'step' => $step - 1,
                            ]));
                        }
                    } else if ($isEmailStep) {
                        if (isset($_COOKIE[$surveyCookieName])) {
                            $surveyForm = new SurveyForm;
                            $surveyForm->email = $stepOptionsChoose->email;
                            $surveyForm->survey_id = $survey->id;
                            $surveyForm->options = $_COOKIE[$surveyCookieName];

                            if ($surveyForm->save()) {
                                setcookie($surveyFormCookieName, $surveyForm->id, time()+3600*24*30);

                                Yii::$app
                                    ->mailer
                                    ->compose()
                                    ->setFrom(Yii::$app->params['adminEmail'])
                                    ->setTo(Yii::$app->params['adminEmail'])
                                    ->setSubject('Новый опрос на KSG')
                                    ->setHtmlBody('<a href="https://www.ksg.ru/officeback/survey-form/update?id="'.$survey->id.'>Ссылка в админке</a>')
                                    ->send();

                                return $this->redirect(Url::to([
                                    'site/index',
                                    'alias' => $parent->alias,
                                    'alias2' => $survey->alias,
                                    'step' => $step + 1,
                                ]));
                            }
                        }
                    } else {
                        $survey->setCookie($stepOptionsChoose, $step, $surveyCookieName, $surveyFormCookieName);

                        return $this->redirect(Url::to([
                            'site/index',
                            'alias' => $parent->alias,
                            'alias2' => $survey->alias,
                            'step' => $step + 1,
                        ]));
                    }
                }

                
                $this->layout = 'cart';

                return $this->render('@frontend/views/survey/step', [
                    'model' => $survey,
                    'stepOptionsChoose' => $stepOptionsChoose,
                    'step' => $step,
                    'stepCount' => $stepCount,
                    'isEmailStep' => $isEmailStep,
                    'isPhoneStep' => $isPhoneStep,
                    'surveyCookieName' => $surveyCookieName,
                    'surveyFormCookieName' => $surveyFormCookieName,
                    'surveyForm' => $surveyForm
                ]);
            }
        }

        if (!empty($alias2)) {
            $textpage = Textpage::findOne(['alias' => $alias2]);
            $newsItem = News::findOne(['alias' => $alias2]);
            $survey = Survey::findOne(['alias' => $alias2]);

            if ($textpage || $newsItem || $survey) {
                if ($survey) {
                    $this->layout = 'cart';
                    $parent = Textpage::findOne(['alias' => $alias]);

                    if (!$parent || $parent->id != 21) {
                        throw new NotFoundHttpException;
                    }

                    return $this->render('@frontend/views/survey/view', [
                        'parent' => $parent,
                        'model' => $survey,
                    ]);
                }
                if ($textpage) {
                        if ($textpage->type == 1) {
                            $parent = Textpage::findOne(8);
                        } else if ($textpage->type == 2) {
                            $parent = Textpage::findOne(9);
                        } else {
                            throw new NotFoundHttpException;
                        }

                    $textpages = Textpage::find()
                        ->where(['type' => $textpage->type])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();

                    return $this->render('@frontend/views/textpage/index', [
                        'model' => $textpage,
                        'textpages' => $textpages,
                        'parent' => $parent,
                    ]);
                }

                if ($newsItem) {
                    return $this->render('@frontend/views/news/view', [
                        'model' => $newsItem,
                        'parent' => Textpage::findOne(13),
                    ]);
                }
            } else {
                throw new NotFoundHttpException;
            }
        }

        if (!empty($alias)) {
            $textpage = Textpage::findOne(['alias' => $alias]);

            if (!$textpage) {
                throw new NotFoundHttpException;
            }

            switch($textpage->id) {
                case 1: {
                    break;
                }
                case 2: {
                    $this->layout = 'textpage';
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

                    return $this->render('@frontend/views/textpage/brands', [
                        'model' => $textpage,
                        'result' => $result,
                    ]);
                }
                case 8: {
                    $textpages = Textpage::find()
                        ->where(['type' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();

                    return $this->render('@frontend/views/textpage/index', [
                        'model' => $textpage,
                        'textpages' => $textpages,
                    ]);
                }
                case 9: {
                    $textpages = Textpage::find()
                        ->where(['type' => 2])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();

                    return $this->render('@frontend/views/textpage/index', [
                        'model' => $textpage,
                        'textpages' => $textpages,
                    ]);
                }
                case 13: {
                    $news = News::find()->orderBy(['created_at' => SORT_DESC])->all();

                    return $this->render('@frontend/views/news/index', [
                        'model' => $textpage,
                        'news' => $news,
                    ]);
                }
                case 11: {
                    $orderBy = [];

                    if (isset($_GET['sort'])) {
                        $sort = explode('_', $_GET['sort']);

                        if ($sort[0] == 'price') {
                            if ($sort[1] == 'desc') {
                                $orderBy = [$sort[0] => SORT_DESC];
                            } else if ($sort[1] == 'asc') {
                                $orderBy = [$sort[0] => SORT_ASC];
                            }
                        }
                    } else {
                        $orderBy = ['price' => SORT_ASC];
                    }

                    if (!empty(Favourite::getIds())) {
                        $allproducts = Product::find()->where(['id' => Favourite::getIds()])->orderBy($orderBy)->all();
                    } else {
                        $allproducts = [];
                    }

                    $defaultPageSize = 40;
                    $countAllProducts = count($allproducts);
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

                    $pages = new \yii\data\Pagination([
                        'totalCount' => $countAllProducts,
                        'defaultPageSize' => $defaultPageSize,
                        'pageSizeParam' => 'per_page',
                        'forcePageParam' => false,
                        'pageSizeLimit' => 200
                    ]);

                    $allproducts = Product::sortAvailable($allproducts);
                    $products = [];

                    for ($i = 0; $i < count($allproducts); $i++) {
                        if (count($products) >= $pages->limit) {
                            break;
                        }

                        if ($i >= $pages->offset) {
                            $products[] = $allproducts[$i];
                        }
                    }

                    return $this->render('@frontend/views/favourite/index', [
                        'model' => $textpage,
                        'products' => $products,
                        'pages' => $pages,
                    ]);
                }
                case 12: {
                    $features = [];
                    $products = Product::find()
                        ->where(['id' => Compare::getIds()])
                        ->orderBy(['name' => SORT_DESC])
                        ->all();

                    foreach($products as $product) {
                        $fs = Feature::findAll(['product_id' => $product->id]);

                        foreach($fs as $fsItem) {
                            if (!array_key_exists($fsItem->header, $features)) {
                                $features[$fsItem->header] = [];
                            }
                        }
                    }

                    ksort($features);

                    foreach($features as $featureHeader => $notUse) {
                        $fs = Feature::findOne(['header' => $featureHeader, 'product_id' => $product->id]);

                        foreach(FeatureValue::findAll(['feature_id' => $fs->id]) as $fv) {
                            $features[$featureHeader][$fv->name] = [];
                        }

                        ksort($features[$featureHeader]);
                    }

                    foreach($features as $featureHeader => $featuresName) {
                        foreach($featuresName as $featureName => $notUse) {
                            foreach($products as $product) {
                                $fs = Feature::findOne(['header' => $featureHeader, 'product_id' => $product->id]);

                                if ($fs) {
                                    $fv = FeatureValue::findOne(['name' => $featureName, 'feature_id' => $fs->id]);

                                    if ($fv) {
                                        $features[$featureHeader][$featureName][] = $fv->value;
                                    } else {
                                        $features[$featureHeader][$featureName][] = '&mdash;';
                                    }
                                } else {
                                    $features[$featureHeader][$featureName][] = '&mdash;';
                                }
                            }
                        }
                    }

                    return $this->render('@frontend/views/compare/index', [
                        'model' => $textpage,
                        'features' => $features,
                        'products' => $products,
                    ]);
                }
                case 14: {
                    $this->layout = 'textpage';

                    return $this->render('@frontend/views/textpage/contacts', [
                        'model' => $textpage
                    ]);
                }
                case 15: {
                    if (isset($_GET['query']) && !empty($_GET['query'])) {
                        if ($page = Textpage::findOne(['name' => $_GET['query']])) {
                            return $this->redirect($page->url);
                        }

                        if ($product = Product::findOne(['name' => $_GET['query']])) {
                            return $this->redirect($product->url);
                        }

                        if ($pp = ProductParam::findOne(['artikul' => $_GET['query']])) {
                            return $this->redirect($pp->product->url);
                        }

                        $productsQuery = Product::find()
                            ->where(['like', 'name', $_GET['query']])
                            ->orderBy(['name' => SORT_ASC]);
                        $categoriesQuery = Category::find()
                            ->where(['like', 'name', $_GET['query']])
                            ->andWhere(['active' => 1])
                            ->orderBy(['name' => SORT_ASC]);
                        $productsCount = $productsQuery->count();
                        $categoriesCount = $categoriesQuery->count();

                        if ($productsCount == 0 && $categoriesCount == 0) {
                            return $this->render('@frontend/views/textpage/search', [
                                'model' => $textpage,
                                'query' => $_GET['query'],
                                'empty' => true
                            ]);
                        }

                        $pages = new \yii\data\Pagination([
                            'totalCount' => $productsCount,
                            'defaultPageSize' => 39,
                            'pageSizeParam' => 'per_page',
                            'forcePageParam' => false,
                            'pageSizeLimit' => 200
                        ]);

                        $products = $productsQuery->limit($pages->limit)->offset($pages->offset)->all();
                        $categories = $categoriesQuery->all();

                        return $this->render('@frontend/views/textpage/search', [
                            'model' => $textpage,
                            'products' => $products,
                            'productsCount' => $productsCount,
                            'categories' => $categories,
                            'query' => $_GET['query'],
                            'pages' => $pages,
                            'empty' => false
                        ]);
                    }

                    return $this->render('@frontend/views/textpage/search', [
                        'model' => $textpage,
                        'query' => $_GET['query'],
                        'empty' => true
                    ]);
                }
                case 21: {
                    $this->layout = 'textpage';

                    return $this->render('@frontend/views/survey/index', [
                        'model' => $textpage
                    ]);
                }
                default: {
                    throw new NotFoundHttpException;
                }
            }
        }

        $model = Mainpage::findOne(1);

        if (!$mainSliders = $cache->get('mainSliders')){
            $mainSliders = Mainslider::find()->orderBy(['sort_order' => SORT_DESC])->all();
            $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM mainslider ORDER BY updated_at DESC']);
            $cache->set('mainSliders', $mainSliders, null, $dependency);
        }
        if (!$hitProducts = $cache->get('hitProducts')){
            $hitProducts = Product::find()
                ->with(['productParams', 'brand', 'images'])
                ->where(['hit' => 1])
                ->limit(8)
                ->orderBy(['updated_at' => SORT_DESC])
                ->all();
            $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM product ORDER BY updated_at DESC']);
            $cache->set('hitProducts', $hitProducts, null, $dependency);
        }
        return Webp::replaceToWebp($this->render('index', [
            'model' => $model,
            'mainSliders' => $mainSliders,
            'hitProducts' => $hitProducts,
        ]));
    }

    private function product($alias) {
        $model = Product::find()
            ->with([
                'productParams',
                'brand',
                'images',
                'parent',
                'features',
                'features.featurevalues'])
            ->where(['alias' => $alias])
            ->one();

        if (!$model) {
            return '';
        }

        if (isset($_POST['reload']) && $_POST['reload'] == 1) {
            $currentParamName = ($curP = Param::findOne($model->main_param))? $curP->name : '';

            $currentVariant = ProductParam::find()
                ->where(['product_id' => $model->id])
                ->andWhere(['params' => $_POST['paramsv']])
                ->one();

            if (!$currentVariant) {
                $val = '';

                foreach(explode('|', $_POST['paramsv']) as $r) {
                    $p = explode(' -> ', $r);

                    if ($p[0] == $currentParamName) {
                        $val = $r;
                    }
                }

                $currentVariant = ProductParam::find()
                    ->where(['product_id' => $model->id])
                    ->andWhere(['LIKE', 'params', $val])
                    ->orderBy('id')
                    ->one();
            }
        } else {
            $currentVariant = $model->productParams[0];
        }

        $brand = Brand::findOne($model->brand_id);
        $adviser = Adviser::findOne($model->adviser_id);
        $features = [];

        foreach($model->features as $index => $feature) {
            $features[$index]['feature'] = $feature;

            foreach($feature->featurevalues as $i => $fv) {
                $features[$index]['values'][$i]['name'] = $fv->name;
                $features[$index]['values'][$i]['value'] = $fv->value;
            }
        }
        ///////////////////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////
        if (isset($_POST['getProduct']) && $_POST['getProduct'] === 'true') {
            $brothers = $model->getBrothersAll();
            $foundBrother = null;
            $mainParam = Param::findOne($model->main_param);

            foreach($brothers as $brother) {
                $param = $brother->params[0];
                $params = $param->params;
                $brotherMainParamName = null;
                $brotherMainParamValue = null;
                $brotherAdditionalParamName = null;
                $brotherAdditionalParamValue = null;

                foreach($params as $index => $p) {
                    list($name, $value) = explode(' -> ', $p);

                    if ($mainParam->name === $name) {
                        $brotherMainParamName = $name;
                        $brotherMainParamValue = $value;
                    }

                    if (isset($_POST['additionalParam']) && $mainParam->name !== $name) {
                        $brotherAdditionalParamName = $name;
                        $brotherAdditionalParamValue = $value;
                    }
                }

                if ($brother->id !== $model->id) {
                    if ($_POST['mainParam'] === $brotherMainParamValue) {
                        if ($brotherAdditionalParamValue === null) {
                            $foundBrother = $brother;
                            break;
                        } else {
                            if ($_POST['additionalParam'] === $brotherAdditionalParamValue) {
                                $foundBrother = $brother;
                                break;
                            }
                        }
                    }
                }
            }

            $url = $foundBrother->url;

            if ($_POST['fancyboxOpened'] === 'true') {
                $url .= '?fancybox=1';
            }

            return $url;
        } else {
            $model->popular++;
            $model->save();
            $parent = $model->parent;
            ////////////////////////////////////////////////////////////////////////////////////////////
            $accessories = [];
            $ids = [];

            if (!empty($parent->aksses_ids)) {
                foreach(json_decode($parent->aksses_ids) as $value) {
                    $ids[] = (int) $value;
                }

                $accessories = Product::find()
                    ->with([
                        'productParams',
                        'brand',
                        'images',
                        'parent'])
                    ->where(['parent_id' => $ids])
                    ->orderBy(new Expression('rand()'))
                    ->limit(15)
                    ->all();
            }
            ////////////////////////////////////////////////////////////////////////////////////////////
            $similar = [];

            for($i = 15; $i < 100; $i = $i + 5) {
                $priceFrom = (int) $model->price * ((100 - $i) / 100);
                $priceTo = (int) $model->price * ((100 + $i) / 100);
                $similarQuery = Product::find()
                    ->with([
                        'productParams',
                        'brand',
                        'images',
                        'parent'])
                    ->where(['parent_id' => $parent->id])
                    ->andWhere("id <> {$model->id}")
                    ->andWhere("price > $priceFrom  AND price < $priceTo")
                    ->orderBy(new Expression('rand()'))
                    ->limit(9);

                if ($similarQuery->count() >= 3) {
                    $similar = $similarQuery->all();
                    break;
                }
            }
            ////////////////////////////////////////////////////////////////////////////////////////////
            //var_dump($model->getMainFeatures());die();
            ////////////////////////////////////////////////////////////////////////////////////////////
            return $this->render('@frontend/views/catalog/view', [
                'model' => $model,
                'brand' => $brand,
                'currentVariant' => $currentVariant,
                'adviser' => $adviser,
                'features' => $features,
                'accessories' => $accessories,
                'similar' => $similar,
            ]);
        }
    }

    private function catalog($alias, $alias2) {
        $cookies = Yii::$app->request->cookies;
        $cookies->readOnly = false;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'filter_showed',
            'value' => '1',
            'expire' => strtotime('+1 hour'),
        ]));

        if (isset($_POST['set_filter_opened'])) {
            setcookie("set_filter_opened", $_POST['set_filter_opened'], time()+(3600*24*30));
            return false;
        }

        if ($alias === 'catalog') {
            $model = Textpage::findOne(1);

            return $this->render('@frontend/views/catalog/outer', [
                'model' => $model
            ]);
        } else {
            $model = Category::find()->where(['alias' => $alias])->one();

            if ($model) {
                if (!empty($alias2)) {
                    $parent = $model;

                    $model = Category::find()->where([
                        'alias' => $alias2,
                        'parent_id' => $parent->id,
                    ])->one();

                    if (!$model) {
                        $parentBrand = Category::findOne(['id' => $this->parent_id]);
                        $model = Category::find()->where([
                            'alias' => $alias2,
                            'parent_id' => $parentBrand->id,
                        ])->one();

                        if (!$model) {
                            throw new NotFoundHttpException;
                        }
                    }
                }
            } else {
                return '';
            }

            $filter_url = $model->filter_url;
            $url = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $parts = [];

            if (isset($url['query'])) {
                $query = str_replace('%20', '', $url['query']);
                $queryDecoded = urldecode($query);
                parse_str($queryDecoded, $parts);
                unset($parts['sort']);
            }

            // $parts мы очищаем параметр сортировки, и смотрим если есть еще какие-то параметры в _GET, то мы не
            // используем filter_url, так как мы выбрали что-то еще в фильтре

            if (!empty($filter_url) && empty($parts)) {
                $get = [];
                $filter_url_query = parse_url($filter_url, PHP_URL_QUERY);
                $filter_url_query = urldecode($filter_url_query);
                parse_str($filter_url_query, $get);

                foreach($get as $index => $value) {
                    if (is_array($value)) {
                        foreach($value as $i => $v) {
                            if (is_numeric($v)) {
                                $get[$index][$i] = (int) $v;
                            }
                        }
                    } else {
                        if (is_numeric($value)) {
                            $get[$index] = (int) $value;
                        }
                    }
                }
            } else {
                $get = $_GET;
            }

            $tags = [];
            $brandCategories = [];
            $years = [];
            $brandsSerial = [];

            if ($model->type == 0) {//Если категория
                $tags = Category::find()
                    ->with(['parent0', 'productHasCategories'])
                    ->where(['parent_id' => $model->id, 'type' => 1, 'active' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $years = Category::find()
                    ->with(['parent0', 'productHasCategories'])
                    ->where(['parent_id' => $model->id, 'type' => 4, 'active' => 1])
                    ->orderBy(['sort_order' => SORT_DESC])
                    ->all();
                $brandCategories = Category::find()
                    ->with(['parent0', 'brand', 'productHasCategories'])
                    ->where(['parent_id' => $model->id, 'type' => 2, 'active' => 1])
                    ->orderBy(['name' => SORT_ASC])
                    ->all();
                $productQuery = $model->getProducts();
            } else {//Если всё остальное
                if (in_array($model->type, [1, 2, 4])) {
                    $parent = Category::findOne(['id' => $model->parent_id]);

                    $tags = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 1, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 4, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brandCategories = Category::find()
                        ->with(['parent0', 'brand', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 2, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                    $brandsSerial = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => ArrayHelper::getColumn($brandCategories, 'id'), 'type' => 3, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                }

                if ($model->type == 3) {// Если серия бренда
                    $parentBrand = Category::findOne(['id' => $model->parent_id]);
                    $parent = Category::findOne(['id' => $parentBrand->parent_id]);

                    $tags = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 1, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $years = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 4, 'active' => 1])
                        ->orderBy(['sort_order' => SORT_DESC])
                        ->all();
                    $brandCategories = Category::find()
                        ->with(['parent0', 'brand', 'productHasCategories'])
                        ->where(['parent_id' => $parent->id, 'type' => 2, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                    $brandsSerial = Category::find()
                        ->with(['parent0', 'productHasCategories'])
                        ->where(['parent_id' => ArrayHelper::getColumn($brandCategories, 'id'), 'type' => 3, 'active' => 1])
                        ->orderBy(['name' => SORT_ASC])
                        ->all();
                }

                $productQuery = $model->getProducts();
            }
            /////////////////////////////////////////////////////////
            $bHeader = $model->seo_h1 . ' по брендам';
            $bHeader2 = $model->seo_h1;

            if (in_array($model->type, [1, 2, 4])) {
                $parent = Category::findOne($model->parent_id);
                $bHeader = $parent->seo_h1 . ' по брендам';
                $bHeader2 = $parent->seo_h1;
            }

            if ($model->type == 3) {
                $parent = Category::findOne($model->parent_id);
                $parent2 = Category::findOne($parent->parent_id);
                $bHeader = $parent2->seo_h1 . ' по брендам';
                $bHeader2 = $parent2->seo_h1;
            }
            /////////////////////////////////////////////////////////
            $defaultPageSize = 40;
            $countAllProducts = $productQuery->count();
            Product::check404($countAllProducts, $defaultPageSize);
            $minPrice = 100000000;
            $maxPrice = 0;
            $minPriceAvailable = 100000000;
            $maxPriceAvailable = 0;

            $allProductsQuery = clone $productQuery;
            $allProducts = $allProductsQuery->asArray()->all();
            $filterBrands = ArrayHelper::map($allProducts, 'brand_id', 'brand');
            $filterBrands = Brand::sortBrands($filterBrands, $get);
            /*$categoriesFull = Yii::$app->cache->getOrSet('categoriesFull', function() {
                return Category::find()->all();
            }, 10);*/

            $inCategories = $model->getChildrenCategories();
            /*foreach($allProducts as $product) {
                if (!isset($inCategories[$product['parent_id']])) {
                    foreach($categoriesFull as $cc) {
                        if ($cc->id == $product['parent_id']) {
                            $inCategories[$product['parent_id']] = $cc;
                            break;
                        }
                    }
                }
            }*/
            ArrayHelper::multisort($inCategories, ['name'], [SORT_ASC]);

            $productQuery = Filter::filter($productQuery, $get);

            /////////////////////////////////////////////////////////////////////////
            $allProductsQuery = clone $productQuery;
            $allProducts = $allProductsQuery->asArray()->all();
            $countAllProducts = count($allProducts);

            foreach($allProducts as $product) {
                $available = false;

                foreach($product['productParams'] as $pp) {
                    if ($pp['available'] > 0) {
                        $available = true;
                    }
                }

                if ($available) {
                    if ($product['price'] < $minPriceAvailable) {
                        $minPriceAvailable = $product['price'];
                    }

                    if ($product['price'] > $maxPriceAvailable) {
                        $maxPriceAvailable = $product['price'];
                    }
                }

                if ($product['price'] < $minPrice) {
                    $minPrice = $product['price'];
                }

                if ($product['price'] > $maxPrice) {
                    $maxPrice = $product['price'];
                }
            }

            if ($minPrice == 100000000){
                $minPrice = 0;
            }

            if ($minPriceAvailable == 100000000){
                $minPriceAvailable = 0;
            }

            if ($maxPrice == 0){
                $maxPrice = 100000000;
            }

            if ($maxPriceAvailable == 0){
                $maxPriceAvailable = 100000000;
            }

            $pages = new \yii\data\Pagination([
                'totalCount' => $allProductsQuery->count(),
                'defaultPageSize' => $defaultPageSize,
                'pageSizeParam' => 'per_page',
                'forcePageParam' => false,
                'pageSizeLimit' => 200
            ]);

            $products = $productQuery->limit($pages->limit)->offset($pages->offset)->all();

            if ($model->type == 0) {
                $filterFeatures = $model->filterFeatures;
            } else {
                $filterFeatures = $model->parent0->filterFeatures;
            }

            //Category::clearEmptyFeatures($filterFeatures, $allProductsQuery);

            return $this->render('@frontend/views/catalog/index', [
                'model' => $model,
                'products' => $products,
                'pages' => $pages,
                'tags' => $tags,
                'brandCategories' => $brandCategories,
                'years' => $years,
                'brandsSerial' => $brandsSerial,
                'bHeader' => $bHeader,
                'bHeader2' => $bHeader2,
                'minPrice' => $minPriceAvailable,
                'maxPrice' => $maxPriceAvailable,
                'filterBrands' => $filterBrands,
                'inCategories' => $inCategories,
                'filterFeatures' => $filterFeatures,
                'get' => $get,
            ]);
        }
    }

    public function actionSubscribe()
    {
        $model = new SubscribeForm();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {
            $subscribe = Subscribe::findOne(['email' => $post['SubscribeForm']['email']]);

            if ($subscribe) {
                return 'success';
            } else {
                $subscribe = new Subscribe();
                $subscribe->email = $post['SubscribeForm']['email'];

                if($subscribe->save()) {
                    return 'success';
                } else {
                    return 'error';
                }
            }
        } else {
            return 'error';
        }
    }

    /*
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }*/
}
