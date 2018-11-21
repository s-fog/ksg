<?php

namespace backend\controllers;

use backend\models\UploadFile;
use common\models\Adviser;
use sfog\image\Image;
use yii\web\UploadedFile;

/**
* This is the class for controller "AdviserController".
*/
class AdviserController extends \backend\controllers\base\AdviserController
{
    public function actionCreate()
    {
        $model = new Adviser;
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
                        ['130x175']
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


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $image = $model->image;

        if ($model->load($_POST)) {
            if ($model->validate()) {
                if (!empty($_FILES['Adviser']['name']['image'])) {
                    $sfogImage = new Image;
                    $model->image = $sfogImage->uploadFile(
                        $model,
                        'image',
                        'image',
                        ['130x175']
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
