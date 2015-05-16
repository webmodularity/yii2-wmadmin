<?php
use wmc\helpers\Html;
use wma\web\AdminAsset;
use wma\widgets\BodyTag;
use wma\widgets\FavIcon;
use wma\widgets\LogoImage;
use wma\widgets\LoggedInUser;
use wma\widgets\UserShortcuts;
use wma\widgets\NotificationButton;
use wma\widgets\HeaderDropdown;
use wma\widgets\HeaderNavigation;
use wma\widgets\Nav;
use wma\widgets\Footer;
use rmrevin\yii\fontawesome\FA;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
$this->registerJs("pageSetUp();");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
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
    <?= BodyTag::Widget()?>
        <?php $this->beginBody() ?>

        <header id="header">
            <div id="logo-group">
                <?= LogoImage::widget() ?>
                <?= NotificationButton::widget() ?>
            </div>

            <?= HeaderDropdown::widget() ?>
            <?= HeaderNavigation::widget() ?>
        </header>

        <aside id="left-panel">
            <?= LoggedInUser::widget(['displayName' => 'full_name']) ?>
            <?= Nav::widget() ?>
        </aside>

        <div id="main" role="main">
            <?= $content ?>
        </div>

        <?= Footer::widget() ?>
        <?= UserShortcuts::widget() ?>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>