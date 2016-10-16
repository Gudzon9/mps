<?php
use yii\widgets\Menu;
?>
<div class="panel panel-primary">
    <div class="panel-heading">Клиенты</div>    

<?=Menu::widget([
'options' => ['class' => 'sidebar-menu treeview'],
'items' => [

    ['label' => 'Menu 1', 'url' => ['/a/index']],
    ['label' => 'Menu 2', 'url' => ['/link2/index']],
    ['label' => 'Submenu',  
        'url' => ['#'],
        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
        'items' => [
            ['label' => 'Action', 'url' => '#'],
            ['label' => 'Another action', 'url' => '#'],
            ['label' => 'Something else here', 'url' => '#'],
        ],
    ],
],
'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
'encodeLabels' => false, //allows you to use html in labels
'activateItems' => false,
'activateParents' => false,   ]);  
?>
</div>
