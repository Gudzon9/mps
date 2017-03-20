<?php
namespace app\models;
use Yii;
class Event extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'event';
    }
    public function rules()
    {
        return [
            //[['id_klient', 'id_type', 'start', 'end', 'prim', 'klient', 'type', 'color', 'title'], 'required'],
            [['id', 'id_klient', 'id_type', 'status'], 'integer'],
            [['start', 'end'], 'string'],
            [['allDay'], 'string', 'max' => 5],
            [['prim'], 'string', 'max' => 100],
            [['klient'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 15],
            [['color'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 200],
            [['status'], 'default', 'value' => 0],
            [['allDay','type','klient','prim','color'], 'default', 'value' => ''],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_klient' => 'Id Klient',
            'id_type' => 'Id Type',
            'allDay' => 'All Day',
            'start' => 'Start',
            'end' => 'End',
            'prim' => 'Prim',
            'status' => 'Status',
            'klient' => 'Klient',
            'type' => 'Type',
            'color' => 'Color',
            'title' => 'Title',
        ];
    }
    public function save($runValidation = true, $attributeNames = null){
        $this->title = $this->klient.' '.$this->prim;
        $this->color = ($this->status == 0) ? $this->color : "#C4C4C4" ;
        return parent::save($runValidation,$attributeNames);
    }
    
}
