<?php
/** @var common\models\User $model */

use common\widgets\Review;
use yii\helpers\Html;

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2 class="container p-4 border-secondary border rounded ">Author: <?= $model->fio ?></h2>

<?php foreach ($model->reviews as $review): ?>
    <?= Review::widget(['review' => $review]) ?>
<?php endforeach; ?>
