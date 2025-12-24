<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;
use app\models\Category;
use app\models\Tag;


/** @var yii\web\View $this */
/** @var app\modules\admin\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCssFile('@web/css/admin.css');
?>

<!-- https://github.com/2amigos/yii2-ckeditor-widget використав для опису-->

<div class="posts-form">

    <!-- для завант (upload) -->
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <!-- заголовок -->
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!-- опис -->
    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <!-- джерела використані -->
    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

     <!-- категорія -->
    <?= $form->field($model, 'category_id')->dropDownList(
        Category::find()->select(['title', 'id'])->indexBy('id')->column(),
        ['prompt' => 'Виберіть категорію']
    ) ?>

    <!-- теги -->
    <?= $form->field($model, 'tagIds')->checkboxList(Tag::find()->select(['title', 'id'])->indexBy('id')->column()) ?>


    <?php if ($model->image): ?> 
        <p>Встановлене поточне зображення:</p>
        <p>
            <img src="<?= $model->image ?>" style="max-width: 300px;">
        </p>
    <?php endif; ?>



    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>