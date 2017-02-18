<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\assets\MainAsset;
use app\assets\CaleAsset;
use app\assets\CrmAsset;
use app\assets\EmplAsset;
use app\assets\DocsAsset;

AppAsset::register($this);
if($this->params['curmenu']===1) MainAsset::register($this);
if($this->params['curmenu']===2) EmplAsset::register($this);
if($this->params['curmenu']===3) CaleAsset::register($this);
if($this->params['curmenu']===4) CrmAsset::register($this);
if($this->params['curmenu']===5) DocsAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-xs-2" >
                <table><tr>
                        <td><h4> <?=Html::a(Yii::$app->user->identity->fio,['main/index']);?></h4></td>      
                </tr>
            <?php if(Yii::$app->user->identity->isDirector && ($this->params['curmenu']===1 || $this->params['curmenu']===4)) { ?>
                <tr>
                <td>Клиенты : <input type="checkbox" id="allkag" data-url="<?= Url::to(['empl/setallkag'])?>" data-size="mini" data-on-text="Мои" data-off-text="Все" toglemenu data-label-text="<span class='glyphicon glyphicon-ok'></span>" class="form-control" <?= (Yii::$app->session->get('allkag')==1) ? 'checked' : ''?>> </td>
                </tr>
            <?php } ?>
                </table>
            </div>
            <div class="col-xs-10">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                    <?=Html::a('',['main/index'],['class'=>'i-main i-menu']);?>          
                    <?=Html::tag('p','Рабочий стол',['class'=>'p-menu text-center']);?>    
                    </li>
                    <?php if(Yii::$app->user->identity->isDirector) { ?>
                    <li>
                    <?=Html::a('',['empl/index'],['class'=>'i-employees i-menu']);?>          
                    <?=Html::tag('p','Сотрудники',['class'=>'p-menu text-center']);?>    
                    </li>
                    <?php } ?>
                    <li>
                    <?=Html::a('',['cale/index'],['class'=>'i-todos i-menu']);?>          
                    <?=Html::tag('p','Дела',['class'=>'p-menu text-center']);?>    
                    </li>
                    <li>
                    <?=Html::a('',['crm/index'],['class'=>'i-crm i-menu']);?>          
                    <?=Html::tag('p','Клиенты',['class'=>'p-menu text-center']);?>    
                    </li>
                    <?php if(Yii::$app->user->identity->isDirector) { ?>
                    <li>
                    <?=Html::a('',['delivery/index'],['class'=>'i-delivery i-menu']);?>          
                    <?=Html::tag('p','Рассылки',['class'=>'p-menu text-center']);?>    
                    </li>
                    <?php } ?>
                    <li>
                    <?=Html::a('',['docs/index'],['class'=>'i-docs i-menu']);?>          
                    <?=Html::tag('p','Документы',['class'=>'p-menu text-center']);?>    
                    </li>
                    <?php if(Yii::$app->user->identity->isDirector) { ?>
                    <li>
                    <?=Html::a('',['empl/aspr'],['class'=>'i-spr i-menu']);?>          
                    <?=Html::tag('p','Справочники',['class'=>'p-menu text-center']);?>    
                    </li>
                    <li>
                    <?=Html::a('',['rep/index'],['class'=>'i-zvit i-menu']);?>          
                    <?=Html::tag('p','Отчеты',['class'=>'p-menu text-center']);?>    
                    </li>
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                    <?=Html::a(Html::img('@web/img/exit.png', ['alt' => 'exit','height'=>'46','width'=>'46']).'<br>Выход', ['site/logout'], ['data' => ['method' => 'post'],'class' => 'white text-center','style' => 'padding-top: 10px;',]); ?>
                    </li>
                </ul>
            </div>
	</div>
    </div>	
</div>
<hr > 
<input type="hidden" id="curmenu" value=<?php echo $this->params['curmenu'];?>>
       
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-3" >
            <div style="padding-top: 6px; padding-left: 2px;">
		<?php if(isset($this->params['leftmenu'])) {
                //$pm = array(2,3,4,5); style="height: 38px"
                //if(in_array($this->params['curmenu'],$pm)){
                ?>
		<input type="checkbox" id="show-sidebar" data-size="mini" data-on-text="Включено" data-off-text="Выключено" toglemenu data-label-text="меню" class="form-control s-flip" checked>
		<?php }?>
            </div>
        </div>
        <div class="col-xs-9">
            <?php if($this->params['curmenu']==1 || $this->params['curmenu']==3) {?>
            <div id="fltinfo"></div>
            <?php }?> 
            <?php if($this->params['curmenu']==2) {?>
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <?=Html::a(Html::tag('i','',['class'=>'i-emp k-menu']).'Сотрудники',['empl/index'],['class'=>'k-href']);?>
		</li>
                <li>
                    <?=Html::a(Html::tag('i','',['class'=>'i-sal k-menu']).'Зарплата',['empl/sal'],['class'=>'k-href']);?>
		</li>
                <li>
                    <?=Html::a(Html::tag('i','',['class'=>'i-moff k-menu']).'Отпуска',['empl/moff'],['class'=>'k-href']);?>
		</li>
            </ul>
            <?php }?> 
            <?php if($this->params['curmenu']==4 && isset($this->params['leftmenu'])) {?>
            <table width="35%">
                <tr>
                    <td style="text-align:left; padding-right: 10px"><h4>Клиенты</h4></td>
                    <td style="text-align:left; padding-right: 10px"><?= Html::a('Добавить компанию', ['create','mode'=>'2'], ['class' => 'btn btn-info']) ?></td>
                    <td style="text-align:left; padding-right: 10px"><?= Html::a('Добавить человека', ['create','mode'=>'1'], ['class' => 'btn btn-info']) ?></td>
                </tr>
            </table>
            
            <?php }?> 
            <?php if($this->params['curmenu']==14) {?>
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <?=Html::a(Html::tag('i','',['class'=>'k-crm k-menu']).'Клиенты',['crm/index'],['class'=>'k-href']);?>
		</li>
                <li>
                    <?=Html::a(Html::tag('i','',['class'=>'k-comm k-menu']).'Коммуникации',['crm/comm'],['class'=>'k-href']);?>
		</li>
                <li>
                    <?=Html::a(Html::tag('i','',['class'=>'k-sends k-menu']).'Рассылки',['delivery/index'],['class'=>'k-href']);?>
		</li>
            </ul>
            <?php }?> 
        </div>
    </div>
</div>	
	
<div id="main" class="container-fluid sidebar-show">
    <div class="row">
        <div id="sidebar-left" class="col-xs-3">
            <?php echo isset($this->params['leftmenu']) ? $this->params['leftmenu'] : '';?>
        </div>
        <div  id="content" class="col-xs-12">
            <?php echo $content ;?>
        </div>
    </div>
</div>    

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
