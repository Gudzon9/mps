<?php

namespace app\controllers;

use Yii;
use app\models\Delivery;
use app\models\Deliveryresult;
use app\models\Kagent;
use app\models\KagentSearch;
use app\models\Addatr;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
//use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * DeliveryController implements the CRUD actions for Delivery model.
 */
class DeliveryController extends Controller
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
     * Lists all Delivery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Delivery::find()->orderBy(['date'=>SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Delivery model.
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
     * Creates a new Delivery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Delivery();
        if ($model->load(Yii::$app->request->post())) {
            $model->files = UploadedFile::getInstances($model, 'files');
            if ($model->upload()) {
                $fileName = [];
                foreach ($model->files as $file){
                    $fileName[] = $file->baseName . '.' . $file->extension;
                }
                $model->msgatt = implode(',', $fileName);
                //echo '>'.$model->msgatt.'<';
             } 
            //if ($model->save(false)) {
            $model->files = ''; 
            $model->save(false);
            //return var_dump($emlist);
            $this->saveDeliveryResult($model);
            $delicont = \app\models\Deliveryresult::find()
                    ->Where(['deliveryId' => $model->id])->all();
            $messages = [];
            foreach ($delicont as $cont) {
                $message = Yii::$app->mailer->compose()
                ->setFrom([$model->fromadr => $model->name])
                ->setSubject($model->subject)
                ->setHtmlBody($model->msgcont)        
                ->setTo($cont->email);
                if($model->msgatt != '') {
                    $filelist = explode(',', $model->msgatt);
                    foreach ($filelist as $onefile) {
                        $message->attach(Yii::getAlias('@webroot/files/').$onefile);
                    }    
                }
                $messages[] = $message;
            }
            if(Yii::$app->mailer->sendMultiple($messages)) {
                $model->msgerr = 0;
                $model->save(false);
            }
            
            return $this->redirect(['index',]);
                //return $this->redirect(['view', 'id' => $model->id]);
            //}               
        } else {
            $maillist = Addatr::find()
                    ->where(['tableKod'=>1,'atrKod'=>2,'tableId'=>Yii::$app->user->identity->id])
                    ->all();
            $model->userId = Yii::$app->user->identity->id;
            $model->name = Yii::$app->user->identity->fio;
            $model->fromadr = ($maillist[0]) ? $maillist[0]['content'] : '' ; 
            //Yii::$app->user->identity->email;
            $model->date = date('Y-m-d');
            $model->msgerr = -1;
            
            $searchModel = new KagentSearch();
            if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
                $filter['userId'] = Yii::$app->user->identity->id;   
            }
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filter);
            
            return $this->render('_form', [
                'maillist' => $maillist,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }        
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $delicont = new ActiveDataProvider([
            'query' => Deliveryresult::find()->With(['kagent'])->Where(['deliveryId'=>$id]),
        ]);
                //

        return $this->render('_form', [
            'model' => $model,
            'delicont' => $delicont,
        ]);
    }

    /**
     * Deletes an existing Delivery model.
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
     * Finds the Delivery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Delivery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Delivery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function createDirectory($path) {   
        //$filename = "/folder/{$dirname}/";  
        if (file_exists($path)) {  
            //echo "The directory {$path} exists";  
        } else {  
            mkdir($path, 0775, true);  
            //echo "The directory {$path} was successfully created.";  
        }
    } 
    public function actionGetemails()
    {
        $aList = explode(',', Yii::$app->request->post('keylist'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \app\models\Addatr::find()
            ->select(['content'])
            ->Where(['tableKod'=>2,'atrKod'=>2])
            ->andFilterWhere(['in','tableId',$aList])
            ->all();
    }   
    public function saveDeliveryResult($model){
        $input = explode(', ', $model->toadrs);
        $emlist = array_unique($input);
        $dataprov = Addatr::find()
                ->Where(['tableKod'=>2, 'atrKod'=>2,'content'=>$emlist])->all();
                //->andWhere('in','content',$emlist)
        
        foreach($dataprov as $atrib) {
            $delicont = new \app\models\Deliveryresult();
            $delicont->deliveryId = $model->id;
            $delicont->partnerKagentId = $atrib->tableId;
            $delicont->email = $atrib->content;
            $delicont->err = 0;
            $delicont->save(); 
        }
    }
    public function actionSeltoadr()
    {
            $post = Yii::$app->request->post();
            $searchModel = new KagentSearch();
            if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
                $filter['userId'] = Yii::$app->user->identity->id;   
            }
            /*
            if($post['phdata']=='1') {
                $filter['typeKag'] = $post['pldata'];
            }
            if($post['phdata']=='5') {
                $filter['prodKag'] = $post['pldata'];
            }
            */            
            foreach (Yii::$app->params['satr'] as $satr) {
                if($satr['atrId'] == $post['phdata']) {
                    $filter[$satr['atrName']] = $post['pldata'];
                }
            }    

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filter);
            $dataProvider->pagination->pageSize=100;
            return $this->renderPartial('fltkag', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
       
    }
    public function actionDelichek($id)
    {
        $model = $this->findModel($id);
        $mailfc = $model->fromadr;
        $tmp = explode('@', $mailfc);
        $maildom = $tmp[1]; 
        $maildp = Addatr::find()
            ->where(['tableKod'=>1,'atrKod'=>2,'tableId'=>$model->userId,'content'=>$mailfc])
            ->one();
        $mailpw = $maildp['note'];
        $bouncelist = [];
        $mbox = imap_open ("{".$maildom.":995/pop3/ssl/novalidate-cert}", $mailfc, $mailpw);
        $MC = imap_check($mbox);
        $result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
        foreach ($result as $overview) {
            if( $this->isabounce($overview->subject,$overview->from)) {
               $msg=imap_fetchbody($mbox,$overview->msgno,'1');
                preg_match("/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)/" , $msg, $matches) ;
                if($matches[0]) {
                    $bouncelist[] = $matches[0];
                }
            }
        }
        imap_close($mbox);
        //var_dump($bouncelist);
        if(count($bouncelist)>0){
            $delicont = Deliveryresult::find()->Where(['deliveryId'=>$id])->all();
            foreach ($delicont as $cont) {
                //echo $cont['email'].' = '.$cont['id'].'<br>';
                if(in_array($cont['email'],$bouncelist)){
                    //echo 'found <br>';
                    $curritem = Deliveryresult::findOne($cont['id']);
                    $curritem->err = 2;
                    $curritem->save();
                    //echo 'save '.$curritem->err.'<br>';
                }
            }
            $delierr = Deliveryresult::find()->Where(['deliveryId'=>$id,'err'=>2])->count();
            $model->msgerr = $delierr;
            $model->save();
        }
        
        return $this->redirect(['update','id'=>$id]);
    }
    public function isabounce($Subject,$From)
    {
        if (preg_match("/(mail delivery failed|failure notice|warning: message|delivery status notif|delivery failure|delivery problem|spam eater|returned mail|undeliverable|returned mail|delivery errors|mail status report|mail system error|failure delivery|delivery notification|delivery has failed|undelivered mail|returned email|returning message to sender|returned to sender|message delayed|mdaemon notification|mailserver notification|mail delivery system|nondeliverable mail|mail transaction failed)|auto.{0,20}reply|vacation|(out|away|on holiday).*office/i", $Subject)) return true;
        if (preg_match("/^(postmaster|mailer-daemon)\@?/i", $From)) return true;
        return false;
    }
    
}
