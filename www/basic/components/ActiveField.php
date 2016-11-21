<?php

//namespace yii\widgets;
namespace app\components;
use Yii;
use yii\base\InvalidCallException;
use yii\base\Widget;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;

//namespace app\components;

class ActiveField extends \yii\widgets\ActiveField
{
    public $template = "{label}\n{input}\n{hint}\n{error}\n{txtbtn}";

    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{txtbtn}'])) {
                $this->inputTextBtn(false);
            }
        }
        return parent::render($content);
    }
    
    public function inputTextBtn($tblName=null, $fldName=null, $options = [])
    {       
        if ($tblName === false) {
            $this->parts['{txtbtn}'] = '';
            return $this;
        }
        
        //$options = array_merge($this->inputOptions, $options);
        $this->parts['{input}'] = '';
        $this->adjustLabelFor($options);
        //$urlChoice = Url::to([$tblName.'/']);
        $urlChoice = Url::to([Yii::$app->controller->id.'/']);
        $idFld = uniqid();
        //Html::getInputId($this->model,$this->attribute);
        $nameFld = Html::getInputName($this->model,$this->attribute);
        $outVal = (is_object($this->model->$tblName)?Html::getAttributeValue($this->model->$tblName, $fldName):'');
        $optionsInput = array_merge($this->inputOptions, $options,
            ['style'=>'padding: 6px 0px 0px 12px;cursor:pointer; background:#fff', 'class'=>'form-control btnChoice',
                'id'=>$idFld,
                'name'=>$nameFld]);
        if (!isset($options['value'])){
            $options['value'] = Html::getAttributeValue($this->model, $this->attribute);
        }
        $content = Html::tag('td',Html::tag('label',$outVal,['id'=>'lbl'.$idFld]),['style'=>'width:98%; border:none']);
        $content = $content.Html::tag('td',Html::tag('button','...',['style'=>'border:none; background:#fff']),['style'=>'width:2%; border:none']);
        $content = Html::tag('tr',$content,['style'=>'border:none; width:100%']);
        $content = Html::tag('table',$content,['style'=>'border:none']);
        
        //$content = Html::tag('label',$outVal,['id'=>$idFld]);
        $options['id'] = $idFld;
        $content = $content.Html::activeInput('hidden', $this->model, $this->attribute, $options);

        $this->parts['{input}'] = Html::tag('div',$content,$optionsInput);
        $idDlg = uniqid();
        $script = <<< JS
                if (typeof aSelDlg == "undefined") {
                    var aSelDlg = new Array();
                }
                $('#$idFld.btnChoice').click(function(){
                    var idDlg = 'modal'+'$idDlg';
                    
                    var id = '$idFld';
                    var div = $('div#'+id);        
                    $(document).find('#'+idDlg).remove();
                    var dlg = $('<div/>').attr({id:idDlg});
                    var url = '$urlChoice';
                    aSelDlg[aSelDlg.length] = {'id':idDlg,'selField':id,'url':url,'grid':''};
                    $.ajax({
                        url: url+'/choice',
                        type: 'get',
                        success: function (response) {
                            dlg.append(response);
                            aSelDlg[aSelDlg.length-1].grid = dlg.find('.grid-view').attr('id');
                            dlg.dialog({'modal':true, 'width':'auto'});
                        }
                    });
                });
JS;
        $view = $this->form->getView();
        $view->registerJs($script,yii\web\View::POS_END);
        return $this;
    }
}