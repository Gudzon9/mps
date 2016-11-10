<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\components\GridView;
use app\models\Ui;
use yii\widgets\Pjax;

$this->title = 'Empl';
$this->params['curmenu'] = 2;
$this->params['cursubmenu'] = 1;
?>
<a href="#" typebtn="UserNew" class="btn-xs btn-info">Добавить</a>
<?php Pjax::begin(['enablePushState' => false, 'id' =>  'usrPjax']); ?>
    <?= GridView::widget([
        'id' =>  'usrGrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'modelName' => 'User',
        'edtType'=>'Modal',
        'ui'=>new Ui(),        
        'columns' => [
            'fio',
            [
                'attribute'=>'posada',
                'value'=>function($model){
                    return Yii::$app->params['aposada'][$model->posada];
                }
            ],            
            'birthday',
            'address',
            [
                'attribute'=>'statusEmp',
                'value'=>function($model){
                    return Yii::$app->params['astatusEmp'][$model->statusEmp];
                }
            ],
            [
                'label'=>'Телефон',
                'attribute'=>'addatr.tel',
                'format'=>'html',
                'value'=>function($model){
                    $str ='';
                    foreach ($model->getAddAtr(1)->all() As $item)
                    {
                        $str.=$item['content'].' '.$item['note'].'<br>';
                    }
                    return $str;
                }
            ],                    
        ],
    ]); ?>
<?php Pjax::end(); ?>
