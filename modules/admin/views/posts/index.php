<?php

use app\modules\admin\models\Posts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\PostsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile('@web/css/admin.css');

$this->title = 'Статті';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="posts-index">

    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a('Створити статтю', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показано <b>{begin}</b>–<b>{end}</b> з <b>{totalCount}</b> записів.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => fn($model) => \yii\helpers\StringHelper::truncate(strip_tags($model->description), 50),
            ],


            [
                'attribute' => 'categoryTitle',
                'label' => 'Категорія',
                'value' => function ($model) {
                    return $model->category ? $model->category->title : '(немає)';
                },
            ],


            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Posts $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>