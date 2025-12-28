<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\Post $model */
$this->registerCssFile('@web/css/post_view.css');

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Пости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-header">
    <h1 class="post-title"><?= Html::encode($model->title) ?></h1>

    <div class="post-meta">
        <p class="post-author">
            <strong>Автор:</strong> <?= Html::encode($model->author->name ?? 'Невідомо') ?>
        </p>
        <p class="post-date">
            <?php if ($model->updated_at && $model->updated_at !== $model->created_at): ?>
                <strong>Дата публікації (оновлено):</strong> <?= Html::encode($model->updated_at) ?>
            <?php else: ?>
                <strong>Дата публікації:</strong> <?= Html::encode($model->created_at) ?>
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="post-body row">
    <!-- Зображення -->
    <div class="col-lg-6 col-12 mb-3 post-image">
        <?php if (!empty($model->image)): ?>
            <img src="<?= Html::encode($model->image) ?>" alt="post" class="img-fluid">
        <?php endif; ?>
    </div>

    <!-- Опис + теги -->
    <div class="col-lg-6 col-12">
        <div class="post-details-view">
            <div class="post-content">
                <?= html_entity_decode($model->description) ?>
            </div>

            <?php if (!empty($model->source)): ?>
                <div class="post-source mt-3">
                    <strong>Джерело:</strong>
                    <a href="<?= Html::encode($model->source) ?>" target="_blank" rel="noopener">
                        <?= Html::encode($model->source) ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="post-tags mt-3">
                <?php foreach ($model->tags as $tag): ?>
                    <span class="tag-chip"><?= Html::encode($tag->title) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<!-- Поділитися в соціальних мережах -->
<div class="share-button mt-3">
    <p>Поділитися:</p>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= Url::to(['post/view', 'id' => $model->id], true) ?>"
        target="_blank" class="btn btn-share-facebook">Поділитися у Facebook</a>
    <a href="viber://forward?text=<?= urlencode($model->title . ' ' . Url::to(['post/view', 'id' => $model->id], true)) ?>"
        class="btn btn-share-viber">Поділитися у Viber</a>

</div>

<!-- Коментарі -->
<div class="comments mt-3">
    <h3>Коментарі</h3>

    <!-- додавання коментаря -->
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="comment-form mt-3">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($newComment, 'text')->textarea(['rows' => 3, 'placeholder' => 'Напишіть свій коментар...']) ?>
            <div class="form-group">
                <?= Html::submitButton('Надіслати', ['class' => 'btn btn-comment']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php else: ?>
        <p class="no-authroriz">Щоб залишити коментар, виконайте вхід.</p>
    <?php endif; ?>

    <!-- список коментарів -->
    <div class="comment-list mt-3">
        <?php if (empty($comments)): ?>
            <p class="no-comments">Ніхто не написав коментар. Будьте першими 🙂</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item">
                    <div class="comment-author">
                        <?= Html::encode($comment->user->name ?? 'Анонім') ?>
                        <?php if (!empty($comment->user) && $comment->user->isAdmin): ?>
                            <span class="admin-label">[Адмін]</span>
                        <?php endif; ?>
                    </div>
                    <div class="comment-text">
                        <?= Html::encode($comment->text) ?>
                    </div>
                    <div class="comment-date text-muted">
                        <?= Html::encode($comment->created_at) ?>
                    </div>

                    <?php if (!empty(Yii::$app->user->identity->isAdmin)): ?>
                        <div class="comment-deletes">
                            <?= Html::a('Видалити коментар', ['comment/delete', 'id' => $comment->id], [
                                'class' => 'del-comment',
                                'data-confirm' => 'Видалити цей коментар з усіма відповідями?',
                                'data-method' => 'post',
                            ]) ?>
                        </div>
                    <?php endif; ?>


                    <!-- Кнопка відповіді -->
                    <details class="reply-toggle">
                        <summary class="reply-button">Відповісти</summary>
                        <div class="reply-form">
                            <?php $form = ActiveForm::begin(); ?>
                            <?= Html::hiddenInput('parent_id', $comment->id) ?>
                            <?= $form->field($newComment, 'text')->textarea(['rows' => 2, 'placeholder' => 'Напишіть відповідь...']) ?>
                            <?= Html::submitButton('Надіслати', ['class' => 'btn btn-comment']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </details>

                    <!-- Відповіді на коментарі -->
                    <?php foreach ($comment->replies as $reply): ?>
                        <div class="comment-item reply">
                            <div class="comment-author">
                                <?= Html::encode($reply->user->name ?? 'Анонім') ?>
                                <?php if (!empty($reply->user) && $reply->user->isAdmin): ?>
                                    <span class="admin-label">[Адмін]</span>
                                <?php endif; ?>
                            </div>
                            <div class="comment-text"><?= Html::encode($reply->text) ?></div>
                            <div class="comment-date"><?= Html::encode($reply->created_at) ?></div>

                            <?php if (!empty(Yii::$app->user->identity->isAdmin)): ?>
                                <div class="comment-deletes">
                                    <?= Html::a('Видалити відповідь', ['comment/delete', 'id' => $reply->id], [
                                        'class' => 'del-comment',
                                        'data-confirm' => 'Видалити цю відповідь?',
                                        'data-method' => 'post',
                                    ]) ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>


                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- кнопка показати ще -->
    <?php if ($totalComments > $limit): ?>
        <div class="text-center mt-3">
            <a href="<?= Url::to(['post/view', 'id' => $model->id, 'limit' => $limit + 4]) ?>"
                class="btn btn-success">
                Показати ще
            </a>
        </div>
    <?php endif; ?>


</div>