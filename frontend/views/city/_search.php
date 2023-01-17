<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary my-3']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
