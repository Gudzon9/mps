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
        return array_merge(parent::attributes(), ['kagent.name','addatr.tel','coment.descr']);
    }    
    public function rules()
    {
        return [
            [['id', 'kindKagent', 'typeKag', 'statKag', 'actiKag', 'chanKag', 'refuKag', 'regiKag', 'townKag', 'deliKag', 'companyId', 'userId'], 'integer'],
            [['name', 'posada', 'birthday','adr', 'coment','prodKag','grouKag','tpayKag','kagent.name'], 'string'],
            [['addatr.tel','coment.descr'], 'string']
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
        $query = Kagent::find()->joinWith(['addatrphone','addcoment']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,'pagination' => ['pagesize' => 20,],
        ]);
        //$query->joinWith(['kagents' => function($query) { $query->from(['kagent' => 'kagent'])->alias('company'); }]);
        //$query->joinWith(['addAtr' => function($query) { $query->from(['addatr' => 'addatr']); }]);
        //$query->joinWith(['addAtr'])->joinWith(['coment']);
        $this->load($params);
        
        if (isset($filter)){
            $afldname = ['prodKag','tpayKag','grouKag'];
            foreach ($filter As $atr=>$val){
                //$this[$atr] = $val;
                if(in_array($atr, $afldname)) {
                    $query->andFilterWhere(['like','kagent.'.$atr, $val]);
                } else {
                    $query->andFilterWhere(['kagent.'.$atr=>$val]);
                }    
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
            'kagent.kindKagent' => $this->kindKagent,
            'kagent.typeKag' => $this->typeKag,
            'kagent.statKag' => $this->statKag,
            'kagent.actiKag' => $this->actiKag,
            'kagent.chanKag' => $this->chanKag,
            'kagent.refuKag' => $this->refuKag,
            'kagent.regiKag' => $this->regiKag,
            'kagent.townKag' => $this->townKag,
            'kagent.deliKag' => $this->deliKag,
            'kagent.companyId' => $this->companyId,
            'kagent.userId' => $this->userId,
        ]);
        $query->andFilterWhere(['like', 'kagent.name', $this->name])
            ->andFilterWhere(['like', 'kagent.posada', $this->posada])
            ->andFilterWhere(['like', 'kagent.birthday', $this->birthday])
            ->andFilterWhere(['like', 'kagent.coment', $this->coment])
            ->andFilterWhere(['like', 'kagent.adr', $this->adr])
            ->andFilterWhere(['like', 'kagent.prodKag', $this->prodKag])
            ->andFilterWhere(['like', 'kagent.tpayKag', $this->tpayKag])
            ->andFilterWhere(['like', 'kagent.grouKag', $this->grouKag])
            ->andFilterWhere(['like', 'kagent.name', $this->getAttribute('kagent.name')])
            ->andFilterWhere(['LIKE', 'addatr.content', $this->getAttribute('addatr.tel')])
            ->andFilterWhere(['LIKE', 'coment.descr', $this->getAttribute('coment.descr')]);
                
//var_dump($query->createCommand());
        return $dataProvider;
    }
}
