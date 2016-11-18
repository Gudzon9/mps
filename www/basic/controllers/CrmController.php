<?php

namespace app\controllers;

use Yii;
use app\models\Addatr;
use app\models\Kagent;
use app\models\KagentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $filters['companyId']=0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filters);
        
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$ui = new Ui();
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'choiceMode' => true,
        ]);
    }    
    public function actionGetRec($id)
    {
        $oKagent = Kagent::find()->where(['id'=>$id])->one();
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
    public function actionCreate()
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
                return $this->renderAjax('_form',['model' => $model,]);
            }
        }else{ 
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->saveAddAtr($model);
                echo 'id '.$model->id;
                var_dump($model->getErrors());
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                if ($model->load(Yii::$app->request->post())){
                    //var_dump($model->getErrors());
                }
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
                //return $this->redirect(['view', 'id' => $model->id]);
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
                        $addAtr->content = $aAtrVal[$id];
                        $addAtr->tableKod = 2;
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
}
