<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use buddysoft\setting\SettingHelper;
use buddysoft\setting\widgets\CategoryTab;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$setting = SettingHelper::getDefaultSettings();

// 标题可配置，默认从 messages 中获取，可灵活通过模块配置修改
$title = ArrayHelper::getValue(
    $setting, 
    'setting.views.index.title', 
    Yii::t('bs-setting', 'Settings'
));

$showTitle = ArrayHelper::getValue(
    $setting, 
    'setting.views.index.showTitle', 
    true
);

$showCreateButton = ArrayHelper::getValue(
    $setting, 
    'setting.views.index.showCreateButton', 
    true
);

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="setting-index">

    <?php if ($showTitle === true): ?>
    <h1><?= $this->title ?></h1>
    <?php endif ?>

    <?php if ($showCreateButton === true): ?>
    <p>
        <?= Html::a('添加参数', ['create'], ['class' => 'btn btn-success']) ?>
    </p>    
    <?php endif ?>

    <!-- 显示分类 tab 栏 -->
    <?= CategoryTab::widget($categoryId) ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}{summary}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            // 'key',
            // 'value:ntext',
            [
                'attribute' => 'value',
                'value' => function($model){
                    return StringHelper::truncate($model->value, 24);
                }
            ],
            [
                'attribute' => 'description',
                'value' => function($model){
                    return StringHelper::truncate($model->description, 16);
                }
            
            ],
            [
                'attribute' => 'updatedAt',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->updatedAt, ['change-log/index', 'settingId' => $model->id]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>
