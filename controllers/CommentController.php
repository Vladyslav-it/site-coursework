<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Comment;

class CommentController extends Controller
{
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException('Коментар не знайдено.');
        }

        if (empty(Yii::$app->user->identity->isAdmin)) {
            throw new ForbiddenHttpException('Доступ заборонено.');
        }

        // Якщо основний коментар — видаляємо і всі відповіді
        if ($comment->parent_id === null) {
            Comment::deleteAll(['parent_id' => $comment->id]);
        }

        $comment->delete();

        return $this->redirect(Yii::$app->request->referrer ?: ['post/index']);
    }
}
