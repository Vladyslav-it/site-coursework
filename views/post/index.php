<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\StringHelper;
use yii\helpers\Url;


use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Tag;

$this->registerCssFile('@web/css/post.css');

$this->title = 'Пости';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="page-title"><?= Html::encode($this->title) ?></h1>

<details class="filter-toggle mb-4">
    <summary class="btn btn-success">Фільтрація</summary>

    <div class="post-search mt-3">
        <?php $form = ActiveForm::begin(['method' => 'get']); ?>

        <?= $form->field($searchModel, 'searchText')->textInput(['placeholder' => 'Введіть заголовок або опис'])->label('Пошук по тексту') ?>
        <?= $form->field($searchModel, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'title'), ['prompt' => 'Виберіть категорію'])->label('Категорія') ?>
        <?= $form->field($searchModel, 'tag_id')->dropDownList(ArrayHelper::map(Tag::find()->all(), 'id', 'title'), ['prompt' => 'Виберіть тег'])->label('Тег') ?>

        <div class="form-actions row mt-3">
            <div class="col-6">
                <button type="submit" class="btn btn-success w-100">Пошук</button>
            </div>
            <div class="col-6">
                <a href="<?= Url::to(['post/index']) ?>" class="btn clear-button w-100">Очистити</a>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</details>

<div class="row">
    <?php if (empty($posts)): ?>
        <div class="col-12">
            <p class="text-center">Упс, нічого не знайдено за такими параметрами!</p>
        </div>
    <?php else: ?>

        <?php foreach ($posts as $post): ?>
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                <div class="post-card">

                    <!-- Зображення -->
                    <div class="post-image">
                        <?php if (!empty($post->image)): ?>
                            <img src="<?= $post->image ?>" alt="post">
                        <?php else: ?>
                            <img src="images/no-photo.png" alt="Зображення відсутнє">
                        <?php endif; ?>
                    </div>

                    <!-- назва, опис, дата створення -->
                    <div class="post-details">
                        <h2 class="post-title">
                            <?= Html::encode(StringHelper::truncate(html_entity_decode(strip_tags($post->title)), 35)) ?>
                        </h2>

                        <p class="post-text">
                            <?= Html::encode(StringHelper::truncate(html_entity_decode(strip_tags($post->description)), 45)) ?>
                        </p>

                        <!-- <p class="post-date">Дата публікації: <?= $post->created_at ?></p> -->

                        <p class="post-date">
                            <?php if ($post->updated_at && $post->updated_at !== $post->created_at): ?>
                                Дата публікації(оновлено): <?= $post->updated_at ?>
                            <?php else: ?>
                                Дата публікації: <?= $post->created_at ?>
                            <?php endif; ?>
                        </p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<!-- Пагінація -->
<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination'],
    'linkOptions' => ['class' => 'page-link'],
    'activePageCssClass' => 'active',
]) ?>