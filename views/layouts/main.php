<?php

use yii\helpers\Html;
use wma\web\AdminAsset;
use wma\web\AdminIE8Asset;
use wma\web\AdminWMAsset;
use wma\widgets\BodyTag;
use wma\widgets\Header;
use wma\widgets\Sidebar;
use wma\widgets\ContentHeader;
use wma\widgets\Footer;

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
    <?= BodyTag::widget() ?>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <?= Header::widget() ?>
        <?= Sidebar::widget() ?>
        <div class="content-wrapper">
            <?= ContentHeader::widget() ?>
                <section class="content">
                    <?= $content ?>
                </section>
        </div>
        <?= Footer::widget() ?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>