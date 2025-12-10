<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="container mt-3">
    <div class="card shadow-sm card-form">
        <div class="form-title">
            <h4 class="mb-0">Форма для відправки даних користувача</h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Надіслати', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
