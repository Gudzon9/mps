<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tabl".
 *
 * @property integer $id
 * @property string $name
 * @property integer $ls
 * @property integer $tprm
 * @property string $yearmont
 * @property integer $d01
 * @property integer $d02
 * @property integer $d03
 * @property integer $d04
 * @property integer $d05
 * @property integer $d06
 * @property integer $d07
 * @property integer $d08
 * @property integer $d09
 * @property integer $d10
 * @property integer $d11
 * @property integer $d12
 * @property integer $d13
 * @property integer $d14
 * @property integer $d15
 * @property integer $d16
 * @property integer $d17
 * @property integer $d18
 * @property integer $d19
 * @property integer $d20
 * @property integer $d21
 * @property integer $d22
 * @property integer $d23
 * @property integer $d24
 * @property integer $d25
 * @property integer $d26
 * @property integer $d27
 * @property integer $d28
 * @property integer $d29
 * @property integer $d30
 * @property integer $d31
 * @property integer $adays
 * @property integer $wdays
 * @property integer $chek
 */
class Tabl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tabl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ls', 'tprm', 'yearmont', 'd01', 'd02', 'd03', 'd04', 'd05', 'd06', 'd07', 'd08', 'd09', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'd16', 'd17', 'd18', 'd19', 'd20', 'd21', 'd22', 'd23', 'd24', 'd25', 'd26', 'd27', 'd28', 'd29', 'd30', 'd31', 'adays', 'wdays', 'chek'], 'required'],
            [['ls', 'tprm', 'd01', 'd02', 'd03', 'd04', 'd05', 'd06', 'd07', 'd08', 'd09', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'd16', 'd17', 'd18', 'd19', 'd20', 'd21', 'd22', 'd23', 'd24', 'd25', 'd26', 'd27', 'd28', 'd29', 'd30', 'd31', 'adays', 'wdays', 'chek'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['yearmont'], 'string', 'max' => 6],
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
            'ls' => 'Ls',
            'tprm' => 'Tprm',
            'yearmont' => 'Yearmont',
            'd01' => 'D01',
            'd02' => 'D02',
            'd03' => 'D03',
            'd04' => 'D04',
            'd05' => 'D05',
            'd06' => 'D06',
            'd07' => 'D07',
            'd08' => 'D08',
            'd09' => 'D09',
            'd10' => 'D10',
            'd11' => 'D11',
            'd12' => 'D12',
            'd13' => 'D13',
            'd14' => 'D14',
            'd15' => 'D15',
            'd16' => 'D16',
            'd17' => 'D17',
            'd18' => 'D18',
            'd19' => 'D19',
            'd20' => 'D20',
            'd21' => 'D21',
            'd22' => 'D22',
            'd23' => 'D23',
            'd24' => 'D24',
            'd25' => 'D25',
            'd26' => 'D26',
            'd27' => 'D27',
            'd28' => 'D28',
            'd29' => 'D29',
            'd30' => 'D30',
            'd31' => 'D31',
            'adays' => 'Adays',
            'wdays' => 'Wdays',
            'chek' => 'Chek',
        ];
    }
}
