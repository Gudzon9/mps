<?php
use yii\helpers\Html;
?>
<h4>Здесь отчеты</h4>
<?= Html::a('Создать группу', ['newgroup'], ['class' => 'btn btn-primary']) ?>
<div class="row">
    <div class="col-xs-12">
        <img src="<?= Yii::getAlias('@web/img/ukraine-map-regions.jpg')?>" width="100%" height="100%">
    </div>
</div>

<?php
$script = <<< JS
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>           
