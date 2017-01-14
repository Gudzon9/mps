<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\components\GridView;
use app\models\Ui;
use yii\widgets\Pjax;
//use yii\web\Controller;
//<a href="#" typebtn="KagentNew" class="btn-xs btn-info">Добавить</a>
// echo $this->render('_search', ['model' => $searchModel]);

$this->title = 'CRM';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 1;
$this->params['leftmenu'] = $this->render('lmcrm');
?>
<div class="kagent-index">
    <?= Html::a('Добавить компанию', ['create','mode'=>'2'], ['class' => 'btn-xs btn-info']) ?>
    <?= Html::a('Добавить человека', ['create','mode'=>'1'], ['class' => 'btn-xs btn-info']) ?>    

    <?php Pjax::begin(['enablePushState' => false, 'id' => ($choiceMode?uniqid():'pjaxKAgent'), 'timeout'=>2000]); ?>
    
    
    <?= GridView::widget([
        'id'=>uniqid(),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'modelName' => 'Kagent',
        'edtType'=>'noModal',
        'Edt'=>'nomanual',
        'ui'=>new Ui(),         
        'columns' => [
            'name',
            [
               'attribute' => 'kindKagent',
               'filter' => Yii::$app->params['akindKagent'],
                'value'=>function($model){
                    return Yii::$app->params['akindKagent'][$model->kindKagent];
                }                
            ],
            [
               'attribute' => 'typeKag',
               //'filter' => Yii::$app->params['atypeKagent'],
               // 'value'=>function($model){
               //     return Yii::$app->params['atypeKagent'][$model->typeKagent];
               // }                
            ],                    
            //'companyId'=>'kagent.name',
            'adr',
            'coment',
            // 'posada',
            // 'birthday',
            // 'kuindActivity',
            // 'userId',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>



