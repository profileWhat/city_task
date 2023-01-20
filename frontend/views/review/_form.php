<?php

use common\models\City;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ReviewForm $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'review-create-form']
    ]); ?>



    <div class="card my-4">
        <div class="card-body">
            <div class="card-title">
                <h4><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></h4>
                <h5>
                    <?= $form->field($model, 'citiesId')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(City::find()->all(), 'id','name'),
                        'options' => ['placeholder' => 'Select a city ...', 'value' => $model->cities],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]);
                    ?>
                </h5>
                <h5><?= $form->field($model, 'rating')->textInput() ?></h5>
                <h5><?= $form->field($model, 'img')->fileInput() ?></h5>
            </div>
            <div class="card-text">
                <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->getReview()->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
