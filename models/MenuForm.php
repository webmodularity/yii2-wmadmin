<?php

namespace wma\models;

use Yii;
use wmc\models\Menu;

class MenuForm extends \yii\base\Model
{
    public $menu_id;
    public $name = null;
    public $icon = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'icon'], 'string', 'max' => 255],
            [['name', 'icon'], 'trim'],
            [['menu_id'], 'integer'],
            [['name'], 'unique', 'targetClass' => '\wmc\models\Menu', 'targetAttribute' => 'name', 'filter' => ['type' => Menu::TYPE_ROOT]],
            [['icon'], 'default', 'value' => null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'menu_id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon Set'
        ];
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (empty($this->menu_id)) {
            if ($runValidation === true && $this->validate($attributeNames) !== true) {
                return false;
            }
            // New Record
            $tree = new Menu([
                'type' => Menu::TYPE_ROOT,
                'name' => $this->name,
                'icon' => $this->icon
            ]);
            if ($tree->makeRoot()) {
                $this->menu_id = $tree->id;
                return true;
            } else {
                return false;
            }
        } else {
            $tree = Menu::find()->where(['id' => $this->menu_id])->roots()->one();
            if (is_null($tree)) {
                return false;
            }
            if ($tree->name == $this->name) {
                $attributeNames = ['icon'];
            } else {
                $tree->name = $this->name;
            }
            if ($runValidation === true && $this->validate($attributeNames) !== true) {
                return false;
            }
            $tree->icon = $this->icon;
            return $tree->save();
        }
    }
}