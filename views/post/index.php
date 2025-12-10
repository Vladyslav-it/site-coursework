<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


$this->registerCssFile('@web/css/post.css');
?>

<h1>Поради щодо харчування</h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-lg-4 col-md-6 mb-4">
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
                    <h2 class="post-title"><?= Html::encode($post->title) ?></h2>
                    <p class="post-text"><?= Html::encode($post->description) ?></p>
                    <p class="post-date">Дата публікації (створення): <?= $post->created_at ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<!-- Пагінація -->
<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination'], 
    'linkOptions' => ['class' => 'page-link'], 
    'activePageCssClass' => 'active', 
]) ?>