<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */


?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->email) ?>,</p>

    <p>confirm the email by entering the control line on the website</p>

    <p>Control line:<?= $user->getVerificationToken() ?></p>

</div>
