<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "delivery".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $name
 * @property string $date
 * @property string $subject
 * @property string $fromadr
 * @property string $toadrs
 * @property string $msgcont
 * @property string $msgatt
 * @property integer $msgerr
 */
class Delivery extends \yii\db\ActiveRecord
{
    public $files;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**  [['files'], 'file','skipOnEmpty' => false],
     * @inheritdoc  'skipOnEmpty' => false, 'extensions' => 'png, jpg, txt, doc, docx, xls, xlsx, pdf', 'maxFiles' => 4
     */
    public function rules()
    {
        return [
            [['userId', 'name', 'date', 'subject', 'fromadr', 'toadrs', 'msgcont',], 'required'],
            [['msgatt', 'msgerr'], 'safe'],
            [['userId'], 'integer'],
            [['toadrs', 'msgcont'], 'string'],
            [['name'], 'string', 'max' => 60],
            [['date'], 'string', 'max' => 10],
            [['subject', 'fromadr'], 'string', 'max' => 100],
            
        ];
    }

    /**    
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'name' => 'Менеджер',
            'date' => 'Дата',
            'subject' => 'Тема',
            'fromadr' => 'От кого',
            'toadrs' => 'Кому',
            'msgcont' => 'Содержимое',
            'msgatt' => 'Вложение',
            'msgerr' => 'Ошибки',
         ];
    }
    public function upload()
    {
        //if ($this->validate()) {
        if (true) { 
            foreach ($this->files as $file) {
                $file->saveAs(Yii::getAlias('@webroot/files/') . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
/*
    public function beforeValidate()
{
    if (parent::beforeValidate()) {
        print_r($this);
        return true;
    }
    return false;
}
  
 * 
 */  
}
