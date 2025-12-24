<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="container mt-4">
    <div class="card shadow-sm card-form">
        <div class="form-title">
            <h4 class="mb-0">Авторизація</h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'class' => 'form-check-input',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Увійти', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>