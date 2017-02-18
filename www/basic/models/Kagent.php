<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kagent".
 *
 * @property integer $id
 * @property string $name
 * @property integer $kindKagent
 * @property integer $typeKag
 * @property integer $company
 * @property string $posada
 * @property string $birthday
 * @property integer $kuindActivity
 * @property integer $userId
 */
class Kagent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kagent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','kindKagent','enterdate','userId'], 'required'],
            [['id', 'kindKagent', 'typeKag', 'statKag', 'actiKag', 'chanKag', 'refuKag', 'regiKag', 'townKag', 'deliKag', 'userId'], 'integer'],
            [['id','companyId','posada'],'safe'],
            [['prodKag','grouKag'], 'string', 'max' => 100],
            [['posada'], 'string', 'max' => 20],
            [['birthday','enterdate'], 'string', 'max' => 10],
            [['adr','coment','tpayKag','name','deliprim'], 'string', 'max' => 60],
            [['delitown','delinotd','delipers','deliphon'], 'string', 'max' => 30],
            [['typeKag', 'statKag', 'actiKag', 'chanKag', 'refuKag', 'regiKag', 'townKag', 'deliKag'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'kindKagent' => 'Вид',
            'companyId' => 'Компания',
            'posada' => 'Должность',
            'birthday' => 'День рождения',
            'typeKag' => 'Тип',
            'statKag' => 'Статус',
            'actiKag' => 'Вид деятельности',
            'chanKag' => 'Канал привлечения',
            'prodKag' => 'Продукция',
            'refuKag' => 'Причина отказа',
            'regiKag' => 'Область',
            'townKag' => 'Город',
            'tpayKag' => 'Формы расчета',
            'grouKag' => 'Группы',
            'deliKag' => 'Служба доставки',
            'delitown' => 'Город доставки',
            'delinotd' => '№ отделения доставки',
            'delipers' => 'Получатель',
            'deliprim' => 'Примечание',
            'deliphon' => 'Телефон',
            'adr' => 'Адрес',
            'coment' => 'Примечание',
            'userId' => 'Ответственный',
        ];
    }
    public function getAddAtrs($atrKod=0)
    {
        $relAddAtr = $this->hasMany(Addatr::className(),['tableId'=>'id'])
                ->andOnCondition(['tableKod'=>2]);
        if ($atrKod!=0){
            $relAddAtr->andOnCondition(['atrKod'=>$atrKod]);
        }
        return $relAddAtr;
    }    
    public function getAddComents()
    {
        return $this->hasMany(Coment::className(),['kagentId'=>'id']);
    }	    
    public function getEvents()
    {
        return $this->hasMany(Event::className(),['id_klient'=>'id']);
    }	    
    public function getKagents()
    {
        return $this->hasMany(Kagent::className(),['companyId'=>'id']);
    }	    
    public function getKagent()
    {
        return $this->hasOne(Kagent::className(),['companyId'=>'id']);
    } 
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'userId']);
    } 
    public function getTown()
    {
        return $this->hasOne(Spratr::className(),['id'=>'townKag']);
    } 
    public function getComent()
    {
        return $this->hasMany(Coment::className(),['kagentId'=>'id']);
    }
    /*
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->userId = Yii::$app->user->id;
        if (is_null($this->companyId) || $this->companyId==''){
            $this->companyId = 0;
        }
        if (is_null($this->companyId)){
            $this->posada = '';
        }        
        return parent::save($runValidation, $attributeNames);
    }  
    */
    public function getAddAtr($atrKod=0)
    {
        $relAddAtr = $this->hasMany(Addatr::className(),['tableId'=>'id'])
                ->andOnCondition(['tableKod'=>2]);
        if ($atrKod!=0){
            $relAddAtr->andOnCondition(['atrKod'=>$atrKod]);
        }
        return $relAddAtr;
    }
    public function getAddatrphone()
    {
        return $this->hasMany(Addatr::className(),['tableId'=>'id'])
                ->andOnCondition(['tableKod'=>2,'atrKod'=>1]);
    }
    public function getAddcoment()
    {
        return $this->hasMany(Coment::className(),['kagentId'=>'id']);
               // ->orderBy(['comentDate'=>SORT_DESC]);
    }
    
}
