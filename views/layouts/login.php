<?php

use yii\helpers\Html;
use wma\widgets\Logo;
use wma\web\AdminAsset;
use wma\web\AdminIE8Asset;
use wma\web\AdminWMAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
AdminIE8Asset::register($this);
AdminWMAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">

<?php $this->beginBody() ?>

<div class="login-box">
    <?= Logo::widget(['useMini' => false]) ?>
    <div class="login-box-body">
        <?= Yii::$app->alertManager->get() ?>
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>