<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vid".
 *
 * @property integer $id
 * @property string $descr
 */
class Vid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'descr'], 'required'],
            [['id'], 'integer'],
            [['descr'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descr' => 'Descr',
        ];
    }
}
