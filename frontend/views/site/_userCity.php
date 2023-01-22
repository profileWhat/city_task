<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserCityForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="row justify-content-center bg-light border rounded border-secondary g-3 p-3 my-3 text-center">
        <div class="col-4">
            <?php if (Yii::$app->session->get('userCity') != $model->getUserCity()->name): ?>
                <h3>Is your city: <?= Html::encode($model->getUserCityName()) ?> ?</h3>

                <div class="form-group">
                    <?= Html::a('Yes', ['city/view', 'id' => $model->getUserCity()->id, 'isUserCity' => true], ['class' => 'btn btn-primary my-3']) ?>
                    <?= Html::a('No', ['city/index'], ['class' => 'btn btn-default my-3']) ?>
                </div>
            <?php else: ?>
                <h3>Show your city reviews: </h3>

                <div class="form-group">
                    <?= Html::a('Yes', ['city/view', 'id' => $model->getUserCity()->id], ['class' => 'btn btn-primary my-3']) ?>
                    <?= Html::a('No', ['city/index'], ['class' => 'btn btn-default my-3']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
