<?php

namespace backend\controllers;

use backend\models\UploadFile;
use common\models\News;
use yii\web\UploadedFile;

/**
* This is the class for controller "NewsController".
*/
class NewsController extends \backend\controllers\base\NewsController
{
    public function actionCreate()
    {
        $model = new News;
        $model->scenario = 'create';

        try {
            if ($model->load($_POST)) {
                $model->image = UploadedFile::getInstance($model, "image");

                if ($model->validate()) {
                    $model->image = UploadFile::upload(
                        $model,
                        News::findOne($model->id),
                        'image',
                        'image',
                        ['260x150']
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
                    $model->image = UploadFile::upload(
                        $model,
                        News::findOne($model->id),
                        'image',
                        'image',
                        ['260x150']
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
