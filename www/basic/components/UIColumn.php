<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components;

use yii\bootstrap\Button;
use Closure;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use yii\helpers\Url;



 
class UIColumn extends \yii\grid\Column
{
    public $id;
	
    public $modalID;
	public $buttonID;
    public $colInf = [];
    
    public function init()
    {
        parent::init();
        $this->id = uniqid();
        //$this->renderColInf();
        $this->registerClientScript();
    }
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null) {
            return parent::renderHeaderCellContent();
        } else {   
            return '<a id="'.$this->id.'" href="#" name="btnParam" class="btn-xs btn-info">*</a>';
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return '';
    }

   /* protected function renderColInf()
    {
        $id         = uniqid('m');
        $idButton   = uniqid('b');
        $this->modalID=$id;
	$this->buttonID = $idButton;
        Modal::begin([
            'header' => '',
                'id'=>$id,
                'size' => 'modal-sm',]);
            foreach ($this->colInf as $column){
                $strChecked  = ($column['visible']==1)?' checked':'';
                
                echo '<input class="checkattr" type="checkbox"'.$strChecked.' name="'.$column['attribute'].'"/><label>'.$column['label'].'</label>';
                echo '<br>';
            }
            echo Html::a('Применить', [''], ['id'=>$idButton, 'class' => 'btn btn-success']);
        Modal::end();
          
        return $id;
    }*/
    public function registerClientScript()
    {
		
        $id = $this->grid->options['id'];
        $options = Json::encode([
            'name' => 'btnParam',
            'modalID' => $this->modalID,
        ]);
        $this->grid->getView()->registerJs("jQuery('#$id').exGridView('showColParam', $options);");		
		
		$js = "$('#$id').click(function(){
		$('#$this->modalID').modal('show')});";
				
        //$this->grid->getView()->registerJs($js);
        
        $js = "$('#$this->buttonID').click(function(){
                var msg='';
                $('.checkattr').each(function(){
                    if ($(this).attr('checked')){
                       msg = msg + $(this).attr('name')+'=on&';
                    }
                    else{
                       msg = msg + $(this).attr('name')+'=off&';
                    }
                });
                alert(msg);
                $('#$this->modalID').modal('hide');
                $.ajax({
                    url: '".Url::to(['ui/apply'])."',
                    type: 'POST',
                    data: msg,
                    cache: false,
                    success:function(data){
			alert(data);
                    }
                })
            });";
				
        //$this->grid->getView()->registerJs($js);
    }
}