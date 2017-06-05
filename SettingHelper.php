<?php

namespace buddysoft\modules\setting;

use Yii;
use yii\helpers\ArrayHelper;
use buddysoft\modules\setting\models\Setting;

class SettingHelper{

	public static function defaultSetting(){
		$module = Module::getInstance();

		if ($module == null) {
			
			/**
			 *
			 * 在 App 运行环境中，需要通过 modules 配置
			 * 根据 buddysoft\modules\setting\Module 名字，
			 * 找到传入的 defaultSetting 参数
			 *
			 * 注意：如果项目中加载两个以上 setting 模块的话，此处只能根据名字返回第一个配置，
			 * 所以，一般将第一个模块作为动态修改参数，可以直接引用 setting 模块来修改
			 *
			 */
			
			$modules = Yii::$app->modules;
			foreach ($modules as $moduleSetting) {

				/**
				 *
				 * 自定义模块的配置是数组形式，内置的是对象形式
				 *
				 */

				if (is_array($moduleSetting)) {
					if ($moduleSetting['class'] == Module::className()) {
						return $moduleSetting['defaultSetting'];
					}
				}				
			}

			return null;

		}else{
			// 模块运行环境，直接返回配置参数
			return $module->defaultSetting;
		}		
	}

	public static function keyPrefix(){
		$setting = static::defaultSetting();
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
	    $defaultSetting = static::defaultSetting();
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