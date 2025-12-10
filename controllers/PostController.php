<?php

namespace app\controllers;

use yii\web\Controller;

use yii\data\Pagination;

use app\models\Post;

class PostController extends Controller {

    public function actionIndex() {
       $query = Post::find();

        $pagination = new Pagination([

            'defaultPageSize' => 6,

            'totalCount' => $query->count(),

        ]);

        $posts = $query->orderBy(['created_at' => SORT_DESC])

            ->offset($pagination->offset)

            ->limit($pagination->limit)

            ->all();

        return $this->render('index', [

            'posts' => $posts,

            'pagination' => $pagination,

        ]);

    }

}