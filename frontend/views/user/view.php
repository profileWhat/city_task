<?php

use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-view container p-3">
    <div class="card container p-3">
        <h2 class="card-title"><?= $model->fio ?></h2>
        <hr class="hr hr-blurry"/>
        <div class="card-text">
            Email: <?= $model->email ?>
            <hr class="hr hr-blurry"/>
            Phone: <?= $model->phone ?>
            <hr class="hr hr-blurry"/>
            <?= Html::a('All reviews', ['reviews', 'id' => $model->id]) ?>
        </div>
    </div>
</div>
