<?php
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
        </div>
        <div class="card-text">
            <?= $review->text ?>
            <hr class="hr hr-blurry"/>
            Created at: <?= date('F j, Y \a\t h:i a', $review->create_time); ?>
        </div>
    </div>
</div>