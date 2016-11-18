<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kagent;

/**
 * KagentSearch represents the model behind the search form about `app\models\Kagent`.
 */
class KagentSearch extends Kagent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kindKagent', 'typeKagent', 'companyId', 'vidId', 'userId'], 'integer'],
            [['name', 'posada', 'birthday'], 'safe'],
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
        $query = Kagent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kindKagent' => $this->kindKagent,
            'typeKagent' => $this->typeKagent,
            'companyId' => $this->companyId,
            'vidId' => $this->vidId,
            'userId' => $this->userId,
        ]);
        
        //$query->andFilterWhere(['companyId'=>$filters['companyId']]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'posada', $this->posada])
            ->andFilterWhere(['like', 'birthday', $this->birthday]);

        return $dataProvider;
    }
}
