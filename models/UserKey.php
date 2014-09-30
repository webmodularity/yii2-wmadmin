<?php

namespace wma\models;

use Yii;

/**
 * This is the model class for table "user_key".
 *
 * @property integer $user_id
 * @property integer $type
 * @property string $key
 * @property string $create_time
 * @property string $expire_time
 *
 * @property User $user
 */
class UserKey extends \wmc\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'key', 'create_time', 'expire_time'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['create_time', 'expire_time'], 'safe'],
            [['key'], 'string', 'max' => 32],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'type' => 'Type',
            'key' => 'Key',
            'create_time' => 'Create Time',
            'expire_time' => 'Expire Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['person_id' => 'user_id']);
    }
}