<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рассылки';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 3;
?>
<div class="delivery-index">
    <table width="100%">
        <tr>
            <td style="text-align:left"><h3><?= Html::encode($this->title) ?></h3></td>
            <td style="text-align:right"><?= Html::a('Создать рассылку', ['create'], ['class' => 'btn btn-success']) ?></td>
        </tr>
    </table>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'label'=>'Дата',
                'value'=>function($model){
                    return substr($model->date,8,2).'-'.substr($model->date,5,2).'-'.substr($model->date,0,4);
                }
            ],
            'subject',
            'fromadr',
            [
                'label'=>'Кому',
                'value'=>function($model){
                    return substr($model->toadrs,0,20).' ...';
                }
            ],        
            [
                'label'=>'Содержимое',
                'value'=>function($model){
                    return substr($model->msgcont,0,40).' ...';
                }
            ],        
            //'toadrs:ntext',
            //'msgcont:ntext',
            'msgatt:ntext',
            'msgerr',
            ['class' => 'yii\grid\ActionColumn','template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
<?php
$script = <<< JS
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>        