<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

use app\models\Post;
use app\models\PostSearch;
use app\models\Comment;

class PostController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'posts' => $dataProvider->getModels(),
            'pagination' => $dataProvider->pagination,
        ]);
    }

    public function actionView($id)
    {
        
        $model = Post::find()
            ->with(['author'])
            ->where(['id' => $id])
            ->one();


        if (!$model) {
            throw new NotFoundHttpException('Пост не знайдено.');
        }

        $limit = Yii::$app->request->get('limit', 4); // ліміт для показу коментарів

        // Витягуємо  коментарі 
        $comments = Comment::find()
            ->where(['post_id' => $id, 'parent_id' => null])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();


        // Новий коментар 
        $newComment = new Comment();
        if (!Yii::$app->user->isGuest) {
            if ($newComment->load(Yii::$app->request->post()) && $newComment->validate()) {
                $newComment->post_id = $id;
                $newComment->user_id = Yii::$app->user->id;
                $newComment->parent_id = Yii::$app->request->post('parent_id'); 
                $newComment->save();
                return $this->redirect(['post/view', 'id' => $id]);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'comments' => $comments,
            'newComment' => $newComment,
            'limit' => $limit,
            'totalComments' => Comment::find()->where(['post_id' => $id, 'parent_id' => null])->count(),
        ]);


    }
}


