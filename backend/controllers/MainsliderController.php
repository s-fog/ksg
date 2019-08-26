<?php

namespace backend\controllers;

use backend\models\UploadFile;
use common\models\Mainslider;
use sfog\image\Image;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
* This is the class for controller "MainsliderController".
*/
class MainsliderController extends \backend\controllers\base\MainsliderController
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
        $model = new Mainslider;
        $model->scenario = 'create';

        try {
            if ($model->load($_POST)) {
                $model->image = UploadedFile::getInstance($model, "image");

                if ($model->validate()) {
                    $sfogImage = new Image;
                    $model->image = $sfogImage->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['1942x438']
                    );

                    if ($model->save(false)) {
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
     * Updates an existing Mainslider model.
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
                if (!empty($_FILES['Mainslider']['name']['image'])) {
                    $sfogImage = new Image;
                    $model->image = $sfogImage->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['1942x438']
                    );
                } else {
                    $model->image = $image;
                }

                if ($model->save(false)) {
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
