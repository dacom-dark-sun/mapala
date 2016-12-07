<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Art;

/**
 * ArtSearch represents the model behind the search form about `\common\models\Art`.
 */
class ArtSearch extends Art
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'votes', 'total_pending_payout_value', 'replies'], 'integer'],
            [['created_at', 'country', 'city', 'category', 'sub_category', 'author', 'title', 'body', 'meta', 'blockchain'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Art::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'votes' => $this->votes,
            'total_pending_payout_value' => $this->total_pending_payout_value,
            'replies' => $this->replies,
            'country'=> $this->country,
            'city' => $this->city,
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'author' => $this->author,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'meta', $this->meta])
            ->andFilterWhere(['like', 'blockchain', $this->blockchain]);

        return $dataProvider;
    }
}
