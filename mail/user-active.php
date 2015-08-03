<?php
use yii\helpers\Html;

$this->title = "Account Active";
?>
<?= $user->person->fullName ?>,
<p>The user account associated with <?= $user->email ?> has been activated. You can now
    <?= Html::a('Log In', Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/login'])) ?> to the site.
    If you misplace your password you can always use our
    <?= Html::a('Password Recovery Tool', Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/forgot-password'])) ?>
    to reset it.</p>

<p>If you have any questions please feel free to <?= Html::a('Contact Us', Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/contact'])) ?>.</p>

<p>Thanks,<br /><?= Yii::$app->params['siteName'] ?></p>