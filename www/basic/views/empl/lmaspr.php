<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$spratrs = Yii::$app->params['satr'];
?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading">Справочники
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: block">
        <ul class="list-unstyled">
        <?php foreach($spratrs as $key => $spratr){ ?>
            <li style="padding: 10px">
            <a href="<?= \yii\helpers\Url::to(['empl/aspr','atrid'=>$key]); ?>" ><?= $spratr['atrDescr']; ?></a>
            </li>
        <?php } ?>
        </ul>
    </div>
</div>

