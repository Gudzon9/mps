<?php
namespace app\models;
use Yii;

class Spratr extends \yii\db\ActiveRecord
{
    public $cnt;
    public static function tableName()
    {
        return 'spratr';
    }
    public function rules()
    {
        return [
            [['atrId', 'descr',], 'required'],
            [['atrId','lvlId'], 'integer'],
            [['descr'], 'string', 'max' => 50],
            
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'atrId' => 'Вид справочника',
            'descr' => 'Текст',
            'lvlId' => 'lvlId',
            
         ];
    }
    /*
    public function getatrbyid($atrid)
    {
    }
     * 
     */
}
