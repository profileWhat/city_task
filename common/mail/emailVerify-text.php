<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
Hello <?= $user->email ?>,

Confirm the email by entering the control line on the website

Control line:
<?= $user->getVerificationToken() ?>

