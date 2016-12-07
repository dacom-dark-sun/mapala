<?php

namespace yii2mod\comments\models;

use yii\data\ActiveDataProvider;

/**
 * Class CommentSearchModel
 * @package yii2mod\comments\models
 */
class CommentSearchModel extends CommentModel
{
    /**
     * @return array validation rules
     */
    public function rules()
    {
        return [
            [['permlink', 'author', 'body', 'status', 'parent_permlink'], 'safe'],
        ];
    }

    /**
     * Setup search function for filtering and sorting.
     *
     * @param $params
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 20)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);

        // load the search form data and validate
        if (!($this->load($params))) {
            return $dataProvider;
        }

        //adjust the query by adding the filters
        $query->andFilterWhere(['permlink' => $this->permlink]);
        $query->andFilterWhere(['author' => $this->author]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'body', $this->body]);
        $query->andFilterWhere(['like', 'parent_permlink', $this->parent_permlink]);

        return $dataProvider;
    }
}