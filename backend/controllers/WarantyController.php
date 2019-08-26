<?php

namespace backend\controllers;

use common\models\Waranty;
use yii\filters\AccessControl;

/**
* This is the class for controller "WarantyController".
*/
class WarantyController extends \backend\controllers\base\WarantyController
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
        $model = new Waranty;

        try {
            if ($model->load($_POST)) {
                if (!empty($_POST['Waranty']['prices'])) {
                    $model->prices = json_encode($_POST['Waranty']['prices']);
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
     * Updates an existing Waranty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($_POST)) {
            if (!empty($_POST['Waranty']['prices'])) {
                $model->prices = json_encode($_POST['Waranty']['prices']);
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
