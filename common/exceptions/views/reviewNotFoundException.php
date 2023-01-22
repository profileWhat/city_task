<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            Return to the main page: <?= Html::a("home", Url::to([Yii::$app->homeUrl]))?>
        </p>

    </div>
<?php $this->endContent(); ?>