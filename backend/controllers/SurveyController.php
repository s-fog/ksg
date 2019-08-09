<?php

namespace backend\controllers;

use backend\models\Model;
use common\models\Step;
use common\models\StepOption;
use common\models\Survey;
use Exception;
use sfog\image\Image as SfogImage;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
* This is the class for controller "SurveyController".
*/
class SurveyController extends \backend\controllers\base\SurveyController
{
    public function actionCreate()
    {
        $modelSurvey = new Survey;
        $modelSurvey->scenario = 'create';
        $modelsStep = [new Step];
        $modelsStepOption = [[new StepOption]];
        $sfogImage = new SfogImage;

        if ($modelSurvey->load(Yii::$app->request->post())) {
            $modelsStep = Model::createMultiple(Step::classname());
            Model::loadMultiple($modelsStep, Yii::$app->request->post());

            $modelSurvey->preview_image = UploadedFile::getInstance($modelSurvey, "preview_image");
            $modelSurvey->cupon_image = UploadedFile::getInstance($modelSurvey, "cupon_image");
            $modelSurvey->success_image = UploadedFile::getInstance($modelSurvey, "success_image");

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsStep),
                    ActiveForm::validate($modelSurvey)
                );
            }

            // validate all models
            $valid = $modelSurvey->validate();
            $valid = Model::validateMultiple($modelsStep) && $valid;

            if (isset($_POST['StepOption'][0][0])) {
                foreach ($_POST['StepOption'] as $indexStep => $steps) {
                    foreach ($steps as $indexStepOption => $stepVersion) {
                        $data['StepOption'] = $stepVersion;
                        $modelStepOption = (isset($stepVersion['id']) && isset($oldStepOption[$stepVersion['id']])) ? $oldStepOption[$stepVersion['id']] : new StepOption;
                        $modelStepOption->load($data);
                        $modelsStepOption[$indexStep][$indexStepOption] = $modelStepOption;
                        $valid = $modelStepOption->validate();
                    }
                }
            }

            if (!empty($_FILES['Survey']['name']['preview_image'])) {
                $modelSurvey->preview_image = $sfogImage->uploadFile(
                    $modelSurvey,
                    'preview_image',
                    'preview_image',
                    ['260x150']
                );
            }

            if (!empty($_FILES['Survey']['name']['cupon_image'])) {
                $modelSurvey->cupon_image = $sfogImage->uploadFile(
                    $modelSurvey,
                    'cupon_image',
                    'cupon_image',
                    []
                );
            }

            if (!empty($_FILES['Survey']['name']['success_image'])) {
                $modelSurvey->success_image = $sfogImage->uploadFile(
                    $modelSurvey,
                    'success_image',
                    'success_image',
                    []
                );
            }

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelSurvey->save(false)) {
                        foreach ($modelsStep as $indexStep => $modelStep) {
                            $modelStep->survey_id = $modelSurvey->id;

                            if (! ($flag = $modelStep->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            if (isset($modelsStepOption[$indexStep]) && is_array($modelsStepOption[$indexStep])) {
                                foreach ($modelsStepOption[$indexStep] as $modelStepOption) {
                                    $modelStepOption->step_id = $modelStep->id;

                                    if (!($flag = $modelStepOption->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $modelSurvey,
            'modelsStep' => (empty($modelsStep)) ? [new Step] : $modelsStep,
            'modelsStepOption' => (empty($modelsStepOption[0])) ? [[new StepOption]] : $modelsStepOption
        ]);
    }

    /**
     * Updates an existing Survey model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelSurvey = $this->findModel($id);
        $modelsStep = $modelSurvey->steps;
        $modelsStepOption = [];
        $oldStepOption = [];
        $sfogImage = new SfogImage;
        $cupon_image = $modelSurvey->cupon_image;
        $preview_image = $modelSurvey->preview_image;
        $success_image = $modelSurvey->success_image;

        if (!empty($modelsStep)) {
            foreach ($modelsStep as $index => $modelStep) {
                $stepOptions = $modelStep->stepOptions;
                $modelsStepOption[$index] = $stepOptions;
                $oldStepOption = ArrayHelper::merge(ArrayHelper::index($stepOptions, 'id'), $oldStepOption);
            }
        }

        if ($modelSurvey->load(Yii::$app->request->post())) {
            $modelsStepOption = [];

            $oldIDs = ArrayHelper::map($modelsStep, 'id', 'id');
            $modelsStep = Model::createMultiple(Step::classname(), $modelsStep);
            Model::loadMultiple($modelsStep, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsStep, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsStep),
                    ActiveForm::validate($modelSurvey)
                );
            }

            // validate all models
            $valid = $modelSurvey->validate();
            $valid = Model::validateMultiple($modelsStep) && $valid;

            $stepOptionIDs = [];
            if (isset($_POST['StepOption'][0][0])) {
                foreach ($_POST['StepOption'] as $indexStep => $stepOptions) {
                    $stepOptionIDs = ArrayHelper::merge($stepOptionIDs, array_filter(ArrayHelper::getColumn($stepOptions, 'id')));

                    foreach ($stepOptions as $indexStepOption => $stepOption) {
                        $data['StepOption'] = $stepOption;
                        $modelStepOption = (isset($stepOption['id']) && isset($oldStepOption[$stepOption['id']])) ? $oldStepOption[$stepOption['id']] : new StepOption;
                        $modelStepOption->load($data);
                        $modelsStepOption[$indexStep][$indexStepOption] = $modelStepOption;
                        $valid = $modelStepOption->validate();
                    }
                }
            }

            $oldStepOptionIDs = ArrayHelper::getColumn($oldStepOption, 'id');
            $deletedStepOptionIDs = array_diff($oldStepOptionIDs, $stepOptionIDs);

            if (!empty($_FILES['Survey']['name']['preview_image'])) {
                $modelSurvey->preview_image = $sfogImage->uploadFile(
                    $modelSurvey,
                    'preview_image',
                    'preview_image',
                    ['260x150']
                );
            } else {
                $modelSurvey->preview_image = $preview_image;
            }

            if (!empty($_FILES['Survey']['name']['cupon_image'])) {
                $modelSurvey->cupon_image = $sfogImage->uploadFile(
                    $modelSurvey,
                    'cupon_image',
                    'cupon_image',
                    []
                );
            } else {
                $modelSurvey->cupon_image = $cupon_image;
            }

            if (!empty($_FILES['Survey']['name']['success_image'])) {
                $modelSurvey->success_image = $sfogImage->uploadFile(
                    $modelSurvey,
                    'success_image',
                    'success_image',
                    []
                );
            } else {
                $modelSurvey->success_image = $success_image;
            }

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelSurvey->save(false)) {
                        if (! empty($deletedStepOptionIDs)) {
                            StepOption::deleteAll(['id' => $deletedStepOptionIDs]);
                        }
                        if (! empty($deletedIDs)) {
                            Step::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsStep as $indexStep => $modelStep) {
                            $modelStep->survey_id = $modelSurvey->id;

                            if (! ($flag = $modelStep->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            if (isset($modelsStepOption[$indexStep]) && is_array($modelsStepOption[$indexStep])) {
                                foreach ($modelsStepOption[$indexStep] as $modelStepOption) {
                                    $modelStepOption->step_id = $modelStep->id;

                                    if (!($flag = $modelStepOption->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $modelSurvey,
            'modelsStep' => (empty($modelsStep)) ? [new Step] : $modelsStep,
            'modelsStepOption' => (empty($modelsStepOption[0])) ? [[new StepOption]] : $modelsStepOption
        ]);
    }
}
