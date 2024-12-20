<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class RequestSearch extends Request
{
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'email', 'message', 'status', 'comment', 'date_from', 'date_to'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Request::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1'); // invalid condition
            return $dataProvider;
        }

        // Filtering by fields
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['status' => $this->status]);

        // Filtering by date range
        if ($this->date_from) {
            $query->andWhere(['>=', 'created_at', $this->date_from]);
        }
        if ($this->date_to) {
            $query->andWhere(['<=', 'created_at', $this->date_to]);
        }

        return $dataProvider;
    }
}
