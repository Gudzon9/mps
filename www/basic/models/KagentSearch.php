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
    public function attributes()
    {
            // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), ['kagent.name']);
    }    
    public function rules()
    {
        return [
            [['id', 'kindKagent', 'typeKag', 'companyId', 'userId'], 'integer'],
            [['name', 'posada', 'birthday'], 'safe'],
            [['adr', 'coment','kagent.name'], 'string'],
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
    public function search($params,$filter=null)
    {
        $query = Kagent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['kagents' => function($query) { $query->from(['kagent' => 'kagent'])->alias('company'); }]);
        $this->load($params);
        
        if (isset($filter)){
            foreach ($filter As $atr=>$val){
                //$this[$atr] = $val;
                $query->andFilterWhere(['kagent.'.$atr=>$val]);
            }
            //$this->kindKagent = $filter['kindKagent'];
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'kagent.id' => $this->id,
            //'kagent.kindKagent' => $this->kindKagent,
            'kagent.typeKag' => $this->typeKag,
            'kagent.companyId' => $this->companyId,
            'kagent.userId' => $this->userId,
            'kagent.coment' => $this->coment,
            'kagent.adr' => $this->adr,
        ]);
        
        //$query->andFilterWhere(['companyId'=>$filters['companyId']]);
        $query->andFilterWhere(['like', 'kagent.name', $this->name])
            ->andFilterWhere(['like', 'posada', $this->posada])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
                ->andFilterWhere(['like', 'kagent.name', $this->getAttribute('kagent.name')]);
        
//var_dump($query->createCommand());
        return $dataProvider;
    }
}
