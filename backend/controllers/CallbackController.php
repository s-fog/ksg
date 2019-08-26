<?php

namespace backend\controllers;

use yii\filters\AccessControl;

/**
* This is the class for controller "CallbackController".
*/
class CallbackController extends \backend\controllers\base\CallbackController
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            if ($model->status == 0) {
                $model->status = 1;
                $model->save();
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
