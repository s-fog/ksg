<?php

namespace backend\controllers;

use common\models\Build;
use yii\filters\AccessControl;

/**
* This is the class for controller "BuildController".
*/
class BuildController extends \backend\controllers\base\BuildController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Build;

        try {
            if ($model->load($_POST)) {
                if (!empty($_POST['Build']['prices'])) {
                    $model->prices = json_encode($_POST['Build']['prices']);
                }

                if ($model->save()) {
                    return $this->redirect(['index']);
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
     * Updates an existing Build model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($_POST)) {
            if (!empty($_POST['Build']['prices'])) {
                $model->prices = json_encode($_POST['Build']['prices']);
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
