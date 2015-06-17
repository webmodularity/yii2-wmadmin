<?php

namespace wma\widgets;

use yii\helpers\Url;
use yii\helpers\Html;
use wmc\models\Menu;

class NestedList extends \wmc\widgets\menu\NestedList
{
    protected function buildItem($item, $index, $nested) {
        $link = Url::to(['update-item', 'id' => $item->id]);
        if ($item->type == Menu::TYPE_DIVIDER) {
            $labelBg = $item->id == $this->currentId ? 'bg-color-orange' : 'bg-color-pinkDark';
            return Html::a(Html::tag('span', "DIVIDER", ['class' => 'label ' . $labelBg]), $link);
        } else if ($item->type == Menu::TYPE_HEADER) {
            $labelBg = $item->id ==$this->currentId ? 'bg-color-orange' : 'label bg-color-blueLight';
            return Html::a(Html::tag('span', static::iconTag($item->icon, $this->menu->icon, true) . $item->name, ['class' => 'label ' . $labelBg]), $link);
        } else {
            if ($item->id == $this->currentId) {
                return Html::a(Html::tag('span', static::iconTag($item->icon, $this->menu->icon, true) . $item->name, ['class' => 'label bg-color-orange']), $link);
            } else {
                return Html::a(static::iconTag($item->icon, $this->menu->icon, true) . $item->name, $link);
            }
        }
    }

}