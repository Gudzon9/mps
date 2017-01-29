<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

//echo Pjax::begin(); 
echo GridView::widget([
        'id' => 'selkagents',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'name',
            [
                'label'=>'Город',
                'value'=>function($model){
                    return $model->getTown()->one()->descr;
                }               
            ],
            [
                'label'=>'Эл.почта',
                'attribute'=>'addatr.email',
                'format'=>'html',
                'value'=>function($model){
                    $str ='';
                    foreach ($model->getAddAtrs(2)->all() As $item)
                    {
                        $str.=$item['content'].' '.$item['note'].'<br>';
                    }
                    return $str;
                }
            ],
        ],
    ]);
//echo Pjax::end();            
?>        