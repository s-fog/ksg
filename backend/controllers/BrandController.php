<?php

namespace backend\controllers;

use backend\models\Sitemap;
use backend\models\UploadFile;
use common\models\Brand;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
* This is the class for controller "BrandController".
*/
class BrandController extends \backend\controllers\base\BrandController
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
        $model = new Brand;
        $model->scenario = 'create';

        try {
            if ($model->load($_POST)) {
                $model->image = UploadedFile::getInstance($model, "image");

                if ($model->validate()) {
                    $uploadedCustom = new UploadFile(true, 95);
                    $model->image = $uploadedCustom->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['280x140', '60x30']
                    );

                    if ($model->save(false)) {
                        Yii::$app->queue_default->push(new Sitemap());
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
     * Updates an existing Brand model.
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
                if (!empty($_FILES['Brand']['name']['image'])) {
                    $uploadedCustom = new UploadFile(true, 95);
                    $model->image = $uploadedCustom->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['280x140', '60x30']
                    );
                } else {
                    $model->image = $image;
                }

                if ($model->save(false)) {
                    Yii::$app->queue_default->push(new Sitemap());
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
