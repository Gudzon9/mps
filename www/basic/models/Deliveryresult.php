<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deliveryresult".
 *
 * @property integer $id
 * @property integer $deliveryId
 * @property integer $partnerKagentId
 * @property string $email
 * @property integer $err
 */
class Deliveryresult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveryresult';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deliveryId', 'partnerKagentId', 'email'], 'required'],
            [['deliveryId', 'partnerKagentId', 'err'], 'integer'],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deliveryId' => 'Delivery ID',
            'partnerKagentId' => 'Partner Kagent ID',
            'email' => 'Email',
            'err' => 'Err',
        ];
    }
}
