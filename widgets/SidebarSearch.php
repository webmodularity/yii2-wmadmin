<?php

/** TODO: Needs form functionality */

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class SidebarSearch extends \yii\base\Widget
{
    public function run()
    {
        if (!Yii::$app->adminSettings->getOption('template.sidebar.search')) {
            return '';
        }
        return <<<'EOD'
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
EOD;

    }
}