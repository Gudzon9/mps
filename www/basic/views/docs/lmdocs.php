<?php
use yii\widgets\Menu;
use yii\helpers\Html;
?>
<div class="panel panel-primary">
    <div class="panel-heading">Места хранения</div>    
    <ul class="nav nav-pills nav-stacked">
        <li><?=Html::a('Общие (files)',['docs/index']);?></li>      
        <li><?=Html::a('Менеджеры (managers)',['docs/mng']);?></li>      
        <li><?=Html::a('Временные (temp)',['docs/tmp']);?></li>   
    </ul>    
</div>
