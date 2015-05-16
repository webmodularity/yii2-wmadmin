<?php
namespace wma\models;

use yii\base\Model;
use Yii;

class MenuItemForm extends Model
{
    public $type;
    public $name;
    public $link;
    public $icon;
    public $child_of;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'child_of'], 'required'],
            [['child_of', 'type'], 'integer'],
            [['name', 'link', 'icon'], 'string', 'max' => 255],
            [['name', 'link', 'icon'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'child_of' => 'Child Of',
            'type' => 'Type',
            'name' => 'Name',
            'link' => 'Link',
            'icon' => 'Icon Name'
        ];
    }

}