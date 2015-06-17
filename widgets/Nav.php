<?php

namespace wma\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use wmc\models\Menu;


class Nav extends \wmc\widgets\menu\NestedList
{
    public $menuName = 'wma-nav';

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
        $this->currentId = Menu::find()->select(['id'])->where($where)->scalar();
    }

    public function run() {
        return Html::tag('nav', parent::run()) . Html::tag('span', Html::tag('i', '', ['class' => 'fa fa-arrow-circle-left hit']), ['class' => 'minifyme', 'data-action' => 'minifyMenu']);
    }

    protected function buildItem($item, $index, $nested = false, $hasChildren  = false) {
        if ($item->type == Menu::TYPE_DIVIDER) {
            // No support for divider type
            throw new InvalidConfigException("No support for divider type in wma-nav menu!");
        }

        $link = $hasChildren === true || $item->type == Menu::TYPE_HEADER ? "#" : $item->link;
        $linkContent = $nested === false ? Html::tag('span', $item->name, ['class' => 'menu-item-parent']) : $item->name;
        return Html::a(static::iconTag($item->icon, $this->menu->icon, true, 'lg') . $linkContent, $link, ['title' => $item->name]);
    }

}