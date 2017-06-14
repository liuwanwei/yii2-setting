<?php 

namespace buddysoft\setting\widgets;

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

	public static function widget($categoryId){		

		$models = Category::find()
			->orderBy(['weight' => SORT_DESC])
			->all();

		// 开始
		$out = '<ul class="nav nav-tabs">';

		foreach ($models as $model) {
			$a = Html::a($model->title, ['setting/index', 'categoryId' => $model->id]);
			if ($categoryId == $model->categoryId) {
				$li = '<li role="presentation" class="active">' . $a . '</li>';
			}else{
				$li = '<li role="presentation">' . $a . '</li>';
			}

			$out .= $li;
		}

		// 分类管理 tab
		$a = Html::a('分类管理', ['category/index'], ['target' => '_blank']);
		$out .= '<li role="presentation"' . $a . '</li>';

		// 闭合
		$out .= '</ul>';

		return $out;
	}
}


 ?>