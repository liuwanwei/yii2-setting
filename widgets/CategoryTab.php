<?php 

namespace buddysoft\setting\widgets;

use Yii;
use yii\helpers\Html;
use buddysoft\setting\models\{Category};

/*
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#">Home</a></li>
    <li role="presentation"><a href="#">Profile</a></li>
    <li role="presentation"><a href="#">Messages</a></li>
    <li role="presentation"><a href="#">新分类</a></li>
</ul>
*/

class CategoryTab{

	public static function addCategory($model, $activeCategoryId){
		if ($model != null) {
			$categoryId = $model->id;
			$a = Html::a($model->title, ['setting/index', 'categoryId' => $model->id]);

		}else{
			$categoryId = 0;
			$a = Html::a(Yii::t('bs-setting', 'Default Category'), ['setting/index', 'categoryId' => 0]);
		}
		

		if ($categoryId == $activeCategoryId) {
			$li = '<li role="presentation" class="active">' . $a . '</li>';
		}else{
			$li = '<li role="presentation">' . $a . '</li>';
		}

		return $li;
	}

	/**
	 *
	 * 生成包含所有分类的 Tab 栏，用来筛选配置项
	 *
	 * @param $categoryId 当前分类 ID
	 *
	 * @return string Html 代码
	 */
	
	public static function widget($categoryId){		

		$models = Category::find()
			->orderBy(['weight' => SORT_DESC])
			->all();

		// 开始
		$out = '<ul class="nav nav-tabs">';

		$out .= static::addCategory(null, $categoryId);

		foreach ($models as $model) {
			$out .= static::addCategory($model, $categoryId);
		}

		// 分类管理 tab
		$a = Html::a(Yii::t('bs-setting', 'Categories'), ['category/index'], [
			'data' => [
				'confirm' => Yii::t('bs-setting', 'Are you sure to open the management page?'),
			]
		]);
		$out .= '<li role="presentation">' . $a . '</li>';

		// 闭合
		$out .= '</ul>';

		return $out;
	}
}


 ?>