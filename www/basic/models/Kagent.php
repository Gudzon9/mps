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
            [['name', 'kindKagent', 'typeKagent', 'company', 'posada', 'birthday', 'kuindActivity', 'userId'], 'required'],
            [['id', 'kindKagent', 'typeKagent', 'company', 'kuindActivity', 'userId'], 'integer'],
            [['id'],'safe'],
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
            'name' => 'Наименование',
            'kindKagent' => 'Вид',
            'typeKagent' => 'Тип',
            'company' => 'Компания',
            'posada' => 'Должность',
            'birthday' => 'День рождения',
            'kuindActivity' => 'Kuind Activity',
            'userId' => 'Менеджер',
        ];
    }
}
