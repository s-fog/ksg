<?php
namespace backend\controllers;

use backend\models\UploadFile;
use common\models\Mainpage;
use sfog\image\Image;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use sfog\image\Image as SfogImage;

/**
 * Site controller
 */
class MainpageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Mainpage::findOne(1);

        if ($model->load($_POST)) {
            $sfogImage = new SfogImage(false, 95);
            $banner_image = $model->banner_image;

            if (!empty($_FILES['Mainpage']['name']['banner_image'])) {
                $model->banner_image = $sfogImage->uploadFile(
                    $model,
                    'banner_image',
                    'banner_image',
                    []
                );
            } else {
                $model->banner_image = $banner_image;
            }

            if ($model->validate()) {
                if ($model->save()) {

                }
            }
        }
        
        return $this->render('@backend/views/mainpage/update', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
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

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
