<?php

use yii\helpers\Html;
use app\components\GridView;
use app\models\Ui;
use yii\widgets\Pjax;

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
                'attribute' => 'townKag',
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
                    foreach ($model->addatrphone As $item)
                    {
                        $cont =  substr($item['content'],0,4).' '.substr($item['content'],4,2).' '.substr($item['content'],6,3).' '.substr($item['content'],9);
                        $str.=$cont.' '.$item['note'].'<br>';
                    }
                    return $str;
                }
            ],
            [
                'label'=>'Коментарии',
                'attribute' => 'coment.descr',
                'format'=>'html',
                'value'=>function($model){
                    $str =''; 
                    $maxCD = '';
                    foreach ($model->addcoment As $item)
                    {
                        if($maxCD < $item['comentDate']) {
                            $str = substr(($item['comentDate'].' '.$item['descr']),0,50).' ...';
                            $maxCD = $item['comentDate'];
                        }     
                    }
                    return $str ;
                            //.(($counter > 1) ? '<br> еще коментариев :'.($counter-1) : '');
                }
            ],
            (Yii::$app->user->identity->isDirector && Yii::$app->session->get('allkag')!=1) ?        
            [
                'label'=>'Ответственный',
                'attribute' => 'userId',
                'value'=>function($model){
                    return $model->getUser()->one()->fio1;
                }               
            ] : []
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>



