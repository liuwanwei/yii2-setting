<?php 

namespace buddysoft\setting;

use Yii;
use buddysoft\setting\models\{Setting, Category};

class SettingComponent extends \yii\base\Component{

	public function init(){
		parent::init();
	}

	/**
	 *
	 * 查询一条数据
	 *
	 * @param string $category 分类可以为空，比如 '' 或 null，对应 category.category
	 * @param string $key 
	 *
	 * 如果分类非空，查询该分类下的数据，否则查询 category 未定义的字段
	 */
	
	private function findModel($category, $key){
		if (empty($category)) {
			// Category wasn't given, search the first occurrence key
			return Setting::findOne(['key' => $key]);
		}else{
			$model = Category::findOne(['category' => $category]);
			if (empty($model)) {
				// Category was given, do strict search
				return null;
			}

			return Setting::find()->where([
				'categoryId' => $model->id, 
				'key' => $key
			])->one();
		}				
	}

	// 写入记录
	public function get($key, $defaultValue = -1, $category = ''){
		$model = $this->findModel($category, $key);
		if (empty($model)) {
			return $defaultValue;
		}else{
			return $model->value;
		}
	}

	// 读取记录
	public function set($key, $value, $category = ''){
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