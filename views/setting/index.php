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

$setting = SettingHelper::defaultSetting();
$title = ArrayHelper::getValue($setting, 'setting.views.index.title', '系统参数');
$showTitle = ArrayHelper::getValue($setting, 'setting.views.index.showTitle', true);
$showCreateButton = ArrayHelper::getValue($setting, 'setting.views.index.showCreateButton', true);

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="setting-index">

    <?php if ($showTitle === true): ?>
        <?php if ($showCreateButton === true): ?>
        <p>
            <?= Html::a('添加参数', ['create'], ['class' => 'btn btn-success']) ?>
        </p>    
        <?php endif ?>
    <?php endif ?>

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
                    return StringHelper::truncate($model->value, 8);
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
