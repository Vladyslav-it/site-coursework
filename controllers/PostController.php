<?php

namespace app\controllers;

use yii\web\Controller;

// use yii\data\Pagination;

// use app\models\Post;

use app\models\PostSearch;

class PostController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'posts' => $dataProvider->getModels(),
            'pagination' => $dataProvider->pagination,
        ]);
    }
}


// class PostController extends Controller {

//     public function actionIndex() {
//        $query = Post::find();

//         $pagination = new Pagination([

//             'defaultPageSize' => 6,

//             'totalCount' => $query->count(),

//         ]);

//         $posts = $query->orderBy(['created_at' => SORT_DESC])

//             ->offset($pagination->offset)

//             ->limit($pagination->limit)

//             ->all();

//         return $this->render('index', [

//             'posts' => $posts,

//             'pagination' => $pagination,

//         ]);

//     }

// }