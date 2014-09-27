<?php
use wmc\helpers\Html;
use wma\assets\AdminAsset;
use wma\widgets\LogoImage;
use wma\widgets\LoginRegisterButton;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
$assetUrl = \wma\Module::getInstance()->assetUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" id="extr-page">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="<?= $assetUrl ?>/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $assetUrl ?>/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?= $assetUrl ?>/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $assetUrl ?>/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $assetUrl ?>/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $assetUrl ?>/splash/touch-icon-ipad-retina.png">
    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="<?= $assetUrl ?>/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="<?= $assetUrl ?>/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="<?= $assetUrl ?>/splash/iphone.png" media="screen and (max-device-width: 320px)">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="animated fadeInDown">
<?php $this->beginBody() ?>
<header id="header">
    <div id="logo-group">
        <?= LogoImage::widget() ?>
    </div>
    <?= LoginRegisterButton::widget() ?>
</header>

<div id="main" role="main">
    <!-- MAIN CONTENT -->
    <div id="content" class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <div class="well no-padding">
                    <?= $content ?>
                </div>
                <p class="text-center">&copy;2014 WebModularity</p>
            </div>
        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>