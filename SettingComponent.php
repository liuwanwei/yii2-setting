<?php 

namespace buddysoft\setting;

use Yii;
use buddysoft\setting\models\Setting;

class SettingComponent extends \yii\base\Component{

	public function init(){
		parent::init();
	}

	/**
	 *
	 * 查询一条数据
	 *
	 * @param string $category 分类可以为空，比如 '' 或 null
	 * @param string $key 
	 *
	 * 如果分类非空，查询该分类下的数据，否则查询 category 未定义的字段
	 */
	
	private function findModel($category, $key){
		$query = Setting::find();
		if (empty($category)) {
			$query->where(['key' => $key])->andWhere('category IS NULL');
		}else{
			$query->where([
				'category' => $category, 
				'key' => $key
			]);
		}

		return $query->one();
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
			if (! is_string($value)) {
				$value = "{$value}";
			}
			$model->value = $value;
			$ret = $model->save();
			if (!$ret) {
				$errors = $model->getFirstErrors();
				Yii::error(array_shift($errors));
			}

			return $ret;
		}
	}
}


 ?>