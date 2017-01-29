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
/*
    <?= Html::a('Добавить компанию', ['create','mode'=>'2'], ['class' => 'btn-xs btn-info']) ?>
    <?= Html::a('Добавить человека', ['create','mode'=>'1'], ['class' => 'btn-xs btn-info']) ?>    

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

 *  */
$this->title = 'CRM';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 1;
$this->params['leftmenu'] = $this->render('lmcrm',['searchModel' => $searchModel]);
?>
<div class="kagent-index">
    <?php Pjax::begin(['enablePushState' => false, 'id' => ($choiceMode?uniqid():'pjaxKAgent'), 'timeout'=>2000]); ?>
    
    
    <?= GridView::widget([
        'id'=>uniqid(),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'modelName' => 'Kagent',
        'edtType'=>'noModal',
        'Edt'=>'nomanual',
        'ui'=>new Ui(),   
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            'name',
            [
                'label'=>'Город',
                'value'=>function($model){
                    return $model->getTown()->one()->descr;
                }               
            ],
            [
               'attribute' => 'kindKagent',
               'filter' => Yii::$app->params['akindKagent'],
                'value'=>function($model){
                    return Yii::$app->params['akindKagent'][$model->kindKagent];
                }                
            ],
            [
                'label'=>'Телефон',
                'attribute'=>'addatr.tel',
                'format'=>'html',
                'value'=>function($model){
                    $str ='';
                    foreach ($model->getAddAtrs(1)->all() As $item)
                    {
                        $str.=$item['content'].' '.$item['note'].'<br>';
                    }
                    return $str;
                }
            ],
            [
                'label'=>'Коментарии',
                'format'=>'html',
                'value'=>function($model){
                    $str =''; 
                    $counter = 0;
                    foreach ($model->getAddComents()->orderBy(['comentDate'=>SORT_DESC])->all() As $item)
                    {
                        if($counter == 0) {
                            $str.=substr(($item['comentDate'].' '.$item['descr']),0,50).' ...';
                        }     
                        $counter++ ;
                    }
                    return $str.(($counter > 1) ? '<br> еще коментариев :'.($counter-1) : '');
                }
            ],
            (Yii::$app->user->identity->isDirector && Yii::$app->session->get('allkag')!=1) ?        
            [
                'label'=>'Ответственный',
                'value'=>function($model){
                    return $model->getUser()->one()->fio1;
                }               
            ] : []
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>



