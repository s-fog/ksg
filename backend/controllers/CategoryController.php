<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\Sitemap;
use backend\models\UploadFile;
use common\models\Category;
use common\models\Feature;
use common\models\FeatureValue;
use common\models\FilterFeature;
use common\models\Step;
use Exception;
use sfog\image\Image;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
* This is the class for controller "CategoryController".
*/
class CategoryController extends \backend\controllers\base\CategoryController
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
        $model = new Category;
        $model->disallow_xml = 0;
        $model->parent_id = 0;
        $model->active = 1;
        $modelsFeature = [new Feature];
        $modelsFeatureValue = [[new FeatureValue]];
        $modelsFilterFeature = [new FilterFeature];
        $modelsStep = [new Step];

        if ($model->load(Yii::$app->request->post())) {
            $modelsFeature = Model::createMultiple(Feature::classname());
            Model::loadMultiple($modelsFeature, Yii::$app->request->post());

            $modelsStep = Model::createMultiple(Step::classname());
            Model::loadMultiple($modelsStep, Yii::$app->request->post());

            $modelsFilterFeature = Model::createMultiple(FilterFeature::classname());
            Model::loadMultiple($modelsFilterFeature, Yii::$app->request->post());

            $model->image_catalog = UploadedFile::getInstance($model, "image_catalog");
            $model->image_menu = UploadedFile::getInstance($model, "image_menu");

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsFeature),
                    ActiveForm::validateMultiple($modelsStep),
                    ActiveForm::validateMultiple($modelsFilterFeature),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFeature) && $valid;
            $valid = Model::validateMultiple($modelsStep) && $valid;
            $valid = Model::validateMultiple($modelsFilterFeature) && $valid;

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
                $sfogImage = new Image;
                $model->image_catalog = $sfogImage->uploadFile(
                    $model,
                    'image_catalog',
                    'image_catalog',
                    ['1600x250']
                );
                $model->image_menu = $sfogImage->uploadFile(
                    $model,
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

                        foreach ($modelsFilterFeature as $indexFeature => $modelFilterFeature) {
                            $modelFilterFeature->category_id = $model->id;

                            if (! ($flag = $modelFilterFeature->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsStep as $indexStep => $modelStep) {
                            $modelStep->category_id = $model->id;

                            if (! ($flag = $modelStep->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Sitemap::doIt();

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
            'modelsStep' => (empty($modelsStep)) ? [new Step] : $modelsStep,
            'modelsFilterFeature' => (empty($modelsFilterFeature)) ? [new FilterFeature] : $modelsFilterFeature,
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
        $modelsStep = $model->steps;
        $modelsFilterFeature = $model->filterFeaturesS;
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

            $oldStepsIDs = ArrayHelper::map($modelsStep, 'id', 'id');
            $modelsStep = Model::createMultiple(Step::classname(), $modelsStep);
            Model::loadMultiple($modelsStep, Yii::$app->request->post());
            $deletedStepsIDs = array_diff($oldStepsIDs, array_filter(ArrayHelper::map($modelsStep, 'id', 'id')));

            $oldIDsFF = ArrayHelper::map($modelsFilterFeature, 'id', 'id');
            $modelsFilterFeature = Model::createMultiple(FilterFeature::classname(), $modelsFilterFeature);
            Model::loadMultiple($modelsFilterFeature, Yii::$app->request->post());
            $deletedIDsFF = array_diff($oldIDsFF, array_filter(ArrayHelper::map($modelsFilterFeature, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsFeature),
                    ActiveForm::validateMultiple($modelsStep),
                    ActiveForm::validateMultiple($modelsFilterFeature),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFeature) && $valid;
            $valid = Model::validateMultiple($modelsStep) && $valid;
            $valid = Model::validateMultiple($modelsFilterFeature) && $valid;


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
                $sfogImage = new Image;

                if (!empty($_FILES['Category']['name']['image_catalog'])) {
                    $model->image_catalog = $sfogImage->uploadFile(
                        $model,
                        'image_catalog',
                        'image_catalog',
                        ['1600x250']
                    );
                } else {
                    $model->image_catalog = $image_catalog;
                }

                if (!empty($_FILES['Category']['name']['image_menu'])) {
                    $model->image_menu = $sfogImage->uploadFile(
                        $model,
                        'image_menu',
                        'image_menu',
                        ['134x134']
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
                        if (! empty($deletedIDsFF)) {
                            FilterFeature::deleteAll(['id' => $deletedIDsFF]);
                        }
                        if (! empty($deletedStepsIDs)) {
                            Step::deleteAll(['id' => $deletedStepsIDs]);
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

                        foreach ($modelsFilterFeature as $indexFeature => $modelFilterFeature) {
                            $modelFilterFeature->category_id = $model->id;

                            if (! ($flag = $modelFilterFeature->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsStep as $modelStep) {
                            $modelStep->category_id = $model->id;

                            if (! ($flag = $modelStep->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Sitemap::doIt();

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
            'modelsStep' => (empty($modelsStep)) ? [new Step] : $modelsStep,
            'modelsFilterFeature' => (empty($modelsFilterFeature)) ? [new FilterFeature] : $modelsFilterFeature,
            'modelsFeatureValue' => (empty($modelsFeatureValue[0])) ? [[new FeatureValue]] : $modelsFeatureValue
        ]);
    }
}
