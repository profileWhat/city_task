<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\City $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="city-view">

    <h1 class="container border-secondary border rounded p-3 text-center">City <?= $model->name ?></h1>

    <h2 class="container p-3">All Reviews:</h2>
    <?= $this->render('_reviews', ['reviews' => $model->reviews])?>

</div>
