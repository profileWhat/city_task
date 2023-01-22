<?php

use yii\helpers\Html;

$review = $this->context->review;
?>
<div class="card my-4">
    <div class="card-body">
        <div class="card-title">
            <h4>Title: <?= $review->title ?></h4>
            <h5>Author: <?= $review->getAuthorLink() ?></h5>
            <h5>
                Cities:
                <?php foreach ($review->getCitiesLink() as $link): ?>
                    <?= $link ?> ,
                <?php endforeach; ?>
            </h5>
            <h5>Rating: <?= $review->rating ?></h5>
            <?php if ($review->img != null): ?>
                <h5>Img: </h5>
                <?= Html::img('@web/img/reviews/' . $review->img, ['alt' => 'some', 'class' => 'thing', 'width' => '300', 'height' => '300']); ?>
            <?php endif; ?>
        </div>
        <div class="card-text">
            Content:
            <br>
            <?= $review->text ?>
            <hr class="hr hr-blurry"/>
            Created at: <?= date('F j, Y \a\t h:i a', $review->create_time); ?>
        </div>
    </div>
</div>