<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\ProductCaching;
use backend\models\Sitemap;
use backend\models\UML;
use backend\models\UploadFile;
use backend\models\UploadFileDynamicForm;
use common\models\Category;
use common\models\Feature;
use common\models\FeatureValue;
use common\models\FilterFeature;
use common\models\FilterFeatureValue;
use common\models\Image;
use common\models\Product;
use common\models\ProductHasFilterFeatureValue;
use common\models\ProductParam;
use common\models\ProductReview;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
* This is the class for controller "ProductController".
*/
class ProductController extends \backend\controllers\base\ProductController
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
        $model = new Product;
        $modelsReview = [new ProductReview];
        $modelsImage = [new Image];
        $modelsParams = [new ProductParam];
        $modelsImage[0]->scenario = 'create';
        $model->hit = 0;
        $model->disallow_xml = 0;
        $modelsFeature = [new Feature];
        $modelsFeatureValue = [[new FeatureValue]];
        $uploadedCustom = new UploadFile(true, 95);

        if ($model->load(Yii::$app->request->post())) {
            $model->generateCode();

            $modelsImage = Model::createMultiple(Image::classname());
            Model::loadMultiple($modelsImage, Yii::$app->request->post());
            $modelsReview = Model::createMultiple(ProductReview::classname());
            Model::loadMultiple($modelsReview, Yii::$app->request->post());
            $modelsFeature = Model::createMultiple(Feature::classname());
            Model::loadMultiple($modelsFeature, Yii::$app->request->post());
            $modelsParams = Model::createMultiple(ProductParam::classname());
            Model::loadMultiple($modelsParams, Yii::$app->request->post());

            $model->instruction = UploadedFile::getInstance($model, "instruction");

            foreach($modelsImage as $index => $modelImage) {
                $modelImage->image = UploadedFile::getInstance($modelImage, "[{$index}]image");
                $modelImage->scenario = 'create';
            }

            if (!empty($_FILES['Product']['name']['present_image'])) {
                $model->present_image = $uploadedCustom->uploadFile(
                    $model,
                    'present_image',
                    'present_image',
                    ['39x50']
                );
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

                $model->instruction = $uploadedCustom->uploadFile(
                    $model,
                    Product::findOne($model->id),
                    'instruction',
                    'instruction',
                    []
                );

                foreach($modelsImage as $index => $modelImage) {
                    $modelImage->image = $uploadedCustom->uploadFileDynamicForm(
                        $modelImage,
                        $index,
                        "[{$index}]image",
                        "[{$index}]image",
                        ['770x553', '350x300']
                    );
                }

                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        //////////////////////////////////////////////////////////////////////////////
                        if (!empty($_POST['Product']['FilterFeature'])) {
                            foreach($_POST['Product']['FilterFeature'] as $item) {
                                $filter_feature = FilterFeature::findOne($item['id']);
                                $a1 = ProductHasFilterFeatureValue::findAll(['product_id' => $model->id]);
                                $a2 = FilterFeatureValue::find()
                                    ->where([
                                        'id' => ArrayHelper::map($a1, 'filter_feature_value_id', 'filter_feature_value_id'),
                                        'filter_feature_id' => $filter_feature->id,
                                    ])
                                    ->orderBy(['name' => SORT_ASC])
                                    ->all();
                                $alreadyHereValues = ArrayHelper::map($a2, 'name', 'name');

                                if (isset($item['values']) && !empty($item['values'])) {
                                    foreach($item['values'] as $index => $valueName) {
                                        $here = FilterFeatureValue::find()
                                            ->where([
                                                'name' => $valueName,
                                                'filter_feature_id' => $filter_feature->id
                                            ])->one();

                                        if (!$here) {
                                            $filter_feature_value = new FilterFeatureValue;
                                            $filter_feature_value->name = $valueName;
                                            $filter_feature_value->filter_feature_id = $filter_feature->id;

                                            if ($filter_feature_value->save()) {
                                                $product_has_filter_feature_value = new ProductHasFilterFeatureValue;
                                                $product_has_filter_feature_value->product_id = $model->id;
                                                $product_has_filter_feature_value->filter_feature_value_id = $filter_feature_value->id;
                                                $product_has_filter_feature_value->save();
                                            }
                                        } else {
                                            if (!ProductHasFilterFeatureValue::findOne([
                                                'product_id' => $model->id,
                                                'filter_feature_value_id' => $here->id
                                            ])) {
                                                $product_has_filter_feature_value = new ProductHasFilterFeatureValue;
                                                $product_has_filter_feature_value->product_id = $model->id;
                                                $product_has_filter_feature_value->filter_feature_value_id = $here->id;
                                                $product_has_filter_feature_value->save();
                                            }
                                        }

                                        unset($alreadyHereValues[$valueName]);
                                    }

                                    if (!empty($alreadyHereValues)) {
                                        foreach($alreadyHereValues as $value) {
                                            $fv = FilterFeatureValue::find()
                                                ->where([
                                                    'name' => $value,
                                                    'filter_feature_id' => $filter_feature->id
                                                ])->one();
                                            ProductHasFilterFeatureValue::findOne([
                                                'product_id' => $model->id,
                                                'filter_feature_value_id' => $fv->id
                                            ])->delete();

                                            if (!ProductHasFilterFeatureValue::findOne([
                                                'filter_feature_value_id' => $fv->id
                                            ]   )) {
                                                $fv->delete();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //////////////////////////////////////////////////////////////////////////////
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
                                ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
                                ->all();

                            if ($categoryFeatures) {
                                foreach($categoryFeatures as $categoryFeature) {
                                    $feature = new Feature();
                                    $feature->header = $categoryFeature->header;
                                    $feature->product_id = $model->id;
                                    $feature->sort_order = $categoryFeature->sort_order;
                                    $feature->save();

                                    $categoryFeatureValues = FeatureValue::find()
                                        ->where(['feature_id' => $categoryFeature->id])
                                        ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
                                        ->all();

                                    if ($categoryFeatureValues) {
                                        foreach($categoryFeatureValues as $categoryFeatureValue) {
                                            $featureValue = new FeatureValue();
                                            $featureValue->name = $categoryFeatureValue->name;
                                            $featureValue->value = $categoryFeatureValue->value;
                                            $featureValue->feature_id = $feature->id;
                                            $featureValue->sort_order = $categoryFeatureValue->sort_order;
                                            $featureValue->save();
                                        }
                                    }
                                }
                            }
                        }
                        //Заполняем предзаполненные характеристики из категории для товара END

                        $transaction->commit();
                        Yii::$app->queue_default->push(new Sitemap());
                        Yii::$app->queue_default->push(new UML());
                        Yii::$app->queue_default->push(new ProductCaching([
                            'product_id' => $model->id
                        ]));

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
        $present_image = $model->present_image;
        $uploadedCustom = new UploadFile(true, 95);

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

            if (!empty($_FILES['Product']['name']['present_image'])) {
                $model->present_image = $uploadedCustom->uploadFile(
                    $model,
                    'present_image',
                    'present_image',
                    ['39x50']
                );
            } else {
                $model->present_image = $present_image;
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
                        $modelImage->image = $uploadedCustom->uploadFileDynamicForm(
                            $modelImage,
                            $index,
                            "[{$index}]image",
                            "[{$index}]image",
                            ['770x553', '350x300']
                        );
                    } else {
                        if ($images[$modelImage->id]) {
                            $modelImage->image = $images[$modelImage->id];
                        }
                    }
                }

                if (!empty($_FILES['Product']['name']['instruction'])) {
                    $model->instruction = $uploadedCustom->uploadFile(
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
                $model->updated_at = time();

                try {
                    if ($flag = $model->save(false)) {
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                        if (!empty($_POST['Product']['FilterFeature'])) {
                            foreach($_POST['Product']['FilterFeature'] as $item) {
                                $filter_feature = FilterFeature::findOne($item['id']);
                                $a1 = ProductHasFilterFeatureValue::findAll(['product_id' => $model->id]);
                                $a2 = FilterFeatureValue::find()
                                    ->where([
                                        'id' => ArrayHelper::map($a1, 'filter_feature_value_id', 'filter_feature_value_id'),
                                        'filter_feature_id' => $filter_feature->id,
                                    ])
                                    ->orderBy(['name' => SORT_ASC])
                                    ->all();
                                $alreadyHereValues = ArrayHelper::map($a2, 'name', 'name');

                                if (isset($item['values']) && !empty($item['values'])) {
                                    foreach($item['values'] as $index => $valueName) {
                                        $here = FilterFeatureValue::find()
                                            ->where([
                                                'name' => $valueName,
                                                'filter_feature_id' => $filter_feature->id
                                            ])->one();

                                        if (!$here) {
                                            $filter_feature_value = new FilterFeatureValue;
                                            $filter_feature_value->name = $valueName;
                                            $filter_feature_value->filter_feature_id = $filter_feature->id;

                                            if ($filter_feature_value->save()) {
                                                $product_has_filter_feature_value = new ProductHasFilterFeatureValue;
                                                $product_has_filter_feature_value->product_id = $model->id;
                                                $product_has_filter_feature_value->filter_feature_value_id = $filter_feature_value->id;
                                                $product_has_filter_feature_value->save();
                                            }
                                        } else {
                                            if (!ProductHasFilterFeatureValue::findOne([
                                                'product_id' => $model->id,
                                                'filter_feature_value_id' => $here->id
                                            ])) {
                                                $product_has_filter_feature_value = new ProductHasFilterFeatureValue;
                                                $product_has_filter_feature_value->product_id = $model->id;
                                                $product_has_filter_feature_value->filter_feature_value_id = $here->id;
                                                $product_has_filter_feature_value->save();
                                            }
                                        }

                                        unset($alreadyHereValues[$valueName]);
                                    }

                                    if (!empty($alreadyHereValues)) {
                                        foreach($alreadyHereValues as $value) {
                                            $fv = FilterFeatureValue::find()
                                                ->where([
                                                    'name' => $value,
                                                    'filter_feature_id' => $filter_feature->id
                                                ])->one();
                                            ProductHasFilterFeatureValue::findOne([
                                                'product_id' => $model->id,
                                                'filter_feature_value_id' => $fv->id
                                            ])->delete();

                                            if (!ProductHasFilterFeatureValue::findOne([
                                                'filter_feature_value_id' => $fv->id
                                            ]   )) {
                                                $fv->delete();
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        /*echo '<pre>',print_r($_POST),'</pre>';
                        die();*/
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////

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

                        if (!empty($deletedImageIDs)) {
                            foreach(Image::findAll($deletedImageIDs) as $modelImage) {
                                //Удаляем старые изображения
                                if (!empty($modelImage->image)) {
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
                        $model->saveBrothers();
                        Yii::$app->queue_default->push(new Sitemap());
                        Yii::$app->queue_default->push(new UML());
                        Yii::$app->queue_default->push(new ProductCaching([
                            'product_id' => $model->id
                        ]));

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

    public function actionClone($id) {
        $product = Product::findOne($id);
        $clonedProduct = new Product();
        $clonedProduct->setAttributes($product->attributes);
        $clonedProduct->id = null;
        $clonedProduct->alias = $product->alias.'-'.time();
        $clonedProduct->generateCode();

        $clonedProduct->brothers_ids[] = $product->id;

        foreach($product->getBrothers() as $productProduct) {
            $clonedProduct->brothers_ids[] = $productProduct['product_id'];
            $clonedProduct->brothers_ids[] = $productProduct['product_brother_id'];
        }

        $clonedProduct->save();
        $clonedProduct->saveBrothers();
        $clonedProduct->brothers_ids[] = $clonedProduct->id;

        foreach($product->reviews as $review) {
            $clonedReview = new ProductReview();
            $clonedReview->setAttributes($review->attributes);
            $clonedReview->id = null;
            $clonedReview->product_id = $clonedProduct->id;
            $clonedReview->save();
        }

        foreach($product->params as $param) {
            $clonedParam = new ProductParam();
            $clonedParam->setAttributes($param->attributes);
            $clonedParam->id = null;
            $clonedParam->product_id = $clonedProduct->id;
            $clonedParam->artikul = (string) time();
            $clonedParam->save();
        }

        foreach($product->features as $feature) {
            $clonedFeature = new Feature();
            $clonedFeature->setAttributes($feature->attributes);
            $clonedFeature->id = null;
            $clonedFeature->product_id = $clonedProduct->id;
            $clonedFeature->save();

            foreach($feature->featurevalues as $featurevalue) {
                $clonedFeatureValue = new FeatureValue();
                $clonedFeatureValue->setAttributes($featurevalue->attributes);
                $clonedFeatureValue->id = null;
                $clonedFeatureValue->feature_id = $clonedFeature->id;
                $clonedFeatureValue->save();
            }
        }

        foreach($product->productHasFilterFeatureValue as $productHasFilterFeatureValue) {
            $clonedProductHasFilterFeatureValue = new ProductHasFilterFeatureValue();
            $clonedProductHasFilterFeatureValue->setAttributes($productHasFilterFeatureValue->attributes);
            $clonedProductHasFilterFeatureValue->id = null;
            $clonedProductHasFilterFeatureValue->product_id = $clonedProduct->id;
            $clonedProductHasFilterFeatureValue->save();
        }

        return $this->redirect(['update', 'id' => $clonedProduct->id]);
    }
}
