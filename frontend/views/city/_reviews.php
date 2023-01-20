<?php
/** @var common\models\Review[] $reviews */

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach ($reviews as $review): ?>
    <?= \common\widgets\Review::widget(['review' => $review]) ?>
<?php endforeach; ?>

