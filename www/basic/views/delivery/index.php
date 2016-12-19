<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рассылки';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">
    <table width="100%">
        <tr>
            <td style="text-align:left"><h1><?= Html::encode($this->title) ?></h1></td>
            <td style="text-align:right"><?= Html::a('Создать рассылку', ['create'], ['class' => 'btn btn-success']) ?></td>
        </tr>
    </table>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'date',
            'subject',
            'fromadr',
            'toadrs:ntext',
            'msgcont:ntext',
            'msgatt:ntext',
            'msgerr',
            ['class' => 'yii\grid\ActionColumn'],
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