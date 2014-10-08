<?php
use wmc\helpers\Html;
use wma\assets\AdminAsset;
use wma\widgets\LogoImage;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" id="extr-page">
    <?= $this->render('_head'); ?>
    <body class="animated fadeInDown">
    <?php $this->beginBody() ?>
    <header id="header">
        <div id="logo-group">
            <?= LogoImage::widget() ?>
        </div>
    </header>

    <div id="main" role="main">
        <!-- MAIN CONTENT -->
        <div id="content" class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                    <?= $content ?>
                </div>
            </div>
        </div>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>