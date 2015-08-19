<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\Alert;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use yii\helpers\Html;

$this->title = 'Dashboard';
$this->params['wma-nav'] = "Dashboard";
?>
<?= Ribbon::widget(['links' => ['Dashboard']]) ?>

<?php ContentContainer::begin() ?>

    <?= PageTitle::widget(['subTitle' => 'My Dashboard', 'icon' => 'home']) ?>

<div class="well">
    <div class="row">
        <div class="col-md-4">
            <?= Html::img(Yii::$app->adminAssetUrl.'/img/server-maintenance.jpg', ['class' => "img-responsive", 'alt' => "Server Maintenance"]) ?>
            <ul class="list-inline padding-10">
                <li>
                    <i class="fa fa-calendar"></i>
                    <a href="javascript:void(0);"> August 03, 2015 </a>
                </li>
            </ul>
        </div>
        <div class="col-md-8 padding-left-0">
            <h3 class="margin-top-0"><a href="javascript:void(0);"> Server Maintenance - <s>Friday August 7th</s> Monday August 10th </a><br><small class="font-xs"><i>Published by <a href="mailto:rory@webmodularity.com">Rory</a></i></small></h3>
            <p>We will be taking the servers offline on <s>Friday August 7th</s> Monday August 10th at 10pm PDT. The expected downtime is 8 hours. Servers expected to be back online on <s>Saturday August 8th </s> Tuesday August 11th at 6am PDT.</p>
            <p>We will be adding additional user functionality as well as publishing some bug fixes. All services will be unavailable during this time.</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <?= Html::img(Yii::$app->adminAssetUrl.'/img/server-maintenance.jpg', ['class' => "img-responsive", 'alt' => "Server Maintenance"]) ?>
            <ul class="list-inline padding-10">
                <li>
                    <i class="fa fa-calendar"></i>
                    <a href="javascript:void(0);"> June 23, 2015 </a>
                </li>
            </ul>
        </div>
        <div class="col-md-8 padding-left-0">
            <h3 class="margin-top-0"><a href="javascript:void(0);"> Server Maintenance - Monday June 29th </a><br><small class="font-xs"><i>Published by <a href="mailto:rory@webmodularity.com">Rory</a></i></small></h3>
            <p>We will be taking the servers offline on Monday June 29th at 10pm PDT. The expected downtime is 8 hours. Servers expected to be back online on Tuesday June 30th at 6am PDT.</p>
            <p>We will be addressing several CMS bugs as well as continuing to roll out more CMS features. All services will be unavailable during this time.</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <?= Html::img(Yii::$app->adminAssetUrl.'/img/cms.jpg', ['class' => "img-responsive", 'alt' => "CMS v2"]) ?>
            <ul class="list-inline padding-10">
                <li>
                    <i class="fa fa-calendar"></i>
                    <a href="javascript:void(0);"> June 17, 2015 </a>
                </li>
            </ul>
        </div>
        <div class="col-md-8 padding-left-0">
            <h3 class="margin-top-0"><a href="javascript:void(0);"> CMS v2 is now live! </a><br><small class="font-xs"><i>Published by <a href="mailto:rory@webmodularity.com">Rory</a></i></small></h3>
            <p>The new CMS system will allow you to control your website content from one centralized system. Any website administration that was done on the frontend has been disabled and will be redirected here.</p>
            <p>Sites that were using frontend admin tools may find some admin functionality missing for the time being. We have to manually convert that functionality on a site by site basis (which we are currently hard at work getting done).
                Sites that are converting from CMS v1 will see the same menu links (and functionality) in CMS v2.</p>
            <p>We have added quite a bit of UI functionality to this release which is now wrapped in a fully responsive design. You can now admin your website via a mobile device just as you would on your desktop/laptop!</p>
            <p>We still have some areas that are under construction (Search Site, User Icons, etc.) and will be patching more functionality in for the next several weeks. However all changes made in the CMS will be applied to your website and those future patches will <em>NOT</em> result in any data loss or rollbacks.</p>
            <p>Thanks for your patience as we work through this transition and please feel free to <a href="mailto:rory@webmodularity.com">contact me</a> with any issues or concerns.</p>
        </div>
    </div>
</div>

<?php ContentContainer::end() ?>