<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property integer $id_klient
 * @property integer $id_type
 * @property string $allDay
 * @property string $start
 * @property string $end
 * @property string $prim
 * @property integer $status
 * @property string $klient
 * @property string $type
 * @property string $color
 * @property string $title
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    
    public function rules()
    {
        return [
            //[['id_klient', 'id_type', 'start', 'end', 'prim', 'klient', 'type', 'color', 'title'], 'required'],
            [['id_klient', 'id_type', 'status'], 'integer'],
            [['start', 'end'], 'safe'],
            [['allDay'], 'string', 'max' => 5],
            [['prim'], 'string', 'max' => 100],
            [['klient'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 15],
            [['color'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
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
        $this->title = $this->type.' '.$this->klient.' '.$this->prim;
        return parent::save($runValidation,$attributeNames);
    }
    
}
