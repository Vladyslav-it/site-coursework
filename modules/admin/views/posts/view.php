<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\Posts $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статті', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerCssFile('@web/css/admin.css');
?>
<div class="posts-view">

    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви точно хочете видалити статтю?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            
            [ 'attribute' => 'description', 'format' => 'raw', ],
            [ 
                'label' => 'Зображення', 
                'format' => 'raw', 
                'value' => $model->image ? Html::img($model->image, ['style' => 'max-width:300px']) : '(немає)',
            ],
            'source',
            'created_at',
            'updated_at',
            [ 'label' => 'Теги', 'value' => implode(', ', array_map(fn($tag) => $tag->title, $model->tags)), ],
            [ 'label' => 'Категорія', 'value' => $model->category ? $model->category->title : '(немає)', ],
            [ 'label' => 'Автор', 'value' => $model->user ? $model->user->name : '(немає)', ],
        ],
    ]) ?>

</div>
