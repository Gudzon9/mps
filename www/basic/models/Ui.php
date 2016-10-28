<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ui".
 *
 * @property integer $user_id
 * @property string $model
 * @property string $fld
 * @property integer $value
 */
class Ui extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ui';
    }

    /**
     * @inheritdoc
     */
    
		
    public function rules()
    {
        return [
            [['user_id', 'model', 'attribute', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['model', 'attribute'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'model' => 'Model',
            'attribute' => 'Fld',
            'value' => 'Value',
        ];
    }
}
