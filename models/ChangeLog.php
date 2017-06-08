<?php

namespace buddysoft\setting\models;

use Yii;

use yii\validators\Validator;
use buddysoft\setting\Module;
use buddysoft\setting\SettingHelper;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $key
 * @property string $oldValue
 * @property string $newValue
 * @property integer $userId
 */
class ChangeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        // 在 migrations 中也引用到，所以如果要改，请同时修改
        return 'bs_setting_change_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'userId'], 'required'],
            [['userId'], 'integer'],
            [['oldValue', 'newValue'], 'string'],
            [['key'], 'string', 'max' => 64],
            [['createdAt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => '配置项',            
            'oldValue' => '修改前',
            'newValue' => '修改后',
            'userId' => '操作者',
            'createdAt' => '时间',
        ];
    }
}
