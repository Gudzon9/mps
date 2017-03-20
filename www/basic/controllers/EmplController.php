<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Addatr;
use app\models\UserSearch;
use app\models\Spratr;
use app\models\Kagent;
use app\models\Tabl;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

//use yii\filters\VerbFilter;

class EmplController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'allow' => Yii::$app->user->identity->isDirector,
                    'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
/*
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest){
            return $this->goHome();
        }
        return parent::beforeAction($action);
    }
 * 
 */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sprprov = Spratr::find();
        $regions = $sprprov->Where(['atrId'=>'7'])->all();
        $towns = $sprprov->Where(['atrId'=>'8'])->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
            'regions' => $regions, 
            'towns' => $towns,
        ]);
    }
    public function actionSal()
    {
       $curym = date("Ym");
        if (\Yii::$app->request->post('skt')) {
            $skt = \Yii::$app->request->post('skt');
        } else {
            $skt = $curym;
        }
        $amonts = Tabl::find()->select(['yearmont'])->groupBy(['yearmont'])->orderBy(['yearmont'=>SORT_DESC])->asArray()->all();
        $flag = true ;
        foreach ($amonts as $ym) {
            if($ym['yearmont']==$curym) {$flag = false;}
        }
        if($flag) {
            array_unshift($amonts,['yearmont'=>$curym]);
        }
        $query = Tabl::find()->Where(['yearmont'=>$skt])->all();
        $actabl = ArrayHelper::map($query,'ls','ls');
        $newemp = User::find()->Where(['not in','id',$actabl])->all();
        return $this->render('sal',['qmonts'=>$amonts, 'query'=>$query, 'skt'=>$skt, 'newemp'=>$newemp]);
    }
    public function actionActitabl()
    {
        $act = Yii::$app->request->post('act');
        $ym = Yii::$app->request->post('ym');
        $data = Yii::$app->request->post('data');
        switch ($act) {
            case 1 :
                $query = Tabl::find()->Where('yearmont < :curym',[':curym'=>$ym])
                    ->orderBy(['yearmont'=>SORT_DESC])->limit(1)->all(); 
                if(count($query)) {
                    $oldym = $query[0]->yearmont;
                    \Yii::$app->db->createCommand('INSERT INTO `tabl` (`name`,`yearmont`,`ls`) SELECT name,:curym as yearmont, ls FROM tabl WHERE yearmont = :oldym ', [':curym' => $ym,':oldym' => $oldym])->execute();
                }
                break;
            case 2 :
		$alines = explode(";",$data);
		foreach($alines as $line){
			$als = explode(",",$line);
			$id = $als[0];
			$adays = explode("_",$als[1]);
			$mcl="UPDATE tabl SET "; $i=0;
			foreach($adays as $day){
				$dv = explode("-",$day); $i++;
				$mcl.= (($i>1) ? ",":"").(($dv[0]<10) ? "d0":"d" ).$dv[0]."=".$dv[1] ;
			}
			$mcl.= " WHERE id='$id' ";
                        \Yii::$app->db->createCommand($mcl)->execute();
		}
                break;
            case 3 :
                $query = User::findOne($data); 
                if($query) {
                    \Yii::$app->db->createCommand('INSERT INTO `tabl` (`name`,`yearmont`,`ls`) VALUES (:name,:curym,:ls)', [':curym' => $ym,':name' => $query->fio,':ls' => $query->id])->execute();
                }
                break;
            case 4 :
                \Yii::$app->db->createCommand('DELETE FROM `tabl` WHERE id = :ls ', [':ls' => $data])->execute();                
                break;
        }
        return 'ok';
    }
    public function actionMoff()
    {
        return $this->render('moff');
    }
    public function actionAspr($atrid=1)
    {
        if(Yii::$app->params['satr'][$atrid]['atrType']=='one') {
            $cond = 'kagent.'.Yii::$app->params['satr'][$atrid]['atrName'].' = spratr.id';
            $query = Spratr::find()
                ->Select(['spratr.*','sum(kagent.id IS NOT NULL) as cnt'])
                ->leftJoin('kagent', $cond )
                ->Where(['atrId'=>$atrid])
                ->groupBy(['spratr.id']);
        } else {
            $query = Spratr::find()->Where(['atrId'=>$atrid]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('lstspr', [
            'dataProvider' => $dataProvider, 'atrid'=>$atrid,
        ]);
    }
    public function actionUpdspr($id)
    {
        $model = Spratr::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['aspr', 'atrid' => $model->atrId]);
        } else {
            if($model->atrId == 8) {
                $regions = Spratr::find()->Where(['atrId'=>'7'])->all();
            } else {
                $regions = null;
            }    
            return $this->render('frmspr', [
               'model' => $model, 'regions' => $regions,
            ]);
        }    
    }
    public function actionDelespr($id)
    {
        $model = Spratr::findOne($id);
        $fld = \Yii::$app->params['satr'][$model->atrId]['atrName'];
        
        if (Yii::$app->params['satr'][$model->atrId]['atrType']=='one') {
            Kagent::updateAll([ $fld => 0], $fld.'='.$model->id);
        } else {
            foreach (Kagent::find()->Where(['like',$fld,'['.$model->id.']'])->all() as $kag) {
                $modelkag = Kagent::findOne($kag['id']);
                $tmparr = explode(',', $modelkag->$fld);
                $key = array_search('['.$model->id.']', $tmparr);
                if ($key !== false) {
                    unset($tmparr[$key]);
                }
                $tmpval = implode(',', $tmparr);
                $modelkag->$fld = $tmpval;
                $modelkag->update();
            }
        }
        $model->delete();
        return $this->redirect(['aspr', 'atrid' => $model->atrId]);
    }
    public function actionNewspr($atrid=1)
    {
        $model = new Spratr();
        $model->atrId = $atrid;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['aspr', 'atrid' => $model->atrId]);
        } else {
            if($model->atrId == 8) {
                $regions = Spratr::find()->Where(['atrId'=>'7'])->all();
            } else {
                $regions = null;
            }    
            return $this->render('frmspr', [
               'model' => $model, 'regions' => $regions,
            ]);
        }    
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate()
    {
        $model = new User();
        //->select(['id','descr'])
        $sprprov = Spratr::find();
        $regions = $sprprov->Where(['atrId'=>'7'])->all();
        $towns = $sprprov->Where(['atrId'=>'8'])->all();
        
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    $this->saveAddAtr($model);
                    echo 'ok';
                }
                else{
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            else{
                return $this->renderAjax('_form',[
                    'model' => $model, 'regions' => $regions, 'towns' => $towns, 
                ]);
            }
        }else{ 
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 $this->saveAddAtr($model);
                return $this->redirect(['index']);
            } else {
                //var_dump($model->getErrors());
                return $this->render('_form', [
                    'model' => $model, 'regions' => $regions, 'towns' => $towns,
                ]);
            }
        }
    }
    public function actionUpdate($id=1)
    {
        $model = $this->findModel($id);
        $sprprov = Spratr::find();
        $regions = $sprprov->Where(['atrId'=>'7'])->all();
        $towns = $sprprov->Where(['atrId'=>'8'])->all();
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    $this->saveAddAtr($model);
                    echo 'ok';
                }
                else{
                    //var_dump($model->getErrors());
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            else{
                return $this->renderAjax('_form',[
                    'model' => $model, 'regions' => $regions, 'towns' => $towns,
                ]);
            }
        }
        else{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->saveAddAtr($model);
                return $this->redirect(['index']);
            } else {
                //var_dump($model->getErrors());
                return $this->render('_form', [
                    'model' => $model, 'regions' => $regions, 'towns' => $towns,
                ]);
            }
        }
    }
    public function saveAddAtr($model){
        $post = Yii::$app->request->post();
        foreach (Yii::$app->params['aatr'] as $atrKod=>$val){
            if (isset($post['inf_'.$val['atrName']])){
                $aAtr = $post['inf_'.$val['atrName']];
                $aAtrVal = $post[$val['atrName']];
                foreach ($aAtr as $id=>$content){
                    if ($post['inf_'.$val['atrName']][$id]=='del' || $aAtrVal[$id]==''){
                        $addAtr = Addatr::findOne($id);
                        if ($addAtr->id!=''){
                            $addAtr->delete();                            
                        }
                    } elseif($post['inf_'.$val['atrName']][$id]=='new'){
                        $addAtr = new Addatr();
                        $addAtr->content = $aAtrVal[$id];
                        $addAtr->tableKod = 1;
                        $addAtr->tableId = $model->id;
                        $addAtr->atrKod = $atrKod;
                        $addAtr->note = $post['note_'.$val['atrName']][$id];;
                        if (!$addAtr->save()){
                            var_dump($addAtr->getErrors());
                        }                            
                    }   else{
                            $addAtr = Addatr::findOne($id);
                            $addAtr->content = $aAtrVal[$id];
                            $addAtr->note = $post['note_'.$val['atrName']][$id];
                            if (!$addAtr->save()){
                                var_dump($addAtr->getErrors());
                            }
                    }                    
                }        
            }
        }
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionSearchempl()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \app\models\User::find()->select(['id','fio as value'])->Where(['like','fio',Yii::$app->request->get('term')])->limit(20)->asArray()->all();
    }
    public function actionSearchklient()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \app\models\Kagent::find()->select(['id','name as value'])->Where(['like','name',Yii::$app->request->get('term')])->limit(20)->asArray()->all();
    }
    public function actionSetallkag()
    {
        if(Yii::$app->request->isAjax && Yii::$app->user->identity->isDirector) {
            $session = Yii::$app->session;
            if (!$session->isActive) $session->open();
            $session->set('allkag',intval(Yii::$app->request->post('state')) ); 
            return 'ok';
        } else {
            return 'canc';
        }
    }
    
}
