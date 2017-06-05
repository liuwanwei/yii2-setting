<?php

namespace buddysoft\setting;

use buddysoft\setting\models\Setting;

class Module extends \yii\base\Module{

	public $defaultSetting;

	public function init(){
		parent::init();		
	}

	private function findModel($category, $key){
		$query = Setting::find();
		if (empty($category)) {
			$query->where(['key' => $key]);
		}else{
			$query->where([
				'category' => $category, 
				'key' => $key
			]);
		}

		return $query->findOne();
	}

	public function get($category = '', $key, $defaultValue = -1){
		$model = $this->findModel($category, $key);
		if (empty($model)) {
			return $defaultValue;
		}else{
			return $model->value;
		}
	}

	public function set($category = '', $key, $value){
		$model = $this->findModel($category, $key);
		if (empty($model)) {
			return false;
		}else{
			$model->value = $value;
			return $model->save();
		}
	}
}