<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\UploadFile;
use common\models\Category;
use common\models\Feature;
use common\models\FeatureValue;
use Exception;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
* This is the class for controller "CategoryController".
*/
class CategoryController extends \backend\controllers\base\CategoryController
{
    public function actionCreate()
    {
        $model = new Category;
        $model->disallow_xml = 0;
        $model->parent_id = 0;
        $modelsFeature = [new Feature];
        $modelsFeatureValue = [[new FeatureValue]];

        if ($model->load(Yii::$app->request->post())) {
            $modelsFeature = Model::createMultiple(Feature::classname());
            Model::loadMultiple($modelsFeature, Yii::$app->request->post());

            $model->image_catalog = UploadedFile::getInstance($model, "image_catalog");
            $model->image_menu = UploadedFile::getInstance($model, "image_menu");

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsFeature),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFeature) && $valid;

            if (isset($_POST['FeatureValue'][0][0])) {
                foreach ($_POST['FeatureValue'] as $indexFeature => $featureValues) {
                    foreach ($featureValues as $indexFeatureValue => $featureValue) {
                        $data['FeatureValue'] = $featureValue;
                        $modelFeatureValue = (isset($featureValue['id']) && isset($oldFeatureValue[$featureValue['id']])) ? $oldFeatureValue[$featureValue['id']] : new FeatureValue;
                        $modelFeatureValue->load($data);
                        $modelsFeatureValue[$indexFeature][$indexFeatureValue] = $modelFeatureValue;
                        $valid = $modelFeatureValue->validate();
                    }
                }
            }

            if ($valid) {
                $model->image_catalog = UploadFile::upload(
                    $model,
                    Category::findOne($model->id),
                    'image_catalog',
                    'image_catalog',
                    ['1600x250']
                );
                $model->image_menu = UploadFile::upload(
                    $model,
                    Category::findOne($model->id),
                    'image_menu',
                    'image_menu',
                    ['134x134']
                );

                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsFeature as $indexFeature => $modelFeature) {
                            $modelFeature->category_id = $model->id;

                            if (! ($flag = $modelFeature->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            if (isset($modelsFeatureValue[$indexFeature]) && is_array($modelsFeatureValue[$indexFeature])) {
                                foreach ($modelsFeatureValue[$indexFeature] as $indexFeatureValue => $modelFeatureValue) {
                                    $modelFeatureValue->feature_id = $modelFeature->id;

                                    if (!($flag = $modelFeatureValue->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();

                        if ($_POST['mode'] == 'justSave') {
                            return $this->redirect(['update', 'id' => $model->id]);
                        } else {
                            return $this->redirect(['index']);
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsFeature' => (empty($modelsFeature)) ? [new Feature] : $modelsFeature,
            'modelsFeatureValue' => (empty($modelsFeatureValue[0])) ? [[new FeatureValue]] : $modelsFeatureValue
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $image_catalog = $model->image_catalog;
        $image_menu = $model->image_menu;
        $modelsFeature = $model->features;
        $modelsFeatureValue = [];
        $oldFeatureValue = [];

        if (!empty($modelsFeature)) {
            foreach ($modelsFeature as $index => $modelFeature) {
                $featureValues = $modelFeature->featurevalues;
                $modelsFeatureValue[$index] = $featureValues;
                $oldFeatureValue = ArrayHelper::merge(ArrayHelper::index($featureValues, 'id'), $oldFeatureValue);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $modelsFeatureValue = [];

            $oldIDs = ArrayHelper::map($modelsFeature, 'id', 'id');
            $modelsFeature = Model::createMultiple(Feature::classname(), $modelsFeature);
            Model::loadMultiple($modelsFeature, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsFeature, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsFeature),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFeature) && $valid;

            $featureValueIDs = [];
            if (isset($_POST['FeatureValue'][0][0])) {
                foreach ($_POST['FeatureValue'] as $indexFeature => $featureValues) {
                    $featureValueIDs = ArrayHelper::merge($featureValueIDs, array_filter(ArrayHelper::getColumn($featureValues, 'id')));

                    foreach ($featureValues as $indexFeatureValue => $featureValue) {
                        $data['FeatureValue'] = $featureValue;
                        $modelFeatureValue = (isset($featureValue['id']) && isset($oldFeatureValue[$featureValue['id']])) ? $oldFeatureValue[$featureValue['id']] : new FeatureValue;
                        $modelFeatureValue->load($data);
                        $modelsFeatureValue[$indexFeature][$indexFeatureValue] = $modelFeatureValue;
                        $valid = $modelFeatureValue->validate();
                    }
                }
            }

            $oldFeatureValueIDs = ArrayHelper::getColumn($oldFeatureValue, 'id');
            $deletedFeatureValueIDs = array_diff($oldFeatureValueIDs, $featureValueIDs);


            if ($valid) {
                if (!empty($_FILES['Category']['name']['image_catalog'])) {
                    $model->image_catalog = UploadFile::upload(
                        $model,
                        Category::findOne($model->id),
                        'image_catalog',
                        'image_catalog',
                        ['1600x250']
                    );
                } else {
                    $model->image_catalog = $image_catalog;
                }
                if (!empty($_FILES['Category']['name']['image_menu'])) {
                    $model->image_menu = UploadFile::upload(
                        $model,
                        Category::findOne($model->id),
                        'image_menu',
                        'image_menu',
                        ['1600x250']
                    );
                } else {
                    $model->image_menu = $image_menu;
                }

                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedFeatureValueIDs)) {
                            FeatureValue::deleteAll(['id' => $deletedFeatureValueIDs]);
                        }
                        if (! empty($deletedIDs)) {
                            Feature::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsFeature as $indexFeature => $modelFeature) {
                            $modelFeature->category_id = $model->id;

                            if (! ($flag = $modelFeature->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            if (isset($modelsFeatureValue[$indexFeature]) && is_array($modelsFeatureValue[$indexFeature])) {
                                foreach ($modelsFeatureValue[$indexFeature] as $indexFeatureValue => $modelFeatureValue) {
                                    $modelFeatureValue->feature_id = $modelFeature->id;

                                    if (!($flag = $modelFeatureValue->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();

                        if ($_POST['mode'] == 'justSave') {
                            return $this->redirect(['update', 'id' => $model->id]);
                        } else {
                            return $this->redirect(['index']);
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsFeature' => (empty($modelsFeature)) ? [new Feature] : $modelsFeature,
            'modelsFeatureValue' => (empty($modelsFeatureValue[0])) ? [[new FeatureValue]] : $modelsFeatureValue
        ]);
    }
}
