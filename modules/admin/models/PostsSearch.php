<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Posts;

/**
 * PostsSearch represents the model behind the search form of `app\modules\admin\models\Posts`.
 */
class PostsSearch extends Posts
{

    public $categoryTitle;

    /**
     * {@inheritdoc}
     */
    public function rules() 
    {
        return [
            [['id', 'user_id', 'category_id'], 'integer'],
            [['title', 'description', 'image', 'source', 'created_at', 'updated_at', 'categoryTitle'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        // $query = Posts::find();
        $query = Posts::find()->joinWith(['category']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Дод. сортування по назві категорії 
        $dataProvider->sort->attributes['categoryTitle'] = 
        [ 'asc' => ['category.title' => SORT_ASC], 
        'desc' => ['category.title' => SORT_DESC], ];

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions 
        $query->andFilterWhere([
            'posts.id' => $this->id,
            'posts.created_at' => $this->created_at,
            'posts.updated_at' => $this->updated_at,
            'posts.user_id' => $this->user_id,
            'posts.category_id' => $this->category_id,
        ]);

        // ->andFilterWhere(['like', 'tags', $this->tags]);
        $query->andFilterWhere(['like', 'posts.title', $this->title])
            ->andFilterWhere(['like', 'posts.description', $this->description])
            ->andFilterWhere(['like', 'category.title', $this->categoryTitle]); // фільтр по назві категорії

        return $dataProvider;
    }
}
