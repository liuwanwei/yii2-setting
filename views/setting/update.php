<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\Setting */

$this->title = '修改配置: ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => '系统参数', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
