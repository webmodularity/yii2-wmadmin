<?php
namespace wma\models;

use wmc\helpers\ArrayHelper;
use wmu\models\UserGroup;
use yii\base\Model;
use Yii;
use wmc\models\Menu;

class MenuItemForm extends Model
{
    const INSERT_BEFORE = 1;
    const INSERT_AFTER = 2;
    const INSERT_APPEND = 3;
    const INSERT_PREPEND = 4;

    public $id;
    public $type = Menu::TYPE_LINK;
    public $name;
    public $link;
    public $icon;
    public $user_groups = [UserGroup::GUEST, UserGroup::USER, UserGroup::AUTHOR, UserGroup::ADMIN, UserGroup::SU];
    public $position;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['user_groups'], 'safe'],
            [['type'], 'in', 'range' => [Menu::TYPE_LINK, Menu::TYPE_DIVIDER, Menu::TYPE_HEADER]],
            [['type', 'id'], 'integer'],
            [['name', 'link', 'icon'], 'string', 'max' => 255],
            [['name', 'link', 'icon'], 'trim'],
            [['name', 'link', 'icon'], 'default', 'value' => null],
            [['user_groups'], 'default', 'value' => []],
            [['name', 'link'], 'required', 'when' => function($model) {
                return $model->type == Menu::TYPE_LINK;
            }, 'whenClient' => "function (attribute, value) {
                    return $(\"input:radio[name='MenuItemForm[type]']:checked\").val() == '".Menu::TYPE_LINK."';
                    }"
            ],
            [['name'], 'required', 'when' => function($model) {
                return $model->type == Menu::TYPE_HEADER;
            }, 'whenClient' => "function (attribute, value) {
                    return $(\"input:radio[name='MenuItemForm[type]']:checked\").val() == '".Menu::TYPE_HEADER."';
                    }"
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Menu Item ID',
            'type' => 'Type',
            'name' => 'Name',
            'link' => 'Link',
            'icon' => 'Icon Name'
        ];
    }

    public function getTypeOptions() {
        return [
            Menu::TYPE_LINK => 'Link',
            Menu::TYPE_HEADER => 'Header',
            Menu::TYPE_DIVIDER => 'Divider'
        ];
    }

    public function getTypeName() {
        $options = $this->getTypeOptions();
        return isset($options[$this->type]) ? $options[$this->type] : 'Unknown Type';
    }

    public function save($runValidation = true, $attributeNames = null) {
        if ($runValidation === true && $this->validate($attributeNames) !== true) {
            return false;
        }
        if (empty($this->id)) {
            // New Record
            if ($this->position->validate() && !is_null($menuAttach = Menu::findOne($this->position->item_id))) {
                $menuItem = new Menu(['type' => $this->type, 'name' => $this->name, 'link' => $this->link, 'icon' => $this->icon]);
                if ($this->position->moveItem($menuItem, $menuAttach)) {
                    // Link UserGroups
                    foreach ($this->user_groups as $userGroupId) {
                        if (!is_null($userGroup = UserGroup::findOne($userGroupId))) {
                            $menuItem->link('userGroups', $userGroup);
                        }
                    }
                    return true;
                }
            }
            return false;
        } else {
            if (!is_null($menuItem = Menu::findOne($this->id))) {
                $menuItem->name = $this->name;
                $menuItem->type = $this->type;
                $menuItem->link = $this->link;
                $menuItem->icon = $this->icon;

                $currentUserGroupIdMap = ArrayHelper::getColumn($menuItem->userGroups, 'id');
                $linkIds = array_diff($this->user_groups, $currentUserGroupIdMap);
                $unlinkIds = array_diff($currentUserGroupIdMap, $this->user_groups);
                foreach ($linkIds as $userGroupId) {
                    if (!is_null($userGroup = UserGroup::findOne($userGroupId))) {
                        $menuItem->link('userGroups', $userGroup);
                    }
                }
                foreach ($unlinkIds as $userGroupId) {
                    if (!is_null($userGroup = UserGroup::findOne($userGroupId))) {
                        $menuItem->unlink('userGroups', $userGroup, true);
                    }
                }
                return $menuItem->save();
            }
            return false;
        }
    }
}