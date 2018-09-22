<?php
namespace frontend\controllers;

use common\models\Brand;
use common\models\Feature;
use common\models\FeatureValue;
use common\models\Mainpage;
use common\models\News;
use common\models\Product;
use common\models\Textpage;
use frontend\models\Compare;
use frontend\models\Favourite;
use Yii;
use yii\base\InvalidParamException;
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
    public function actionIndex($alias = '', $alias2 = '')
    {
        if (!empty($alias2)) {
            $textpage = Textpage::findOne(['alias' => $alias2]);
            $newsItem = News::findOne(['alias' => $alias2]);

            if ($textpage || $newsItem) {
                if ($textpage) {
                    if ($textpage->type == 1) {
                        $parent = Textpage::findOne(8);
                    } else {
                        $parent = Textpage::findOne(9);
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
                        'parent' => Textpage::findOne(10),
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
                    $alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','V','W','X','Y','Z','А-Я'];
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
                /*case 13: {
                    $news = News::find()->orderBy(['created_at' => SORT_DESC])->all();

                    return $this->render('@frontend/views/news/index', [
                        'model' => $textpage,
                        'news' => $news,
                    ]);
                }*/
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
                        $orderBy = ['popular' => SORT_DESC];
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
            }
        }


        $model = Mainpage::findOne(1);

        return $this->render('index', [
            'model' => $model,
        ]);
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
