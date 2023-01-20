<?php

use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Review $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="review-view" id="review-view" data-id="<?= $model->id ?>">

    <?= \common\widgets\Review::widget(['review' => $model]) ?>

</div>
