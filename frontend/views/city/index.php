<?php

use common\models\City;
use common\models\CitySearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var CitySearch $searchModel */

$this->title = 'Cities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?php foreach ($dataProvider->getModels() as $city): ?>
        <h4 class="container border-secondary border rounded my-4 p-3 ">
            <?= Html::a($city->name, $city->getUrl()) ?>
        </h4>
    <?php endforeach; ?>
</div>
