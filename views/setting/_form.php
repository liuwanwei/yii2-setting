<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use buddysoft\setting\models\CategorySearch;
use buddysoft\setting\SettingHelper;
use buddysoft\setting\models\Setting;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?php if (! $model->isNewRecord) {
        $options = SettingHelper::getOptionsForKey($model->key);
        if (isset($options['validator']) && $options['validator'] == 'in') {
            echo $form->field($model, 'value')->dropDownList(SettingHelper::getDropDownListItems($options));
        }else{
            echo $form->field($model, 'value')->textInput(['maxLength' => true]);
        }
    }        
    ?>

    <?= $form->field($model, 'categoryId')->dropDownList(CategorySearch::categoryItems()) ?>

	<?= $form->field($model, 'weight')->textInput() ?>    

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
