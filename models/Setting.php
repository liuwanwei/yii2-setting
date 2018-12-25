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
 * @property string $name
 * @property string $key
 * @property string $value
 * @property integer $categoryId
 * @property string $description
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        // 在 migrations 中也引用到，所以如果要改，请同时修改
        return 'bs_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'key'], 'required'],
            [['weight', 'categoryId'], 'integer'],
            [['value', 'description'], 'string'],
            [['name'], 'string', 'max' => 32],
            [['key'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoryId' => '类别',
            'name' => Yii::t('bs-setting', 'Setting Name'),
            'value' => Yii::t('bs-setting', 'Setting Value'),

            'keyֵ' => Yii::t('bs-setting', 'Setting Key'),

            'description' => Yii::t('bs-setting', 'Setting Description'),
            'weight' => Yii::t('bs-setting', 'Weight'),
            'updatedAt' => Yii::t('bs-setting', 'Updated At'),
        ];
    }

    public function getChangeLogs(){
        return $this->hasMany(ChangeLog::className(), ['key', 'key']);
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'categoryId']);
    }

    public function beforeValidate(){
        if (empty($this->key)) {
            // 跳过 Search 类的 validate() 调用
            return parent::beforeValidate();
        }

        $options = SettingHelper::getOptionsForKey($this->key);
        if ($options == null || !isset($options['validator'])) {
            return parent::beforeValidate();
        }

        $validator = $options['validator'];
        if (isset($options['params'])) {
            $params = $options['params'];
        }else{
            $params = [];
        }

        $validator = Validator::createValidator($validator, $this, 'value', $params);
        $ret = $validator->validate($this->value);
        if (false === $ret) {
            $this->addError('value', $validator->message);
            return false;
        }

        return true;
    }

    public function afterSave($insert, $changedAttribute){
        parent::afterSave($insert, $changedAttribute);

        // 记录修改日志
        if ($insert) {
            $oldValue = '';
            $newValue = $this->value;
        }else if (isset($changedAttribute['value'])) {
            $oldValue = $changedAttribute['value'];
            $newValue = $this->value;
        }else{
            return;
        }

        $log = new ChangeLog();
        $log->key = $this->key;
        $log->oldValue = $oldValue;
        $log->newValue = $newValue;
        if (isset(Yii::$app->user->id)) {
            $log->userId = Yii::$app->user->id;
        }else{
            $log->userId = 0;
        }
        $log->save();
    }

    /**
     *
     * 快捷访问某个属性入口
     * Deprecated: 请访问 buddysoft\modules\SettingHelper 获取以下接口
     */
    
    public static function value($key){
        $model = static::findOne(['key' => $key]);
        return empty($model) ? null : $model->value;
    }

    public static function intValue($key){
        $model = static::findOne(['key' => $key]);
        return empty($model) ? -1 : intval($model->value);
    }

    // 快捷修改某个属性接口
    public static function updateValue($key, $value){
        $model = static::findOne(['key' => $key]);
        if (empty($model)) {
            $model = new Setting();
            $model->key = $key;
        }

        // 所有属性的最终存储方式都必须是字符串
        $model->value = strval($value);
        $ret = $model->save();
        return $ret;
    }
}
