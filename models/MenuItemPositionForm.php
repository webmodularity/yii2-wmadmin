<?php
namespace wma\models;

use yii\base\Model;
use Yii;
use wmc\models\Menu;

class MenuItemPositionForm extends Model
{
    const INSERT_BEFORE = 1;
    const INSERT_AFTER = 2;
    const INSERT_APPEND = 3;
    const INSERT_PREPEND = 4;

    public $item_id;
    public $insert_type = self::INSERT_BEFORE;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'insert_type'], 'integer'],
            [['item_id', 'insert_type'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'item_id' => 'Attach To',
            'insert_type' => 'Attach Via'
        ];
    }

    public function getInsertTypeOptions() {
        return [
            static::INSERT_BEFORE => 'Before',
            static::INSERT_AFTER => 'After',
            static::INSERT_APPEND => 'Append',
            static::INSERT_PREPEND => 'Prepend'
        ];
    }

    public function moveItem($menuItem, $menuAttach) {
        if ($this->insert_type == static::INSERT_PREPEND) {
            return $menuItem->prependTo($menuAttach);
        } else if ($this->insert_type == static::INSERT_APPEND) {
            return $menuItem->appendTo($menuAttach);
        } else if ($this->insert_type == static::INSERT_BEFORE) {
            return $menuItem->insertBefore($menuAttach);
        } else if ($this->insert_type == static::INSERT_AFTER) {
            return $menuItem->insertAfter($menuAttach);
        }
        return false;
    }

}