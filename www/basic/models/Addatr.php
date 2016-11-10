<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "addatr".
 *
 * @property integer $id
 * @property integer $tableKod
 * @property integer $tableId
 * @property integer $atrKod
 * @property string $content
 * @property string $note
 */
class Addatr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addatr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tableKod', 'tableId', 'atrKod', 'content'], 'required'],
            [['id', 'tableKod', 'tableId', 'atrKod'], 'integer'],
            [['content'], 'string', 'max' => 90],
            [['note'], 'safe'],
            [['note'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tableKod' => 'Table Kod',
            'tableId' => 'Table ID',
            'atrKod' => 'Atr Kod',
            'content' => 'Content',
            'note' => 'Note',
        ];
    }
}
