<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '店铺', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-view">

    <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('删除', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',            
            'name',
            'value:ntext',
            'description',
            [
                'label' => '内部变量',
                'value' => $model->key,
            ],            
            'updatedAt',
        ],
    ]) ?>

</div>
