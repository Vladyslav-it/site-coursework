<?php
use yii\helpers\Html;
?>

<div class="container mt-4">
    <div class="card shadow-sm card-form">

        <div class="card-body">
            <p class="mb-3">Ви вказали наступну інформацію:</p>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Ім’я:</strong> <?= Html::encode($model->name) ?>
                </li>
                <li class="list-group-item">
                    <strong>Адреса електронної пошти:</strong> <?= Html::encode($model->email) ?>
                </li>
                <li class="list-group-item">
                    <strong>Пароль:</strong> <?= Html::encode($model->password) ?>
                </li>
            </ul>
        </div>
    </div>
</div>


<!-- <?php
// use yii\helpers\Html;
?>
<p>Ви вказали наступну інформацію:</p>

<ul>
    <li><label>Ім’я</label>: <?= Html::encode($model->name) ?></li>
    <li><label>Адреса електронної пошти</label>: <?= Html::encode($model->email) ?></li>
    <li><label>Пароль:</label> <?= Html::encode($model->password) ?></li>
</ul> -->


