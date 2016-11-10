<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function attributes()
    {
            // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), ['addatr.tel']);
    }    
    public function rules()
    {
        return [
            [['id', 'status', 'posada', 'statusEmp'], 'integer'],
            [['fio1', 'fio2', 'fio3', 'fio', 'emailLogin', 'password', 'createdDs', 'updatedDs', 'birthday', 'dateEmp', 'dateDis', 'address', 'tin', 'passport'], 'safe'],
            [['addatr.tel'], 'string']
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['addAtr' => function($query) { $query->from(['addatr' => 'addatr']); }]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'createdDs' => $this->createdDs,
            'updatedDs' => $this->updatedDs,
            'posada' => $this->posada,
            'statusEmp' => $this->statusEmp,
        ]);

        $query->andFilterWhere(['like', 'fio1', $this->fio1])
            ->andFilterWhere(['like', 'fio2', $this->fio2])
            ->andFilterWhere(['like', 'fio3', $this->fio3])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'emailLogin', $this->emailLogin])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'dateEmp', $this->dateEmp])
            ->andFilterWhere(['like', 'dateDis', $this->dateDis])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'tin', $this->tin])
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['LIKE', 'addatr.content', $this->getAttribute('addatr.tel')])
            ->orFilterWhere(['LIKE', 'addatr.note', $this->getAttribute('addatr.tel')]);        

        return $dataProvider;
    }
}
