<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coment".
 *
 * @property integer $id
 * @property integer $kagentId
 * @property string $comentDate
 * @property string $descr
 */
class Coment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kagentId', 'comentDate', 'descr'], 'required'],
            [['kagentId'], 'integer'],
            [['comentDate'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kagentId' => 'Kagent ID',
            'comentDate' => 'Дата',
            'descr' => 'Коментарий',
        ];
    }
    public function getKagent()
    {
        return $this->hasOne(Kagent::className(),['id'=>'kagentId']);
    } 
}
