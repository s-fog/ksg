<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\UploadFile;
use backend\models\UploadFileDynamicForm;
use common\models\Category;
use common\models\Feature;
use common\models\FeatureValue;
use common\models\Image;
use common\models\Product;
use common\models\ProductParam;
use common\models\ProductReview;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
* This is the class for controller "ProductController".
*/
class ProductController extends \backend\controllers\base\ProductController
{
    public function actionCreate()
    {
        $model = new Product;
        $modelsReview = [new ProductReview];
        $modelsImage = [new Image];
        $modelsParams = [new ProductParam];
        $modelsImage[0]->scenario = 'create';
        $model->hit = 0;
        $model->disallow_xml = 0;
        $modelsFeature = [new Feature];
        $modelsFeatureValue = [[new FeatureValue]];

        if ($model->load(Yii::$app->request->post())) {
            $model->generateCode();

            $modelsImage = Model::createMultiple(Image::classname());
            Model::loadMultiple($modelsImage, Yii::$app->request->post());
            $modelsReview = Model::createMultiple(ProductReview::classname());
            Model::loadMultiple($modelsReview, Yii::$app->request->post());
            $modelsFeature = Model::createMultiple(Feature::classname());
            Model::loadMultiple($modelsFeature, Yii::$app->request->post());
            $modelsParams = Model::createMultiple(Feature::classname());
            Model::loadMultiple($modelsParams, Yii::$app->request->post());

            $model->instruction = UploadedFile::getInstance($model, "instruction");

            foreach($modelsImage as $index => $modelImage) {
                $modelImage->image = UploadedFile::getInstance($modelImage, "[{$index}]image");
                $modelImage->scenario = 'create';
            }

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsImage),
                    ActiveForm::validateMultiple($modelsReview),
                    ActiveForm::validateMultiple($modelsFeature),
                    ActiveForm::validateMultiple($modelsParams),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsImage) && $valid;
            $valid = Model::validateMultiple($modelsReview) && $valid;
            $valid = Model::validateMultiple($modelsFeature) && $valid;
            $valid = Model::validateMultiple($modelsParams) && $valid;

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
                foreach($modelsReview as $index => $modelReview) {
                    $modelReview->date = strtotime($_POST['ProductReview'][$index]['date']);
                }

                $model->instruction = UploadFile::upload(
                    $model,
                    Product::findOne($model->id),
                    'instruction',
                    'instruction',
                    []
                );

