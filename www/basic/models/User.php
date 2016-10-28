<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $fio1
 * @property string $fio2
 * @property string $fio3
 * @property string $fio
 * @property string $emailLogin
 * @property string $password
 * @property integer $status
 * @property string $createdDs
 * @property string $updatedDs
 * @property integer $posada
 * @property string $birthday
 * @property string $dateEmp
 * @property string $dateDis
 * @property string $address
 * @property string $tin
 * @property string $passport
 * @property integer $statusEmp
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio1', 'fio2', 'fio3', 'fio', 'emailLogin', 'password', 'createdDs', 'birthday', 'dateEmp', 'address', 'tin', 'passport', 'statusEmp'], 'required'],
            [['status', 'posada', 'statusEmp'], 'integer'],
            [['createdDs', 'updatedDs','id'], 'safe'],
            [['fio1', 'fio2', 'fio3', 'emailLogin'], 'string', 'max' => 40],
            [['fio', 'address'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 20],
            [['birthday', 'dateEmp', 'dateDis', 'tin'], 'string', 'max' => 10],
            [['passport'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio1' => 'Фамилия',
            'fio2' => 'Имя',
            'fio3' => 'Отчество',
            'fio' => 'ФИО',
            'emailLogin' => 'Email',
            'password' => 'Пароль',
            'createdDs' => 'Created Ds',
            'updatedDs' => 'Updated Ds',
            'posada' => 'Должность',
            'birthday' => 'День рождения',
            'dateEmp' => 'Дата приема',
            'dateDis' => 'Дата увольнения',
            'address' => 'Адрес',
            'tin' => 'Ид. код',
            'passport' => 'Паспорт',
            'statusEmp' => 'Статус',
        ];
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->fio = $this->fio1.' '.$this->fio2.' '.$this->fio3;
        if ($this->getIsNewRecord()) {
            $this->loadDefaultValues();
            $this->createdDs = date("Y-m-d H:i:s");            
            return $this->insert($runValidation, $attributeNames);
        } else {
            $this->updatedDs = date("Y-m-d H:i:s");
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }    
    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException();//I don't implement this method because I don't have any access token column in my database
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
    }

    public function validateAuthKey($authKey){
    }
    public static function findByUsername($username){
        return self::findOne(['emailLogin'=>$username]);
    }

    public function validatePassword($password){
        return $this->password === $password;
    }
}