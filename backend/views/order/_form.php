<?php

use kartik\checkbox\CheckboxX;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Order $model
* @var yii\widgets\ActiveForm $form
*/
$productCost = 0;
$serviceCost = 0;
$products = unserialize(base64_decode($model->products));

foreach($products as $md5Id => $product) {
    $productCost += $product->getQuantity() * $product->price;

    if ($product->build_cost) {
        $serviceCost += $product->getQuantity() * $product->build_cost;
    }

    if ($product->waranty_cost) {
        $serviceCost += $product->getQuantity() * $product->waranty_cost;
    }
}

?>

<?= Html::a('На страницу заказа', '/cart/success/'.$model->md5Id, [
    'class' => 'btn btn-success',
    'target' => '_blank'
]) ?>
<br>
<br>
<br>
<div class="order-form">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Стоимость товаров</span>
                    <span class="info-box-number"><?=number_format($productCost, 0, '', ' ')?> <small>P</small></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Стоимость услуг</span>
                    <span class="info-box-number"><?=number_format($serviceCost, 0, '', ' ')?> <small>P</small></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Общая стоимость</span>
                    <span class="info-box-number"><?=number_format($model->total_cost + $serviceCost, 0, '', ' ')?> <small>P</small></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Общая стоимость<br> со скидкой</span>
                    <span class="info-box-number"><?=number_format($model->costWithDiscount(), 0, '', ' ')?> <small>P</small></span>
                </div>
            </div>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
    'id' => 'Order',
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!-- attribute phone -->
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

<!-- attribute email -->
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?=
            $form->field($model, 'payment')
                ->radioList(Yii::$app->params['payments'])
            ?>
            <?=
            $form->field($model, 'status')
                ->radioList(Yii::$app->params['orderStatuses'])
            ?>

<!-- attribute shipaddress -->
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

<!-- attribute comment -->
			<?= $form->field($model, 'comm')->textarea(['maxlength' => true]) ?>

			<?= $form->field($model, 'total_cost')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'discount')->textInput(['maxlength' => true])->label('Скидка(200 или 10%)') ?>

            <?= $form->field($model, 'paid')->widget(CheckboxX::classname(), [
                'pluginOptions' => [
                    'threeState'=>false
                ]
            ])?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Order'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?= Html::a('Добавить товар', ['order/product-add', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

        <?=$this->render('_products', ['order' => $model])?>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Создать' : 'Сохранить Заказ'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

