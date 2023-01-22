<?php
/** @var common\models\Review[] $reviews */

use common\widgets\Review;

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach ($reviews as $review): ?>
    <?= Review::widget(['review' => $review]) ?>
<?php endforeach; ?>

