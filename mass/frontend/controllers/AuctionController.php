<?php

namespace frontend\Controllers;

use Yii;
use common\models\AuctionGoods;
use common\models\SearchAuctionGoods;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AuctionCate;
use yii\data\ActiveDataProvider;
use common\models\ImageUploader;
use common\models\CommonUtil;
use yii\filters\AccessControl;
use common\models\AuctionBidRec;
use yii\db\Exception;
use common\models\AuctionAgentBid;
use common\models\GuaranteeFee;
use common\models\Order;
use common\models\User;
use common\models\AuctionRound;
use common\models\Address;

/**
 * AuctionController implements the CRUD actions for AuctionGoods model.
 */
class AuctionController extends Controller
{
    public $enableCsrfValidation = false;
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
                    [
                    'actions' => ['index','view','preview','round'],
                    'allow' => true,
                    'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post','submit-guarantee'],
                ],
            ],
        ];
    }

     public function beforeAction($action){
         $this->layout="@frontend/views/layouts/auction_layout.php";
         CommonUtil::checkAllAuction();
         return parent::beforeAction($action);
     }
    /**
     * Lists all AuctionGoods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $now=time();
        $cateid="";
        if(isset($_GET['cateid'])){
            $cateid=$_GET['cateid'];
            $dataProvider = new ActiveDataProvider([
                'query'=>AuctionGoods::find()->andWhere(" cateid=$cateid and start_time <= $now and end_time >$now and auth_status=1")->orderBy('created_at desc'),
                'pagination'=>[
                    'pagesize'=>20
                ]
            ]);
        }else{
            $dataProvider = new ActiveDataProvider([
                'query'=>AuctionGoods::find()->andWhere("  start_time <= $now and end_time >$now and auth_status=1")->orderBy('created_at desc'),
                'pagination'=>[
                    'pagesize'=>20
                ]
                ]);
        }        
               
       
        return $this->render('index', [        
            'dataProvider' => $dataProvider,
            'cateid'=>$cateid,
            
        ]);
    }
    
    public function actionPreview()
    {
        $now=time();
        $cateid="";
        if(isset($_GET['cateid'])){
            $cateid=$_GET['cateid'];
            $dataProvider = new ActiveDataProvider([
                'query'=>AuctionGoods::find()->andWhere(" cateid=$cateid and start_time > $now and auth_status=1")->orderBy('created_at desc'),
                'pagination'=>[
                    'pagesize'=>18
                ]
            ]);
        }else{
        $dataProvider = new ActiveDataProvider([
            'query'=>AuctionGoods::find()->andWhere("  start_time > $now and auth_status=1")->orderBy('created_at desc'),
                'pagination'=>[
                    'pagesize'=>18
                ]
            ]);
        }
                 
        $this->layout="@frontend/views/layouts/preview_layout.php";
        return $this->render('preview', [
            'dataProvider' => $dataProvider,
            'cateid'=>$cateid
                ]);
    }
    
    public function actionRound(){
         $dataProvider = new ActiveDataProvider([
            'query'=>AuctionRound::find()->andWhere(['auth_status'=>1])->orderBy('sort desc,created_at desc'),
                'pagination'=>[
                    'pagesize'=>20
                ]
            ]);
         
         return $this->render('round', [
             'dataProvider' => $dataProvider,
         ]);
    }
    
    public function actionRoundView($id){
        $dataProvider = new ActiveDataProvider([
            'query'=>AuctionGoods::find()->andWhere(['roundid'=>$id])->orderBy('created_at desc'),
            'pagination'=>[
                'pagesize'=>20
            ]
            ]);
        return $this->render('round-view', [
            'dataProvider' => $dataProvider,
        ]);
        
    }
    
    public function actionFixedBuy($goods_guid){
        $goods=AuctionGoods::findOne(['goods_guid'=>$goods_guid]);
        if(empty($goods->fixed_price)){
            yii::$app->getSession()->setFlash('error','该商品没有一口价,不能一口价购买!');
            return $this->redirect(yii::$app->request->referrer);
        }
        
        $user_guid=yii::$app->user->identity->user_guid;
        //获取用户默认收货地址
        $address=Address::findOne(['user_guid'=>$user_guid,'is_default'=>1]);
        if(empty($address)){
            yii::$app->getSession()->setFlash('error','对不起,你没有设置默认收货地址!');
            return $this->redirect(yii::$app->request->referrer);
        }
        
        $order=new Order();
        $order->user_guid=yii::$app->user->identity->user_guid;
        $order->order_guid=CommonUtil::createUuid();
        $order->orderno=Order::getOrderNO(Order::TYPE_AUCTION);
        $order->type=Order::TYPE_AUCTION;
        $order->goods_name=$goods->name;
        $order->amount=$goods->fixed_price;
        $order->address_id=$address->id;
       $order->address=$address['province'].' '.$address['city'].' '.$address['district'].' '.$address['address'].' '.$address['company'].' '.$address['name'].' '.$address['phone'];
        $order->number=1;
        $order->biz_guid=$goods->goods_guid;
        $order->created_at=time();
        if($order->save()){
            return $this->redirect(['site/pay-order','order_guid'=>$order->order_guid]);
        }
    }
    
    public function actionBuyAuction($id){
        $auctionGoods=AuctionGoods::findOne($id);
        $user_guid=yii::$app->user->identity->user_guid;
        //验证用户是否是成交用户
        if($auctionGoods->status!=2||$auctionGoods->deal_user!=$user_guid){
            yii::$app->getSession()->setFlash('error','对不起,您不是成交用户,不能进行购买!');
            return $this->redirect(yii::$app->request->referrer);
        }
        
        //获取用户默认收货地址
        $address=Address::findOne(['user_guid'=>$user_guid,'is_default'=>1]);
        if(empty($address)){
            yii::$app->getSession()->setFlash('error','对不起,你没有设置默认收货地址!');
            return $this->redirect(yii::$app->request->referrer);
        }
        //抵扣金额
//         $deduction=0;
//         if(yii::$app->user->identity->role_id==2){//高级用户拍卖保证金抵扣部分支付金额
//             $guaranteeFee=GuaranteeFee::findOne(['user_guid'=>$user_guid,'goods_guid'=>$auctionGoods->goods_guid,'is_pay'=>1]);
//             if(!empty($guaranteeFee)){
//                 $deduction=$guaranteeFee->guarantee_fee;
//             }
//         }
        
        $order=new Order();
        $order->merchant_user=$auctionGoods->user_guid;
        $order->order_type=$auctionGoods->post_type;
        $order->user_guid=$user_guid;
        $order->order_guid=CommonUtil::createUuid();
        $order->orderno=Order::getOrderNO(Order::TYPE_AUCTION);
        $order->type=Order::TYPE_AUCTION;
        $order->goods_name=$auctionGoods->name;
        $order->total_amount=$auctionGoods->deal_price;
        $order->amount=$auctionGoods->deal_price;
        $order->address_id=$address->id;
        $order->address=$address['province'].' '.$address['city'].' '.$address['district'].' '.$address['address'].' '.$address['company'].' '.$address['name'].' '.$address['phone'];
        $order->number=1;
        $order->biz_guid=$auctionGoods->goods_guid;
        $order->created_at=time();
        if($order->save()){
            return $this->redirect(['site/pay-order','order_guid'=>$order->order_guid]);
        }
        
    }
    
    
    
    public function actionNewAddress(){
        $user_guid=yii::$app->user->identity->user_guid;
        Address::updateAll(['is_default'=>0],['user_guid'=>$user_guid]);
        $address=new Address();
        $address->user_guid=$user_guid;
        $address->province=$_POST['province'];
        $address->city=$_POST['city'];
        $address->district=$_POST['district'];
        $address->address=$_POST['address'];
        $address->name=$_POST['name'];
        $address->phone=$_POST['mobile'];
        $address->company=@$_POST['company'];
        $address->is_default=1;
        $address->created_at=time();
        if($address->save()){
            yii::$app->getSession()->setFlash('success','收货地址增加成功!');
        }else{
            yii::$app->getSession()->setFlash('success','收货地址增加失败!');
        }
        
        return $this->redirect(yii::$app->request->referrer);
    }
    
    
    /**
     * Displays a single AuctionGoods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $model->count_view+=1;
        $model->save();
      //  $this->layout="@frontend/views/layouts/auction_layout.php";
      
        //判断用户是否交保证金
       $guarantee=0;
        if(!yii::$app->user->isGuest){
           if( yii::$app->user->identity->role_id==3){
               $guarantee=yii::$app->user->identity->guarantee;
           }elseif( yii::$app->user->identity->role_id==2){
               $user_guid=yii::$app->user->identity->user_guid;
               $guaranteeFee=GuaranteeFee::findOne(['user_guid'=>$user_guid,'goods_guid'=>$model->goods_guid,'is_pay'=>1]);
               if(!empty($guaranteeFee)){
                   $guarantee=1;
               }
           }
        }
        
       $bidRecData=new ActiveDataProvider([
            'query'=>AuctionBidRec::find()->andWhere(['goods_guid'=>$model->goods_guid])->orderBy("price desc,created_at desc"),
            'pagination'=>[
                'pagesize'=>5
            ]
        ]);

       $auctionTimes=AuctionBidRec::find()->andWhere(['goods_guid'=>$model->goods_guid])->count();
       
        return $this->render('view', [
            'model' =>$model ,
            'cateid'=>$model->cateid,
            'guarantee'=>$guarantee,
            'bidRecData'=>$bidRecData,
           'auctionTimes'=>$auctionTimes
        ]);
    }
    
    public function actionSubmitGuarantee(){
        
        yii::$app->getUser()->setReturnUrl(yii::$app->getRequest()->referrer);
        
        $goods_guid=$_GET['goods-guid'];
        $user_guid=yii::$app->user->identity->user_guid;        
        //开始事务
        $trans=yii::$app->db->beginTransaction();      
        try{ 
        $guaranteeFee=new GuaranteeFee();
        $guaranteeFee->user_guid=$user_guid;        
        $guaranteeFee->fee_guid=CommonUtil::createUuid();
        $guaranteeFee->guarantee_fee=CommonUtil::GUARANTEE_FEE;
        $guaranteeFee->goods_guid=$goods_guid;
        $guaranteeFee->user_role=$_GET['role'];
        
        $guaranteeFee->created_at=time();
        if(!$guaranteeFee->save()) throw new Exception("insert guarantee_fee error");
        
        $order=new Order();
        $order->user_guid=$user_guid;
        $order->order_guid=CommonUtil::createUuid();
        $order->orderno=Order::getOrderNO(Order::TYPE_GUARANTEE);
        $order->type=Order::TYPE_GUARANTEE;
        $order->biz_guid=$guaranteeFee->fee_guid;
        $order->amount=$guaranteeFee->guarantee_fee;
        $order->number=1;
        $order->goods_name=CommonUtil::getDescByValue('user', 'role_id', $guaranteeFee->user_role)."-拍卖保证金";
        $order->created_at=time();
        if(!$order->save()) throw new Exception("insert Order error");
        
       /*  $user=User::findOne(['user_guid'=>$user_guid]);
        $user->role_id=$_POST['role'];
        $user->updated_at=time();
        if(!$user->save()) throw new Exception("update User error"); */
        
        $trans->commit();
        }catch (Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error',"提交保证金失败,请稍候重试!");
            return $this->redirect(yii::$app->getRequest()->getReferrer());
        }

        return $this->render("pay-guarantee",['order'=>$order,'guaranteeFee'=>$guaranteeFee]);
    }
    
  public function actionSubmitBid(){
        $user_guid=yii::$app->user->identity->user_guid;
        $goods_guid=$_POST['goods-guid'];
        $price=$_POST['bid-price'];
        $auctionGoods=AuctionGoods::findOne(['goods_guid'=>$goods_guid]);
        $auctionTimes=AuctionBidRec::find()->andWhere(['goods_guid'=>$goods_guid])->count();
        $now=time();
        if($now>$auctionGoods->end_time){
            yii::$app->getSession()->setFlash('error',"出价失败,拍卖已结束,下次早点来哦.");
            return $this->redirect(['view','id'=>$auctionGoods->id]);
        }
        if($auctionTimes==0){
            if($price<$auctionGoods->current_price){
                yii::$app->getSession()->setFlash('error',"出价失败,竞拍价格必须大于当前价格.");
                return $this->redirect(['view','id'=>$auctionGoods->id]);
            }
        }else{
            if($price<=$auctionGoods->current_price){
                yii::$app->getSession()->setFlash('error',"出价失败,竞拍价格必须大于当前价格.");
                return $this->redirect(['view','id'=>$auctionGoods->id]);
            }
        }
        if(($price-$auctionGoods->current_price)%$auctionGoods->delta_price!=0){
            yii::$app->getSession()->setFlash('error',"出价失败,竞拍价格必须为加价幅度的整数倍.");
            return $this->redirect(['view','id'=>$auctionGoods->id]);
        }
        
        //开始事务
        $transaction=yii::$app->db->beginTransaction();
        try{            
           AuctionBidRec::updateAll(['is_leading'=>0],['goods_guid'=>$goods_guid]);
            //增加出价记录
        $bidRec=new AuctionBidRec();
        $bidRec->goods_guid=$goods_guid;
        $bidRec->user_guid=$user_guid;
        $bidRec->price=$price;
        $bidRec->is_leading=1;
        $bidRec->created_at=time();
        if(!$bidRec->save()) throw new Exception(" insert db auction_bid_rec error"); 
        
        //更新拍品表
        $auctionGoods->count_auction+=1;       
        $auctionGoods->current_price=$price;
        $auctionGoods->leading_user=$user_guid;
        $auctionGoods->updated_at=time();
        if(!$auctionGoods->save()) throw new Exception(" insert db auction_goods error"); 
        
        $transaction->commit();
        
        }catch (Exception $e){
            $transaction->rollBack();
            yii::$app->getSession()->setFlash('error',"出价失败,请稍候重试!");
            return $this->redirect(['view','id'=>$auctionGoods->id]);
        }
        yii::$app->getSession()->setFlash('success',"出价成功!");
        //代理出价
        if($this->AgentBid($goods_guid)){
            yii::$app->getSession()->setFlash('success','您的出价已被超越!');
        }
        
        //系统自动加价
        if($this->AutoBid($goods_guid)){
            yii::$app->getSession()->setFlash('success','您的出价已被超越!');
        }
           
        return $this->redirect(['view','id'=>$auctionGoods->id]);
                        
    }
    
    //代理出价处理函数
    function AgentBid($goods_guid){
        
        $auctionGoods=AuctionGoods::findOne(['goods_guid'=>$goods_guid]);
        $maxAgentPrice=AuctionAgentBid::find()->andWhere(['goods_guid'=>$goods_guid,'is_valid'=>1])->max('top_price');
    
        //没有代理出价,直接返回
        if(empty($maxAgentPrice)){
            return false;
        }
        
        //当前最高出价为自己时,不做任何处理
        $auctionRec=AuctionBidRec::findOne(['goods_guid'=>$goods_guid,'is_leading'=>1]);
        if(!empty($auctionRec)&&$auctionRec->user_guid==yii::$app->user->identity->user_guid){
            return false;
        }
               
        //当前价格大于所有代理出价,则所有大代理出价均无效
        if($auctionGoods->current_price>=$maxAgentPrice){
            AuctionAgentBid::updateAll(['is_valid'=>0,'updated_at'=>time()],['goods_guid'=>$goods_guid]);
            return false;
        }
        
        $secondMaxAgentPrice=AuctionAgentBid::find()->andWhere(" goods_guid='$goods_guid' and is_valid=1 and top_price!=$maxAgentPrice ")->max('top_price');
        if (empty($secondMaxAgentPrice)){
            $bidPrice=$auctionGoods->current_price+$auctionGoods->delta_price;
        }else{
            $bidPrice=$secondMaxAgentPrice+$auctionGoods->delta_price;
        }
        
        $agentBid=AuctionAgentBid::find()->andWhere(" goods_guid ='$goods_guid' and is_valid=1 and top_price=$maxAgentPrice")->orderBy("created_at desc")->all();
        $countMax=count($agentBid);
        //只有一个最高代理价时,竞拍在第二高代理价的基础上增加一个幅度
        if($countMax==1){            
            $transaction=yii::$app->db->beginTransaction();
            try{
                AuctionBidRec::updateAll(['is_leading'=>0],['goods_guid'=>$goods_guid]);
                $bidRec=new AuctionBidRec();
                $bidRec->goods_guid=$goods_guid;
                $bidRec->user_guid=$agentBid[0]->user_guid;
                //最高代理价格小于系统保留价时,采用最高代理价
                if($maxAgentPrice<=$auctionGoods->lowest_deal_price){
                     $bidRec->price=$maxAgentPrice;  
                }else{
                    $bidRec->price=$bidPrice;
                }
                $bidRec->is_agent=1;
                $bidRec->is_leading=1;
                $bidRec->created_at=time();
                if(!$bidRec->save()) throw new Exception(" insert db auction_bid_rec error");            
                //更新拍品表
                $auctionGoods->count_auction+=1;
                $auctionGoods->current_price=$bidRec->price;
                $auctionGoods->leading_user=$bidRec->user_guid;
                $auctionGoods->updated_at=time();
                if(!$auctionGoods->save()) throw new Exception(" insert db auction_goods error");                 
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollBack();
                return false;
            }
        }else{
            //有多个最高代理价相同时,竞拍价格为最高代理价,按照后代理先出价的顺序进行出价
            $transaction=yii::$app->db->beginTransaction();
            try{
              
                foreach ($agentBid as $k=> $v){
                 AuctionBidRec::updateAll(['is_leading'=>0],['goods_guid'=>$goods_guid]);
                $bidRec=new AuctionBidRec();
                $bidRec->goods_guid=$goods_guid;
                $bidRec->user_guid=$v->user_guid;
                $bidRec->price=$maxAgentPrice;
                $bidRec->is_agent=1;
                $bidRec->is_leading=1;
                $bidRec->created_at=time()+($k*35);
                if(!$bidRec->save()) throw new Exception(" insert db auction_bid_rec error");            
                //更新拍品表
                $auctionGoods->count_auction+=1;
                $auctionGoods->current_price=$bidRec->price;
                $auctionGoods->leading_user=$bidRec->user_guid;
                $auctionGoods->updated_at=time();
                if(!$auctionGoods->save()) throw new Exception(" insert db auction_goods error");
                }
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollBack();
                return false;
            }
       
        }

        $this->AutoBid($goods_guid);
        
        return true;
        
    }
    
    public function actionSubmitAgent(){
        $goods_guid=$_POST['goods-guid'];
        $user_guid=yii::$app->user->identity->user_guid;
        $top_price=$_POST['agent-price'];
        $auctionGoods=AuctionGoods::findOne(['goods_guid'=>$goods_guid]);
        
        $auctionAgentBid=new AuctionAgentBid();
        $auctionAgentBid->user_guid=$user_guid;
        $auctionAgentBid->top_price=$top_price;
        $auctionAgentBid->goods_guid=$goods_guid;
        $auctionAgentBid->created_at=time();
        if(!$auctionAgentBid->save()){
            yii::$app->getSession()->setFlash('error',"代理出价失败,请稍候重试!");
            return $this->redirect(['view','id'=>$auctionGoods->id]);
        }
        
        yii::$app->getSession()->setFlash('success',"代理出价成功!");
        //如果是自己领先,则不做代理出价处理
        if($user_guid==$auctionGoods->leading_user){
            
            if($this->AutoBid($goods_guid)){
                yii::$app->getSession()->setFlash('success','您的出价已被超越!');
            }
        
            return $this->redirect(['view','id'=>$auctionGoods->id]);
        }
        
        if($this->AgentBid($goods_guid)){
            yii::$app->getSession()->setFlash('success','您的出价已被超越!');
        }

        return $this->redirect(['view','id'=>$auctionGoods->id]);
    }

    public function actionPayGuarantee(){
        $order_guid=$_POST['order-guid'];
        
        //模拟支付成功的处理逻辑
        $order=Order::findOne(['order_guid'=>$order_guid]);
        
        $trans=yii::$app->db->beginTransaction();
        try{            
            $order->is_pay=1;
            $order->pay_time=time();
            $order->updated_at=time();
            if(!$order->save()) throw new Exception("update order error");
            
            $guaranteeFee=GuaranteeFee::findOne(['fee_guid'=>$order->biz_guid]);
            $guaranteeFee->is_pay=1;
            $guaranteeFee->updated_at=time();
            if(!$guaranteeFee->save()) throw new Exception();
            
            $user=User::findOne(['user_guid'=>$order->user_guid]);
            
            $user->role_id=$guaranteeFee->user_role;
            if($user->role_id==3){
                $user->guarantee=1;
            }
            $user->updated_at=time();
            if(!$user->save()) throw new Exception();   
                     
            $trans->commit();
        }catch(Exception $e){
            $trans->rollBack();
  /*           yii::$app->getSession()->setFlash('error',"支付失败!");
            return $this->redirect(['site/pay-result','order_guid'=>$order_guid]); */
        }
               
        return $this->redirect(['site/pay-result','order_guid'=>$order_guid]);
        
    }
    
  public function AutoBid($goods_guid){
      $auctionGoods=AuctionGoods::findOne(['goods_guid'=>$goods_guid]);
      //如果当前价格小于最低成交价格,系统自动出价
      if($auctionGoods->current_price<$auctionGoods->lowest_deal_price){
          $transaction=yii::$app->db->beginTransaction();
          try{
            
            $virtualUser=User::findOne(['role_id'=>0,'goods_guid'=>$goods_guid]);
            if(empty($virtualUser)){
              //新建虚拟用户
              $virtualUser=new User();
              $virtualUser->user_guid=CommonUtil::createUuid();
              $virtualUser->mobile=CommonUtil::getRandomMobile();
              $virtualUser->role_id=0;
              $virtualUser->goods_guid=$goods_guid;
              $virtualUser->img_path=yii::$app->params['virtualAvatarUrl'].rand(1, 20).'.png';
              $virtualUser->password=md5('123456');
              $virtualUser->created_at=time();
              if(!$virtualUser->save()) throw new Exception();
            }
            
          AuctionBidRec::updateAll(['is_leading'=>0],['goods_guid'=>$goods_guid]);
          //增加出价记录
          $bidRec=new AuctionBidRec();
          $bidRec->goods_guid=$goods_guid;
          $bidRec->user_guid=$virtualUser->user_guid;
          $bidRec->price=intval($auctionGoods->current_price)+intval($auctionGoods->delta_price);
          $bidRec->is_leading=1;
          $bidRec->created_at=time()+1;
          if(!$bidRec->save()) throw new Exception(" insert db auction_bid_rec error");
          
          //更新拍品表
          $auctionGoods->count_auction+=1;
          $auctionGoods->current_price=$bidRec->price;
          $auctionGoods->leading_user=$virtualUser->user_guid;
          $auctionGoods->updated_at=time();
          if(!$auctionGoods->save()) throw new Exception(" insert db auction_goods error");
          
          $transaction->commit();
          return  true;
          
          }catch (Exception $e){
              $transaction->rollBack();
              return false;
          }
          
      }
      
      return false;
  }

        
    


    protected function findModel($id)
    {
        if (($model = AuctionGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
