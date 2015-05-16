<?php
use wmc\helpers\Html;
use wma\web\AdminAsset;
use wma\widgets\LogoImage;
use wma\widgets\LoginRegisterButton;
use wma\widgets\FavIcon;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"  id="extr-page">
    <head>
        <?php $this->registerMetaTag(['charset' => Yii::$app->charset]) ?>
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no']) ?>
        <?php $this->registerMetaTag(['name' => 'apple-mobile-web-app-capable', 'content' => 'yes']) ?>
        <?php $this->registerMetaTag(['name' => 'apple-mobile-web-app-status-bar-style', 'content' => 'black']) ?>
        <?= FavIcon::Widget()?>
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
                <?= Yii::$app->alertManager->render() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <div class="well no-padding">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>