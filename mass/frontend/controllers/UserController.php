<?php

namespace frontend\Controllers;

use Yii;
use common\models\Wish;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\CommonUtil;
use common\models\Album;
use common\models\ImageUploader;
use yii\filters\AccessControl;
use common\models\Order;
use yii\data\ActiveDataProvider;
use common\models\AuctionBidRec;
use common\models\LotteryRec;
use common\models\LotteryGoods;
use common\models\Message;

/**
 * WishController implements the CRUD actions for Wish model.
 */
class UserController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout='user_layout';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
              /*   'actions' => [
                    'delete' => ['post'],
                ], */
            ],
        ];
    }
    
    /**
     * Lists all Wish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_guid=yii::$app->user->identity->user_guid;
        $model=User::findOne(['user_guid'=>$user_guid]);
        $this->layout="@frontend/views/layouts/user_layout.php";
      return $this->render('index',[
          'model'=>$model,        
      ]);
    }
    public function actionSysMessage(){
        $user_guid=yii::$app->user->identity->user_guid;
        Message::updateAll(['is_read'=>1],['to_user'=>$user_guid,'type'=>Message::SYS]);
        $dataProvider=new ActiveDataProvider([
            'query'=>Message::find()->andWhere(['to_user'=>$user_guid,'type'=>Message::SYS])->orderBy('created_at desc'),
        ]);
    
        return $this->render('sys-message',[
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Displays a single Wish model.
     * @param integer $id
     * @param string $wish_guid
     * @return mixed
     */
    
    /**
     * Creates a new Wish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUploadPhoto()
    {
      $user_guid= yii::$app->user->identity->user_guid;
       $user=User::findOne(['user_guid'=>$user_guid]);
        if($user->is_profile_done==0){
            return $this->redirect('add-user-profile');
        } 
        $model = new Album();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->wish_guid=CommonUtil::createUuid();
            $model->user_guid=$user_guid;
            $model->end_time=strtotime($_POST['end_time']);
            $model->created_at=time();
            $imgData=$_POST['imgData'];
            $imgLength=$_POST['imgLen'];
            $photo=ImageUploader::uploadImageByBase64($imgData, $imgLength);
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            
            if($model->save()){
                $album=new Album();
                $album->user_guid=$model->user_guid;
                $album->wish_guid=$model->wish_guid;
                $album->path=$model->path;
                $album->photo=$model->photo;
                $album->created_at=time();
                $album->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } 
         
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionMyOrder(){
        $user_guid= yii::$app->user->identity->user_guid;
        $is_pay=3;
        if(isset($_GET['is_pay'])){
            $is_pay=$_GET['is_pay'];
            $where=['user_guid'=>$user_guid,'is_pay'=>$is_pay];
        }else{
            $where=['user_guid'=>$user_guid];
        }
        
        $orderData=new ActiveDataProvider([
            'query'=>Order::find()->andWhere($where)->orderBy("created_at desc"),
            'pagination'=>[
                'pagesize'=>10
            ]
        ]);
        $this->layout="@frontend/views/layouts/user_layout.php";
        return $this->render('my-order',[
            'orderData'=>$orderData,
            'is_pay'=>$is_pay
        ]);
    }
    
    
    
    
    public function actionMyAuction(){
        
        $user_guid=yii::$app->user->identity->user_guid;
        $auctionData=new ActiveDataProvider([
            'query'=>AuctionBidRec::find()->andWhere(['user_guid'=>$user_guid])->orderBy("created_at desc"),
            'pagination'=>[
                'pagesize'=>10
            ]
        ]);        
        $this->layout="@frontend/views/layouts/user_layout.php";
        return $this->render('my-auction',['auctionData'=>$auctionData]);       
    }
    
    public function  actionMyLottery(){
        $user_guid=yii::$app->user->identity->user_guid;
        $dataProvider=new ActiveDataProvider([
            'query'=>LotteryRec::find()->andWhere(['user_guid'=>$user_guid])->groupBy("goods_guid")->orderBy("created_at desc"),
            'pagination'=>[
                'pagesize'=>10
            ]
        ]);
        $this->layout="@frontend/views/layouts/user_layout.php";
        return $this->render('my-lottery',['dataProvider'=>$dataProvider]);
    }
    
    public function actionViewLotteryCode($goods_guid){
        $user_guid=yii::$app->user->identity->user_guid;
        $goods=LotteryGoods::findOne(['goods_guid'=>$goods_guid]);
          $dataProvider=new ActiveDataProvider([
            'query'=>LotteryRec::find()->andWhere(['user_guid'=>$user_guid,'goods_guid'=>$goods_guid])->orderBy("created_at desc"),
            'pagination'=>[
                'pagesize'=>15
            ]
        ]);
          $this->layout="@frontend/views/layouts/user_layout.php";
          return $this->render('view-lottery-code',[
              'dataProvider'=>$dataProvider,
              'goods'=>$goods
          ]);
    }
    
    
    public function actionUpdateProfile(){
        $user_guid= yii::$app->user->identity->user_guid;
        $model=User::findOne(['user_guid'=>$user_guid]);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post()) ) {
            $model->is_profile_done=1;
            $model->birthday=date("Y-m-d",strtotime($_POST['birthday']));
            $model->age=date('Y')-date('Y',strtotime($model->birthday));
            $model->updated_at=time();
            if($model->save())
                return $this->redirect(['profile','user_guid'=>$user_guid]);
        } else {
            return $this->render('update-profile', [
                'model' => $model,
            ]);
        }
    
    }
    
    
    public function actionMyProfile(){
        
        return $this->redirect(['profile','user_guid'=>yii::$app->user->identity->user_guid]);
    }
    
    public  function actionProfile($user_guid){
        $this->layout="@frontend/views/layouts/user_layout.php";
        $model=User::findOne(['user_guid'=>$user_guid]);
        return $this->render('profile',['model'=>$model]);
    }
    
    public function actionAddUserProfile(){
        $user_guid= yii::$app->user->identity->user_guid;
       $model=User::findOne(['user_guid'=>$user_guid]);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post()) ) {
            $model->is_profile_done=1;
            $model->age=date('Y')-date('Y',strtotime($model->birthday));
            $model->created_at=time();
            if($model->save())
               return $this->redirect(['create']);
        } else {
            return $this->render('add-user-profile', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * Updates an existing Wish model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $wish_guid
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            
            if(!empty($_POST['imgData'])){
                $imgData=$_POST['imgData'];
                $imgLength=$_POST['imgLen'];
                $photo=ImageUploader::uploadImageByBase64($imgData, $imgLength);
                if($photo){
                    $model->path=$photo['path'];
                    $model->photo=$photo['photo'];
                }
            }
            $model->end_time=strtotime($_POST['end_time']);
            $model->updated_at=time();
            if($model->save()){
                $album=Album::findOne(['wish_guid'=>$model->wish_guid]);
                if(empty($album)){
                    $album=new Album();
                    $album->updated_at=time();
                }
               
                $album->user_guid=$model->user_guid;
                $album->wish_guid=$model->wish_guid;
                $album->path=$model->path;
                $album->photo=$model->photo;
                $album->created_at=time();
                $album->save();
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
          
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Wish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $wish_guid
     * @return mixed
     */
        
        
        
        
    public function actionOrderDetail($id){
        $order=WishOrder::findOne(['id'=>$id]);      
        $model=Wish::findOne(['wish_guid'=>$order->wish_guid]); 
        return $this->render('order-detail',[
            'order'=>$order,
            'model'=>$model
        ]);
    }

    /**
     * Finds the Wish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $wish_guid
     * @return Wish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wish::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
