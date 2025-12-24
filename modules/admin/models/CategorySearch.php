<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

class CategorySearch extends Category
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // пропуск
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // якщо валід. не пройд. поверт. всі записи
            return $dataProvider;
        }

        // фільтрація по ID
        $query->andFilterWhere(['id' => $this->id]);

        // фільтрація по назві категорії
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
