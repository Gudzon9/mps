<?php
namespace app\models;
use Yii;
class Addatr extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'addatr';
    }
    public function rules()
    {
        return [
            [['tableKod', 'tableId', 'atrKod', 'content'], 'required'],
            [['id', 'tableKod', 'tableId', 'atrKod'], 'integer'],
            [['content'], 'string', 'max' => 90],
            [['note'], 'safe'],
            [['note'], 'string', 'max' => 40],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tableKod' => 'Table Kod',
            'tableId' => 'Table ID',
            'atrKod' => 'Atr Kod',
            'content' => 'Content',
            'note' => 'Note',
        ];
    }

    public function getKagent()
    {
        return $this->hasOne(Kagent::className(),['id'=>'tableId']);
    } 
}
