<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Addatr;
use app\models\UserSearch;
use app\models\Spratr;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EmplController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // разрешаем аутентифицированному директору
                    [
                    'allow' => Yii::$app->user->identity->isDirector,
                    'roles' => ['@'],
                    ],
                    // всё остальное по умолчанию запрещено
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
        return $this->render('sal');
    }
    public function actionMoff()
    {
        return $this->render('moff');
    }
    public function actionAspr($atrid=1)
    {
        //$dataregion = [];
        //if($atrid==8) $dataregion = Spratr::find()->Where(['atrId'=>7])->all();
        //, 'dataregion'=>$dataregion
        $dataProvider = new ActiveDataProvider([
            'query' => Spratr::find()->Where(['atrId'=>$atrid]),
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
    
}
