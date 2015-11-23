<?php

namespace wma\widgets;

use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use wmc\models\Menu;


class SidebarMenu extends \wmc\widgets\menu\NestedList
{
    public $menuName = 'wma-nav';
    public $listOptions = ['class' => 'sidebar-menu'];
    public $listNestedOptions = ['class' => 'treeview-menu'];

    protected $_activeHeaderIds = [];

    public function init() {
        parent::init();
        if (isset($this->view->params['wma-nav'])) {
            if (is_int($this->view->params['wma-nav']) && $this->view->params['wma-nav'] > 0) {
                // ID Specified
                $this->currentId = $this->view->params['wma-nav'];
            } else {
                if (is_string($this->view->params['wma-nav']) && !empty($this->view->params['wma-nav'])) {
                    // Name Specified
                    $this->setCurrentId($this->view->params['wma-nav']);
                } else if (is_array($this->view->params['wma-nav']) && !empty($this->view->params['wma-nav'])) {
                    // Name and Link specified
                    $link = null;
                    if (isset($this->view->params['wma-nav']['name']) && isset($this->view->params['wma-nav']['link'])) {
                        $name = $this->view->params['wma-nav']['name'];
                        $link = $this->view->params['wma-nav']['link'];
                    } else if (isset($this->view->params['wma-nav']['name'])) {
                        $name = $this->view->params['wma-nav']['name'];
                    } else {
                        $name = array_shift($this->view->params['wma-nav']);
                        if (count($this->view->params['wma-nav']) > 0) {
                            $link = array_shift($this->view->params['wma-nav']);
                        }
                    }
                    if (!empty($name)) {
                        $this->setCurrentId($name, $link);
                    }
                }
            }
        }
    }

    protected function setCurrentId($name, $link = null) {
        $where = ['name' => $name, 'tree_id' => $this->menu->id];
        if (!empty($link)) {
            $where['link'] = $link;
        }
        $currentMenu = Menu::find()->where($where)->one();
        if (!is_null($currentMenu)) {
            $this->currentId = $currentMenu->id;
            $parents = $currentMenu->parents()->andWhere(['!=', 'depth', 0])->all();
            foreach ($parents as $p) {
                $this->_activeHeaderIds[] = $p->id;
            }
        }
    }

    public function run() {
        return parent::run();
    }

    protected function buildItem($item, $index, $nested = false, $hasChildren  = false) {
        if ($item->type == Menu::TYPE_DIVIDER) {
            // No support for divider type
            throw new InvalidConfigException("No support for divider type in wma-nav menu!");
        }

        $link = $hasChildren === true || $item->type == Menu::TYPE_HEADER ? "#" : $item->link;
        $linkContent = $nested === false ? Html::tag('span', $item->name) : $item->name;
        $linkExpand = $hasChildren ? FA::icon('angle-left', ['class' => 'pull-right']) : '';
        $icon = $nested === true ? 'circle-o' : $item->icon;
        return Html::a(static::iconTag($icon, $this->menu->icon) . $linkContent . $linkExpand, $link, ['title' => $item->name]);
    }

    public function listItemCallable($item, $index, $nested) {
        $list = $item['list'];
        $item = $item['item'];
        $hasChildren = is_null($list) ? false : true;
        $listItemOptions = $nested === false ? $this->listItemOptions : $this->listItemNestedOptions;
        if ($this->currentId == $item->id) {
            Html::addCssClass($listItemOptions, "active");
        }
        if ($item->type == Menu::TYPE_HEADER) {
            Html::addCssClass($listItemOptions, "treeview");
            if (in_array($item->id, $this->_activeHeaderIds)) {
                Html::addCssClass($listItemOptions, "active");
            }
        }
        return Html::tag('li', $this->buildItem($item, $index, $nested, $hasChildren) . $list, $listItemOptions);
    }

}