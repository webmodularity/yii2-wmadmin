<?php

/**
 * Needs functionality, currently displays dummy content
 */

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class UserShortcuts extends \yii\base\Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        return <<<EOD
		<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
		Note: These tiles are completely responsive,
		you can add as many as you like
		-->
		<div id="shortcut">
			<ul>
				<li>
					<a href="/user/logout" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-sign-out fa-4x"></i> <span>Logout</span> </span> </a>
				</li>
			</ul>
		</div>
		<!-- END SHORTCUT AREA -->
EOD;
    }

}