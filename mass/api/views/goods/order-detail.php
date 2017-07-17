<?php

use common\models\CommonUtil;
use common\models\SysSet;
use common\models\Appeal;
use common\models\Address;
$user=yii::$app->user->identity;
if($user->user_guid==$model->user_guid){
    $orderType=1;
}elseif($user->user_guid==$model->seller_user){
    $orderType=2;
}
?>	
 <div style="margin-bottom:200px;position: relative;
padding-bottom: 200px">
   <ul class="mui-table-view" >
			 <li class="mui-table-view-cell " >
				<p >订单号:<?= $model->orderno ?> <span class="red mui-pull-right"><?= CommonUtil::getDescByValue('orders', 'type', $model->type) ?> </span></p>
				<p class="sub-txt">下单时间 : <?= CommonUtil::fomatTime($model->created_at)?> </p>
				<p class="sub-txt">状态 : <span class="red"><?= CommonUtil::getDescByValue('orders', 'status', $model->status) ?></span></p>
				<p class="sub-txt">买家留言 : <?= $model->remark ?></p>
			</li>
			</ul>
			<ul class="mui-table-view">
			 <li class="mui-table-view-cell " >
				<p ><?= $model->user->name ?> <span class="mui-pull-right"><?= $model->user->mobile ?></span></p>
				<p class="sub-txt"><span class="mui-icon mui-icon-location"></span><?= $model->user->address ?></p>
			</li>
			</ul>
			
			<ul class="mui-table-view">
			 <li class="mui-table-view-cell " >
				<p >收货地址</p>
			</li>
			<?php 
			 if(!empty($model->address)){?>
			 <li class="mui-table-view-cell " >
				<p ><?= $model->address?></p>
			</li>
			<?php }?>
			
			<?php if($model->status==0){?>
			 <li class="mui-table-view-cell " >
			 <p ><span class="mui-icon mui-icon-plus red"></span> <a href="#address-modal">新增收货地址</a></p>
			 </li>
			 <?php }?>
			</ul>
			
		    <ul class="mui-table-view">
			 <li class="mui-table-view-cell " >
				<p >商品信息</p>
			</li>
			 <li class="mui-table-view-cell mui-media goods"  data-goodsid="<?= $model->goodsid ?>" >
				<img class="mui-media-object mui-pull-left " src="<?= yii::$app->params['photoUrl'].$goodsPhoto->path.'thumb/'.$goodsPhoto->photo?>">
					<div class="mui-media-body" style="margin-top: 15px;">
						<p> <?= $model->goods_name ?></p>
						<p class="sub-txt"><span class="red">￥<?= $model->goods->price ?></span></p>
				</div>
			</li>
			 <li class="mui-table-view-cell " >
				<p>数量:<?= $model->number ?> <span class="mui-pull-right">订单金额:￥<?= $model->amount ?></span></p>
			</li>
			
			<?php if($model->is_car==1 && ($model->status==1 || $model->status==2) ){?>
			<li class="mui-table-view-cell user-location " data-user="<?= $model->seller_user?>" >
    				<span  class="mui-icon mui-icon-location ">供货商实时位置</span>
    		</li>
    				<?php }?>
    		<?php if(($orderType==1&&$model->status==0) || ($orderType==2&&$model->status==1) ){?>
    		<li class="mui-table-view-cell down-count " data-time="<?= date("m/d/Y H:i:s",($model->updated_at+1800))?>">
				<p class="red">请在30分钟内完成支付，否则订单自动关闭.</p>
				<p class="red">支付剩余时间: <span class="J_TimeLeft prev"> <i class="minutes">00</i> 分 <i class="seconds">00</i> 秒</span>
				</p>
			</li>
    				<?php }?>
    		<?php if( $model->status==2 && (($orderType==1&&$model->is_buyer_confirm==0)||($orderType==2&&$model->is_seller_confirm==0)) ){
    		$sysSet=SysSet::find()->one();
    		$deadline=$sysSet->withdraw_deposit;
    		if($model->keep_type==2){
    		    $deadline=$sysSet->keep_expire_oil;
    		}
    		    ?>
    		<li class="mui-table-view-cell down-count " data-time="<?= date("m/d/Y H:i:s",($model->updated_at+($model->updated_at+$deadline*3600*24-time())))?>">
				<p class="red">履约期限为:<?= $deadline?>天. 请在<?= $deadline ?>天内确认履约，否则系统自动确认.</p>
				<p class="red">履约剩余时间: <span class="J_TimeLeft prev"> <i class="days">00</i> 天 <i class="hours">00</i> 时 <i class="minutes">00</i> 分 <i class="seconds">00</i> 秒</span>
				</p>
			</li>
    				<?php }?>
    			<?php if( $model->status==3 ){
    		$sysSet=SysSet::find()->one();
    		$appeal=Appeal::find()->andWhere(['user_guid'=>$user->user_guid,'orderid'=>$model->id])->orderBy('created_at desc')->one();
    		if(!empty($appeal)){
    		    ?>
    		  <li class="mui-table-view-cell  " >
				<p >您已在:<?= CommonUtil::fomatTime($appeal->created_at)?>进行过申诉，申诉理由:<?= $appeal->reason?></p>
			</li>  
    		    <?php }?>
    		<li class="mui-table-view-cell down-count " data-time="<?= date("m/d/Y H:i:s",($model->updated_at+($model->updated_at+$sysSet->keep_expire*3600*24-time())))?>">
				<p class="red">申诉期限为:<?= $sysSet->keep_expire?>天. 订单如有问题，请在<?= $sysSet->keep_expire?>天内进行申诉，超时将退回保证金，不能再进行申诉.</p>
				<p class="red">申诉剩余时间: <span class="J_TimeLeft prev"> <i class="days">00</i> 天 <i class="hours">00</i> 时 <i class="minutes">00</i> 分 <i class="seconds">00</i> 秒</span>
				</p>
			</li>
    				<?php }?>
			</ul>
			
			<?php if($model->status==2){?>
			<ul class="mui-table-view" >
			 <li class="mui-table-view-cell " >
				<p>消费记录</p>
			</li>
			<?php foreach ($oilRec as $v){?>
			<li class="mui-table-view-cell ">
				<p>使用量: <?= $v->num ?> </p>
				<p>使用时间:<?= CommonUtil::fomatTime($v->created_at)?> </p>
				<p>  状态:<span class="red"><?= CommonUtil::getDescByValue('oil_rec', 'status', $v->status)?></span> </p>
				<?php if($orderType==2 && $v->status==0){?>
				<p class="text-center"><a href="#" class="mui-btn mui-btn-danger" id="comfirm-oil" data-id="<?= $v->id?>">确认使用</a></p>
				<?php }?>
			</li>
			<?php }?>
			<?php if($model->user_guid==$user->user_guid && $leftNum>0){?>
			<li class="text-center " style="padding: 10px;">
				<input class="mui-input" type="number" placeholder="请输入使用量" id="oil-num" />
				<button class="mui-btn mui-btn-success center" id="submit-oil" data-left="<?= $leftNum?>" data-orderid="<?= $model->id ?>"> 提交使用量</button>
			</li>
			<?php }?>
			</ul>
			<?php }?>
			
			<?php if( ($orderType==1&&$model->status==0) || ($orderType==2&&$model->status==1)){?>
			<ul class="mui-table-view" style="padding-bottom: 100px;">
			 <li class="mui-table-view-cell " >
				<p>选择支付方式</p>
			</li>
			<li class="mui-table-view-cell mui-radio mui-left">
						<input name="payType" type="radio" value="wxpay">微信支付
					</li>
					<li class="mui-table-view-cell mui-radio mui-left">
						<input name="payType" type="radio" value="alipay">支付宝
					</li>
			</ul>
			<?php }?>
			
			<?php if($orderType==1 && $model->status==0){?>
			<div class="bottom-button mui-row " >
			<div class="mui-col-xs-6 cart-btn flex-center text-center" id="cancel-order" data-orderid="<?= $model->id?>">
				<a href="#">取消订单</a>
			</div>
			<div class="mui-col-xs-6 buy-btn flex-center text-center" id="pay-order" data-orderid="<?= $model->id?>">
				<a href="#">立即支付</a>
			</div>
			</div>
			<?php } elseif($model->status==2 && (($orderType==1&&$model->is_buyer_confirm==0)||($orderType==2&&$model->is_seller_confirm==0)) ){?>
			<div class="bottom-button mui-row " >
			<div class="mui-col-xs-12 cart-btn flex-center text-center" id="confirm-order" data-orderid="<?= $model->id?>">
				<a href="#">确认履约</a>
			</div>
			</div>
			<?php  }elseif($model->type==1&&$model->status==1){?>
			<!--  <div class="bottom-button mui-row " >
			<div class="mui-col-xs-12 cart-btn flex-center" id="withdraw-order" data-orderid="<?= $model->id?>">
				<a href="#">申请退还保证金</a>
			</div>
			</div> -->
			<?php }elseif($model->status==3 && $orderType==2){?>
			<div class="bottom-button mui-row " >
			<div class="mui-col-xs-12 cart-btn flex-center text-center" id="appeal-order" data-orderid="<?= $model->id?>">
				<a href="#">申诉</a>
			</div>
			</div>
			<?php }elseif($model->status==3 && $orderType==1){?>
			<div class="bottom-button mui-row " >
			<div class="mui-col-xs-6 cart-btn flex-center text-center" id="appeal-order" data-orderid="<?= $model->id?>">
				<a href="#">申诉</a>
			</div>
			<div class="mui-col-xs-6 buy-btn flex-center text-center" id="comment-order" data-orderid="<?= $model->id?>">
				<a href="#">评价</a>
			</div>
			</div>
			<?php }elseif($orderType==1&&$model->status==4){?>
			<div class="bottom-button mui-row " >
			<div class="mui-col-xs-12 cart-btn flex-center text-center" id="comment-order" data-orderid="<?= $model->id?>">
				<a href="#">评价</a>
			</div>
			</div>
			<?php }?>
			
	</div>