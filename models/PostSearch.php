<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
    public $searchText;
    public $category_id;
    public $tag_id;

    public function rules()
    {
        return [
            [['searchText'], 'safe'],
            [['category_id', 'tag_id'], 'integer'],
        ];
    }

    public function search($params)
    {
        
        $query = Post::find()->joinWith(['category', 'tags'])->groupBy('posts.id');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 6],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // пошук по заголовку та опису
        $query->andFilterWhere(['like', 'posts.title', $this->searchText])
              ->orFilterWhere(['like', 'posts.description', $this->searchText]);

        // фільтрація по категорії
        $query->andFilterWhere(['posts.category_id' => $this->category_id]);

        // фільтрація по тегу
        if ($this->tag_id) {
            $query->andWhere(['post_tag.tag_id' => $this->tag_id]);
        }

        return $dataProvider;
    }
}
