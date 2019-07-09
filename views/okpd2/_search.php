<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Okpd2Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="okpd2-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'razdel') ?>

    <?= $form->field($model, 'global_id') ?>

    <?= $form->field($model, 'idx') ?>

    <?php // echo $form->field($model, 'kod') ?>

    <?php // echo $form->field($model, 'nomdescr') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
