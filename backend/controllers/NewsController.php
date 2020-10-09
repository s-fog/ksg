<?php

namespace backend\controllers;

use backend\models\Sitemap;
use backend\models\UploadFile;
use common\models\News;
use sfog\image\Image;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
* This is the class for controller "NewsController".
*/
class NewsController extends \backend\controllers\base\NewsController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new News;
        $model->scenario = 'create';

        try {
            if ($model->load($_POST)) {
                $model->image = UploadedFile::getInstance($model, "image");

                if ($model->validate()) {
                    $sfogImage = new Image(false, 95);
                    $model->image = $sfogImage->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['260x150']
                    );

                    if ($model->save(false)) {
                        Sitemap::doIt();
                        return $this->redirect(['index']);
                    }
                }
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $image = $model->image;

        if ($model->load($_POST)) {
            if ($model->validate()) {
                if (!empty($_FILES['News']['name']['image'])) {
                    $sfogImage = new Image(false, 95);
                    $model->image = $sfogImage->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['260x150']
                    );
                } else {
                    $model->image = $image;
                }

                if ($model->save(false)) {
                    Sitemap::doIt();
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
