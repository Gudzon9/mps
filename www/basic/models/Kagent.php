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
            [['id', 'name', 'kindKagent', 'typeKagent', 'company', 'posada', 'birthday', 'kuindActivity', 'userId'], 'required'],
            [['id', 'kindKagent', 'typeKagent', 'company', 'kuindActivity', 'userId'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['posada'], 'string', 'max' => 20],
            [['birthday'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'kindKagent' => 'Kind Kagent',
            'typeKagent' => 'Type Kagent',
            'company' => 'Company',
            'posada' => 'Posada',
            'birthday' => 'Birthday',
            'kuindActivity' => 'Kuind Activity',
            'userId' => 'User ID',
        ];
    }
}
