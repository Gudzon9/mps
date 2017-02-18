<?php

namespace app\controllers;

use Yii;
use app\models\Addatr;
use app\models\Kagent;
use app\models\KagentSearch;
use app\models\Coment;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;

/**
 * KagentController implements the CRUD actions for Kagent model.
 */
class CrmController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'allow' => TRUE,
                    'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Kagent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KagentSearch();
        if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
            $filter['userId'] = Yii::$app->user->identity->id;   
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filter);
        
        //$searchModel->companyId=1;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'choiceMode' => false,
        ]);
    }

    public function actionChoice()
    {			
        $searchModel = new KagentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,Yii::$app->request->get('filter'));
        //$ui = new Ui();
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'choiceMode' => true,
        ]);
    }    
    public function actionGetRec($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Kagent::find()->where(['id'=>$id])->asArray()->one();
        return json_encode(array('id'=>$oKagent->id,'descr'=>$oKagent->name));
        //return json_encode(Kagent::find()->where(['id'=>$id])->asArray()->one());
    }    
    /**
     * Displays a single Kagent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kagent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($mode)
    {
        $model = new Kagent();
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    $this->saveAddAtr($model);
                    echo 'ok';
                }
                else{
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                    //return $model->getErrors();
                }
            }
            else{
                $model->kindKagent = 2;
                return $this->renderAjax('_form',['model' => $model,]);
            }
        }else{ 
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->saveAddAtr($model);
                $this->saveAddComent($model);
                //echo 'id '.$model->id;
                //var_dump($model->getErrors());
                return $this->render('_form', [
                    'model' => $model,
                ]);
//                return $this->redirect(['index']);
            } else {
                $model->kindKagent = $mode;
                $model->enterdate = date('Y-m-d');
                $model->regiKag = 0;
                $model->townKag = 0;
                $model->typeKag = 0;
                $model->statKag = 0;
                $model->actiKag = 0;
                $model->chanKag = 0;
                $model->deliKag = 0;
                $model->refuKag = 0;
                $model->userId = Yii::$app->user->identity->id;
                return $this->render('_form', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Kagent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionGetRel(){
        $aPost = Yii::$app->request->post();

        $model = $this->findModel($aPost['id']);
		//exit($model->id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        switch ($aPost['rel']){
            case 'Kagents':
                return $model->getKagents()->asArray()->all();
                break;
            case 'AddAtrs':
                return $model->getAddAtrs()->asArray()->all();
                break;
        }
    }
    public function actionUpdate($id=1)
    {
        $model = $this->findModel($id);
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
                    'model' => $model,
                ]);
            }
        }
        else{ 
            if ($model->load(Yii::$app->request->post()) && $model->save()) { 
                $this->saveAddAtr($model); 
                $this->saveAddComent($model);
                return $this->render('_form', [
                    'model' => $model,
                ]);
                //return $this->redirect(['index']);
            } else {
                return $this->render('_form', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Kagent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kagent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kagent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGetModel(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Kagent::find()->Where(['id'=>Yii::$app->request->post('id')])->asArray()->one();
    }
    protected function findModel($id)
    {
        if (($model = Kagent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionComm()
    {
        return $this->render('comm');
    }

    public function actionSends()
    {
        return $this->render('sends');
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
                        $addAtr->content = str_replace (' ','',$aAtrVal[$id]);
                        $addAtr->tableKod = 2;
                        $addAtr->tableId = $model->id;
                        $addAtr->atrKod = $atrKod;
                        $addAtr->note = $post['note_'.$val['atrName']][$id];;
                        if (!$addAtr->save()){
                            var_dump($addAtr->getErrors());
                        }                            
                    }   else{
                            $addAtr = Addatr::findOne($id);
                            $addAtr->content = str_replace (' ','',$aAtrVal[$id]);
                            $addAtr->note = $post['note_'.$val['atrName']][$id];
                            if (!$addAtr->save()){
                                var_dump($addAtr->getErrors());
                            }
                    }                    
                }        
            }
        }
        if (isset($post['inf_Person'])){
            $aPerson = $post['inf_Person'];
            foreach ($aPerson as $id=>$val){
                            
                $person = $this->findModel($id);
                if ($val=='del'){
                    $person->companyId = 0;
                }else{
                    $person->companyId = $model->id;
                }
                $person->save();
                echo $model->id;
            }        
        }
    }
    public function saveAddComent($model){
        $post = Yii::$app->request->post();
        if (isset($post['inf_coment'])){
            $aAtr = $post['inf_coment'];
            $aAtrVal = $post['coment'];
            foreach ($aAtr as $id=>$content){
                if ($post['inf_coment'][$id]=='del' || $aAtrVal[$id]==''){
                    $addComent = Coment::findOne($id);
                    if ($addComent->id!=''){
                        $addComent->delete();                            
                    }
                } elseif($post['inf_coment'][$id]=='new'){
                    $addComent = new Coment();
                    $addComent->comentDate = $aAtrVal[$id];
                    $addComent->kagentId = $model->id;
                    $addComent->descr = $post['note_coment'][$id];;
                    if (!$addComent->save()){
                        var_dump($addComent->getErrors());
                    }                            
                }   else{
                    $addComent = Coment::findOne($id);
                    $addComent->comentDate = $aAtrVal[$id];
                    $addComent->descr = $post['note_coment'][$id];
                    if (!$addComent->save()){
                        var_dump($addComent->getErrors());
                    }
                }                    
            }        
        }
        /*
        if (isset($post['inf_Person'])){
            $aPerson = $post['inf_Person'];
            foreach ($aPerson as $id=>$val){
                            
                $person = $this->findModel($id);
                if ($val=='del'){
                    $person->companyId = 0;
                }else{
                    $person->companyId = $model->id;
                }
                $person->save();
                echo $model->id;
            }        
        }
        */
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
    public function actionSearchaddatr()
    {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $retstr = '';
        $pnum = intval(Yii::$app->request->post('pnum')) ;
        $pval = str_replace (' ','',Yii::$app->request->post('pval')) ;
        //$pval = str_replace ('_','',$pval) ;
        $adata = \app\models\Addatr::find()->Where(['atrKod'=>$pnum])->andWhere(['like','content',$pval])->all();
        foreach ($adata as $data){ $retstr .= $data->kagent->name.' , ';}
        return $retstr ;
    }
    public function actionAddeditev()
    {
        if (Yii::$app->request->isAjax){
            $post=Yii::$app->request->post();
            if($post['id']=='0') {
                $modelEvent = new \app\models\Event(); 
               //$modelEvent->load($post);
                $modelEvent->id_klient = $post['id_klient'];
                $modelEvent->id_type = $post['id_type'];
                $modelEvent->allDay = '';
                $modelEvent->end = $post['end'];
                $modelEvent->status = 0;
                $modelEvent->klient = $post['klient'];
                $modelEvent->type = $post['type'];
                $modelEvent->color = $post['color'];
                $modelEvent->prim = $post['prim'];
                $modelEvent->start = $post['start'];
            } else {
                $modelEvent = \app\models\Event::findOne($post['id']);
                $modelEvent->prim = $post['prim'];
                $modelEvent->start = $post['start'];
                $modelEvent->status = $post['status'];
            }
            $modelEvent->save();

            $model = $this->findModel($modelEvent->id_klient);
            return $this->renderPartial('tblevkag',['model' => $model,]);
        } else {
            return "No ajax !!!";
        }
    }
    
}