                foreach($modelsImage as $index => $modelImage) {
                    $modelImage->image = UploadFileDynamicForm::upload(
                        $modelImage,
                        Image::findOne($modelImage->id),
                        $index,
                        "[{$index}]image",
                        "[{$index}]image",
                        ['770x553']
                    );
                }

                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsFeature as $indexFeature => $modelFeature) {
                            $modelFeature->product_id = $model->id;

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

                        foreach ($modelsImage as $modelImage) {
                            $modelImage->product_id = $model->id;

                            if (! ($flag = $modelImage->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsParams as $modelParams) {
                            $modelParams->product_id = $model->id;

                            if (! ($flag = $modelParams->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsReview as $modelReview) {
                            $modelReview->product_id = $model->id;

                            if (! ($flag = $modelReview->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        //Заполняем предзаполненные характеристики из категории для товара
                        if (!Feature::findAll(['product_id' => $model->id])) {
                            $category = Category::findOne($model->parent_id);
                            $categoryFeatures = Feature::find()
                                ->where(['category_id' => $category->id])
                                ->orderBy(['id' => SORT_ASC])
                                ->all();

                            if ($categoryFeatures) {
                                foreach($categoryFeatures as $categoryFeature) {
                                    $feature = new Feature();
                                    $feature->header = $categoryFeature->header;
                                    $feature->product_id = $model->id;
                                    $feature->save();

                                    $categoryFeatureValues = FeatureValue::find()
                                        ->where(['feature_id' => $categoryFeature->id])
                                        ->orderBy(['id' => SORT_ASC])
                                        ->all();

                                    if ($categoryFeatureValues) {
                                        foreach($categoryFeatureValues as $categoryFeatureValue) {
                                            $featureValue = new FeatureValue();
                                            $featureValue->name = $categoryFeatureValue->name;
                                            $featureValue->value = $categoryFeatureValue->value;
                                            $featureValue->feature_id = $feature->id;
                                            $featureValue->save();
                                        }
                                    }
                                }
                            }
                        }
                        //Заполняем предзаполненные характеристики из категории для товара END

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
            'modelsImage' => (empty($modelsImage)) ? [new Image] : $modelsImage,
            'modelsReview' => (empty($modelsReview)) ? [new ProductReview] : $modelsReview,
            'modelsParams' => (empty($modelsParams)) ? [new ProductParam] : $modelsParams,
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
        $modelsImage = $model->images;
        $modelsReview = $model->reviews;
        $modelsParams = $model->params;
        $images = [];
        $instruction = $model->instruction;
        $modelsFeature = $model->features;
        $modelsFeatureValue = [];
        $oldFeatureValue = [];

        foreach($modelsImage as $index => $modelImage) {
            $images[$modelImage->id] = $modelImage->image;
        }

        if (!empty($modelsFeature)) {
            foreach ($modelsFeature as $index => $modelFeature) {
                $featureValues = $modelFeature->featurevalues;
                $modelsFeatureValue[$index] = $featureValues;
                $oldFeatureValue = ArrayHelper::merge(ArrayHelper::index($featureValues, 'id'), $oldFeatureValue);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $modelsFeatureValue = [];
            /////////////////////////////////////////////////////////////
            $oldImageIDs = ArrayHelper::map($modelsImage, 'id', 'id');
            $modelsImage = Model::createMultiple(Image::classname(), $modelsImage);
            Model::loadMultiple($modelsImage, Yii::$app->request->post());
            $deletedImageIDs = array_diff($oldImageIDs, array_filter(ArrayHelper::map($modelsImage, 'id', 'id')));
            /////////////////////////////////////////////////////////////
            $oldReviewIDs = ArrayHelper::map($modelsReview, 'id', 'id');
            $modelsReview = Model::createMultiple(ProductReview::classname(), $modelsReview);
            Model::loadMultiple($modelsReview, Yii::$app->request->post());
            $deletedReviewIDs = array_diff($oldReviewIDs, array_filter(ArrayHelper::map($modelsReview, 'id', 'id')));
            /////////////////////////////////////////////////////////////
            $oldFeatureIDs = ArrayHelper::map($modelsFeature, 'id', 'id');
            $modelsFeature = Model::createMultiple(Feature::classname(), $modelsFeature);
            Model::loadMultiple($modelsFeature, Yii::$app->request->post());
            $deletedFeatureIDs = array_diff($oldFeatureIDs, array_filter(ArrayHelper::map($modelsFeature, 'id', 'id')));
            /////////////////////////////////////////////////////////////
            $oldParamIDs = ArrayHelper::map($modelsParams, 'id', 'id');
            $modelsParams = Model::createMultiple(ProductParam::classname(), $modelsParams);
            Model::loadMultiple($modelsParams, Yii::$app->request->post());
            $deletedParamIDs = array_diff($oldParamIDs, array_filter(ArrayHelper::map($modelsParams, 'id', 'id')));
            /////////////////////////////////////////////////////////////

            foreach($modelsImage as $index => $modelImage) {
                if (!empty($_FILES['Image']['name'][$index]['image'])) {
                    $modelImage->image = UploadedFile::getInstance($modelImage, "[{$index}]image");
                }
            }

            foreach($modelsReview as $index => $modelReview) {
                $modelReview->date = strtotime($_POST['ProductReview'][$index]['date']);
            }

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsImage),
                    ActiveForm::validateMultiple($modelsReview),
                    ActiveForm::validateMultiple($modelsFeature),
                    ActiveForm::validateMultiple($modelsParams),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsImage) && $valid;
            $valid = Model::validateMultiple($modelsReview) && $valid;
            $valid = Model::validateMultiple($modelsFeature) && $valid;
            $valid = Model::validateMultiple($modelsParams) && $valid;

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
                foreach($modelsImage as $index => $modelImage) {
                    if (!empty($_FILES['Image']['name'][$index]['image'])) {
                        $modelImage->image = UploadFileDynamicForm::upload(
                            $modelImage,
                            Image::findOne($modelImage->id),
                            $index,
                            "[{$index}]image",
                            "[{$index}]image",
                            ['770x553']
                        );
                    } else {
                        if ($images[$modelImage->id]) {
                            $modelImage->image = $images[$modelImage->id];
                        }
                    }
                }

                if (!empty($_FILES['Product']['name']['instruction'])) {
                    $model->instruction = UploadFile::upload(
                        $model,
                        Product::findOne($model->id),
                        'instruction',
                        'instruction',
                        []
                    );
                } else {
                    $model->instruction = $instruction;
                }

                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedFeatureValueIDs)) {
                            FeatureValue::deleteAll(['id' => $deletedFeatureValueIDs]);
                        }

                        if (! empty($deletedFeatureIDs)) {
                            Feature::deleteAll(['id' => $deletedFeatureIDs]);
                        }

                        if (! empty($deletedParamIDs)) {
                            ProductParam::deleteAll(['id' => $deletedParamIDs]);
                        }

                        foreach ($modelsFeature as $indexFeature => $modelFeature) {
                            $modelFeature->product_id = $model->id;

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

                        if (! empty($deletedImageIDs)) {
                            foreach(Image::findAll($deletedImageIDs) as $modelImage) {
                                //Удаляем старые изображения
                                $firstPartOfFilename = basename(explode('.', $modelImage->image)[0]);

                                $uploadPath = Yii::getAlias('@uploadPath');
                                $uploadPaths = glob($uploadPath . '/*');

                                foreach ($uploadPaths as $fileItem) {
                                    if (is_file($fileItem)) {
                                        if (strstr($fileItem, $firstPartOfFilename)) {
                                            unlink($fileItem);
                                        }
                                    }
                                }

                                $thumbsPath = Yii::getAlias('@thumbsPath');
                                $thumbsPaths = glob($thumbsPath . '/*');

                                foreach ($thumbsPaths as $fileItem) {
                                    if (is_file($fileItem)) {
                                        if (strstr($fileItem, $firstPartOfFilename)) {
                                            unlink($fileItem);
                                        }
                                    }
                                }
                                //Удаляем старые изображения END

                                $modelImage->delete();
                            }
                        }

                        if (!empty($deletedReviewIDs)) {
                            ProductReview::deleteAll(['id' => $deletedReviewIDs]);
                        }

                        foreach ($modelsImage as $modelImage) {
                            $modelImage->product_id = $model->id;

                            if (! ($flag = $modelImage->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsReview as $modelReview) {
                            $modelReview->product_id = $model->id;

                            if (! ($flag = $modelReview->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsParams as $modelParams) {
                            $modelParams->product_id = $model->id;

                            if (! ($flag = $modelParams->save(false))) {
                                $transaction->rollBack();
                                break;
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
            'modelsImage' => (empty($modelsImage)) ? [new Image] : $modelsImage,
            'modelsReview' => (empty($modelsReview)) ? [new ProductReview] : $modelsReview,
            'modelsParams' => (empty($modelsParams)) ? [new ProductParam] : $modelsParams,
            'modelsFeature' => (empty($modelsFeature)) ? [new Feature] : $modelsFeature,
            'modelsFeatureValue' => (empty($modelsFeatureValue[0])) ? [[new FeatureValue]] : $modelsFeatureValue
        ]);
    }
}
