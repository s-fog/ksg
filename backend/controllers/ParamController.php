<?php

namespace backend\controllers;

use common\models\Param;

/**
* This is the class for controller "ParamController".
*/
class ParamController extends \backend\controllers\base\ParamController
{
    public function actionCreate()
    {
        $model = new Param;

        try {
            if ($model->load($_POST)) {
                if ($model->validate()) {
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
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($_POST)) {
            if ($model->validate()) {
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
