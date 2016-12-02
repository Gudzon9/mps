<?php
namespace app\components;
use Yii;
use Closure;
use yii\i18n\Formatter;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\BaseListView;
use yii\base\Model;
use yii\grid\DataColumn;
use yii\bootstrap\Modal;


class GridView extends \yii\grid\GridView
{
    public $ui;
    public $modelName;
    public $edtType='';
    public $Edt='auto';
    protected $aColInf = [];
	
    public function run()
    {
        $id = $this->options['id'];
        $options = Json::htmlEncode($this->getOptions());
        $view = $this->getView();
        //GridViewAsset::register($view);
        $view->registerJs("jQuery('#$id').exGridView($options);");
        
        parent::run();
    }

    protected function getOptions() {
        return [
            'actionID' => Yii::$app->controller->action->id,
            'modelName' => $this->modelName,
            'URL'   => Url::to([Yii::$app->controller->id.'/']),
            'uiURL' => Url::to(['ui/apply']),
            'edtType' => $this->edtType,
            'Edt'=>$this->Edt,
        ];
    }

    public function renderItems()
    {
        $caption = $this->renderCaption();
        $columnGroup = $this->renderColumnGroup();
        $colInf	= $this->renderColInf();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();
        $tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $caption,
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
        ]);
		
        return Html::tag(false,$colInf,[]).Html::tag('table', implode("\n", $content), $this->tableOptions);
    }
    protected function initColumns()
    {
        if (empty($this->ui)){
            parent::initColumns();
        }
        else
        {
            $aUI	= $this->ui->findAll(['user_id'=>1, 'model'=>$this->modelName]);
            if (empty($this->columns)) {
                    $this->guessColumns();
            }
            $aCol=[];
            $indSort = count($this->columns);
            foreach ($this->columns as $i => $column) {
                    $indSort++;
                    $nSort  = $indSort;
                    if (is_string($column)) {
                            $column = $this->createDataColumn($column);
                    } else {
                            $column = Yii::createObject(array_merge([
                                'class' => $this->dataColumnClass ? : DataColumn::className(),
                                'grid' => $this,
                            ], $column));
                    }
                    if (property_exists($column, 'attribute' )){
                        foreach ($aUI as $rec){
                            if ($rec->attribute==$column->attribute){
                                $aParam = explode(';',$rec->value);
                                $nSort = ($aParam[1]==0)?$nSort:$aParam[1];
                                $column->visible = ($aParam[0]==1);    // ? true : false);
                            }
                        }
                        $this->aColInf[] = array('type'=>'hidden', 'class'=>'colinf', 'attribute'=>$column->attribute,
                                            'visible'=>($column->visible)?1:0,'label'=>$this->getHeaderLabel($column),'sort'=>$nSort);
                    }

                    if (!$column->visible) {
                        unset($this->columns[$i]);
                        continue;
                    }
                    $aCol[] = array('sort'=>$nSort,
                            'col'=>$column,
                            'index'=>$i);                                
                    $this->columns[$i] = $column;
            }
            usort($aCol, function($a, $b){
                    return $a['sort']-$b['sort'];
                });
            usort($this->aColInf,function($a,$b){
                    return $a['sort']-$b['sort'];
                });
            $this->columns=[];                            
            foreach ($aCol as $column){
                $this->columns[$column['index']] = $column['col'];
            }
            $this->renderColInf();
            $colUI	= Yii::createObject([
                        'class' => UIColumn::className(),
                        'grid' => $this,
                        'colInf' => $this->aColInf,
                        'contentOptions' => ['style' => 'width:1px'],
                        'headerOptions' => ['style' => 'width:1px']]);
            array_unshift($this->columns, $colUI);
        }
    }
    
    protected function renderColInf()
    {
        $content	= '';
        foreach ($this->aColInf as $Column){
                $content = $content.Html::tag('input','',$Column);
        }
        return $content;
    }
   
    // Возвращает Caption колонки, так как в описании грида мы не кидаем Caption, а он берется из модели
    protected function getHeaderLabel($column)
    {
        $provider = $column->grid->dataProvider;

        if ($column->label === null) {
            if ($provider instanceof ActiveDataProvider && $provider->query instanceof ActiveQueryInterface) {
                /* @var $model Model */
                $model = new $provider->query->modelClass;
                $label = $model->getAttributeLabel($column->attribute);
            } elseif ($provider instanceof ArrayDataProvider && $provider->modelClass !== null) {
                /* @var $model Model */
                $model = new $provider->modelClass;
                $label = $model->getAttributeLabel($column->attribute);
            } elseif ($column->grid->filterModel !== null && $column->grid->filterModel instanceof Model) {
                $label = $column->grid->filterModel->getAttributeLabel($column->attribute);
            } else {
                $models = $provider->getModels();
                if (($model = reset($models)) instanceof Model) {
                    /* @var $model Model */
                    $label = $model->getAttributeLabel($column->attribute);
                } else {
                    $label = Inflector::camel2words($column->attribute);
                }
            }
        } else {
            $label = $column->label;
        }

        return $label;
    }    
}