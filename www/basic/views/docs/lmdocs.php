<?php
use yii\widgets\Menu;
use yii\helpers\Html;
?>
<div class="panel panel-primary">
    <div class="panel-heading">Места хранения</div>    
    <ul class="nav nav-pills nav-stacked">
        <li><?=Html::a('Все типы файлов',['docs/index']);?></li>      
        <li><?=Html::a('Word ',['docs/index','filestype'=>1]);?></li>      
        <li><?=Html::a('Excel',['docs/index','filestype'=>2]);?></li>   
        <li><?=Html::a('PDF',['docs/index','filestype'=>3]);?></li>   
    </ul>    
</div>
