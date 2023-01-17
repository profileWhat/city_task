<?php

/** @var yii\web\View $this */

/** @var frontend\models\UserCityForm $userCityModel */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulate!</h1>
            <p class="fs-5 fw-light">You have successfully entered the site with reviews of cities</p>
        </div>
    </div>

    <div class="body-content">
        <?php if ($userCityModel->getUserCity() != null): ?>
            <?= $this->render('_userCity', ['model' => $userCityModel]); ?>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-6 d-grid gap-2">
                <?= Html::a('Show cities', ['city/index'], ['class' => 'btn btn-success btn-lg my-3 p-4 g-4 text-center']) ?>
            </div>
        </div>
    </div>
</div>
