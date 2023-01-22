<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AddCityForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Add city';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">

    <?php $form = ActiveForm::begin() ?>
    <div class="row justify-content-center bg-light border rounded border-secondary g-3 p-3 my-3 text-center">
        <div class="col-4">
            <h3>Input your city</h3>

            <?= $form->field($model, 'cityName')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Add City', ['class' => 'btn btn-primary my-3']) ?>
            </div>
        </div>
    </div>

    <?php $form = ActiveForm::end() ?>
</div>


