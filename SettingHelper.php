<?php

namespace buddysoft\setting;

use Yii;
use yii\helpers\ArrayHelper;
use buddysoft\setting\models\Setting;

class SettingHelper{

	/**
	 * 查找当前运行环境中配置参数
	 *
	 * @return array 子模块配置项，也就是 \buddysoft\setting\Module::defaultSetting 的内容
	 */
	public static function getDefaultSettings(){		
		/**
		 * （后端）通过包含子模块的路由方式访问子模块，直接返回配置参数
		 */
		$moduleInstance = Module::getInstance();
		if ($moduleInstance != null) {
			$moduleClass = get_class($moduleInstance);

			/**
			 * 要避免其他子模块中访问的情况。
			 */
			if ($moduleClass == \buddysoft\setting\Module::class) {
				return $moduleInstance->defaultSetting;
			}
		}

		/**
		 * 如果不是子模块路由方式访问，就需要通过从应用的 'modules' 配置中寻找配置参数。
		 * 
		 * 寻找方法：逐个查找应用配置的子模块，根据配置项中的 'class' 的值是否等于 \buddysoft\setting\Module 来寻找配置项，
		 * 然后返回配置项中的 defaultSetting 参数。
		 */
		
		$modules = Yii::$app->modules;
		foreach ($modules as $moduleName => $moduleSetting) {
			/**
			 * 注意：子模块的配置项是数组形式，实例化以后的才是对象形式
			 */

			if (is_array($moduleSetting)) {
				if ($moduleSetting['class'] == Module::className()) {
					return $moduleSetting['defaultSetting'];
				}
			}
		}

		// 没有找到配置了 "class => \buddysoft\setting\Module" 的子模块
		return null;
	}

	/**
	 * 获取一个配置项的验证参数
	 *
	 * @param string $key 配置项键值，对应数据表字段 bs_setting.key 
	 * @return array ( key => value)
	 */
	public static function getOptionsForKey(string $key){
		$defaultSettings = static::getDefaultSettings();
		if ($defaultSettings == null) {
			return null;
		}

		foreach ($defaultSettings as $setting) {
			if (!isset($setting['key']) || $setting ['key'] != $key) {
				continue;
			}

			if (!isset($setting['options'])) {
				// 找到的配置项中没有 options 设置
				return null;
			}

			return $setting['options'];
		}

		return null;
	}

	/**
	 * 从配置的 'in' 验证器的 'range' 参数中生成下拉列表
	 *
	 * @param array $options 某个配置项的可选参数数组
	 * @return array 可以用在 \yii\widgets\ActiveField::dropDownList() 的 $items 参数的数组
	 */
	public static function getDropDownListItems(array $options){
		if (! isset($options['params']) || !isset($options['params']['range'])) {
			return [null => '错误的配置'];
		}

		$items = [];
		foreach ($options['params']['range'] as $usableValue) {
			$items[$usableValue] = $usableValue;
		}

		return $items;
	}

	/**
	 * 寻找配置项中定义的配置参数前缀，用于多个配置子模块
	 *
	 * @return void
	 */
	public static function keyPrefix(){
		$setting = static::getDefaultSettings();
		return ArrayHelper::getValue($setting, 'setting.prefix', null);
	}

	/**
	 *
	 * 加载默认配置项
	 *
	 * 注意不要放到 Module 的 init 中调用，此时调用时模块初始化未完成，
	 * Module::getInstance() 会返回 null
	 */
	
	public static function prepareDefaultSettings(){
	    $defaultSetting = static::getDefaultSettings();
	    $prefix = static::keyPrefix();

	    // 加载配置文件中定义的配置项信息
	    foreach ($defaultSetting as $setting) {
	    	if (! isset($setting['key'])) {
	    		continue;
	    	}

	    	// 如果配置项不存在，向数据库中添加
	        $model = new Setting();
	        $model->load($setting, '');
	        $model->key = $prefix . $model->key;

	        $existed = Setting::findOne(['key' => $model->key]);
	        if (empty($existed)) {
	            $model->save();
	        }
	    }       
	}

	/**
	 *
	 * 快捷访问某个属性入口
	 */

	public static function objectWithKey($key){
		return Setting::findOne(['key' => $key]);
	}
	
	public static function value($key){
	    $model = static::objectWithKey($key);
	    return empty($model) ? null : $model->value;
	}	

	public static function intValue($key){
	    $model = static::objectWithKey($key);
	    return empty($model) ? -1 : intval($model->value);
	}

	public static function booleanValue($key){
		$model = static::objectWithKey($key);
		if (empty($model)) {
			return false;
		}else{
			if (is_bool($model->value)) {
				return $model->value;
			}else{
				return false;
			}
		}
	}

	// 快捷修改某个属性接口
	public static function updateValue($key, $value){
	    $model = static::objectWithKey($key);
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