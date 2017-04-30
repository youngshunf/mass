<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Appeal;

/**
 * SearchAppeal represents the model behind the search form about `common\models\Appeal`.
 */
class SearchAppeal extends Appeal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'orderid', 'type', 'result', 'created_at', 'updated_at'], 'integer'],
            [['user_guid', 'orderno', 'remark', 'reason'], 'safe'],
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
        $query = Appeal::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'orderid' => $this->orderid,
            'type' => $this->type,
            'result' => $this->result,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'user_guid', $this->user_guid])
            ->andFilterWhere(['like', 'orderno', $this->orderno])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
