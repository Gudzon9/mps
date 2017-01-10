<?php
namespace app\models;
use Yii;

class Spratr extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'spratr';
    }
    public function rules()
    {
        return [
            [['atrId', 'descr',], 'required'],
            [['atrId'], 'integer'],
            [['descr'], 'string', 'max' => 50],
            
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'atrId' => 'Вид справочника',
            'descr' => 'Текст',
         ];
    }
    /*
    public function getatrbyid($atrid)
    {
    }
     * 
     */
}
