<?php

/**
 * Needs functionality, currently displays dummy content
 */

namespace wma\widgets;

use Yii;

class NotificationButton extends \yii\base\Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        if (Yii::$app->adminSettings->getOption('template.notificationButton') === true) {
            return <<<EOD
            <!-- AJAX NOTIFICATION WINDOW -->
            <!-- NEEDS BACKEND FUNCTIONALITY DEV -->
            <span id="activity" class="activity-dropdown"> <i class='fa fa-user'></i> <b class="badge"> 0 </b> </span>

            <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
            <div class="ajax-dropdown">

                <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="ajax/notify/mail.html">Msgs (14)
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="ajax/notify/notifications.html">notify (3)
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="ajax/notify/tasks.html">Tasks (4)
                    </label>
                </div>

                <!-- notification content -->
                <div class="ajax-notifications custom-scroll">

                    <div class="alert alert-transparent">
                        <h4>Click a button to show messages here</h4>
                        This blank page message helps protect your privacy, or you can show the first message here automatically.
                    </div>

                    <i class="fa fa-lock fa-4x fa-border"></i>

                </div>
                <!-- end notification content -->

                <!-- footer: refresh area -->
                <span> Last updated on: 12/12/2013 9:43AM
                    <button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
                        <i class="fa fa-refresh"></i>
                    </button>
                </span>
                <!-- end footer -->

            </div>
            <!-- END AJAX-DROPDOWN -->
EOD;
        }
    }
}