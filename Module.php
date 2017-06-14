<?php

namespace buddysoft\setting;

use Yii;
use buddysoft\setting\models\Setting;

class Module extends \yii\base\Module{

	public $defaultSetting;

	public function init(){
		parent::init();

		// 注册 bd-setting 消息翻译器
		$i18n = Yii::$app->i18n;
	    $i18n->translations['bs-setting'] = [
	        'class' => 'yii\i18n\PhpMessageSource',
	        'sourceLanguage' => 'en',
	        'basePath' => '@vendor/buddysoft/yii2-setting/messages',
	    ];
	}
}