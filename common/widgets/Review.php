<?php

namespace common\widgets;

use yii\jui\Widget;

class Review extends Widget
{
    public $review;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('_review', ['review' => $this->review]);
    }
}