<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kagent".
 *
 * @property integer $id
 * @property string $name
 * @property integer $kindKagent
 * @property integer $typeKagent
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
            [['name', 'kindKagent', 'typeKagent', 'birthday', 'vidId', 'userId'], 'required'],
            [['id', 'kindKagent', 'typeKagent', 'vidId', 'userId'], 'integer'],
            [['id','companyId','posada'],'safe'],
            [['name'], 'string', 'max' => 60],
            [['posada'], 'string', 'max' => 20],
            [['birthday'], 'string', 'max' => 10],
            [['city','adr','coment'], 'string', 'max' => 60],
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
            'typeKagent' => 'Тип',
            'companyId' => 'Компания',
            'posada' => 'Должность',
            'birthday' => 'День рождения',
            'vidId' => 'Вид деятельности',
            'userId' => 'Менеджер',
            'city' => 'Город',
            'adr' => 'Адрес',
            'coment' => 'Примечание',
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
    public function getKagents()
    {
        return $this->hasMany(Kagent::className(),['companyId'=>'id']);
    }	    
    public function getKagent()
    {
        return $this->hasOne(Kagent::className(),['companyId'=>'id']);
    }       
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
}
