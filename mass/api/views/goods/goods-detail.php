<?php

use common\models\CommonUtil;
?>	
 
     <div class="swiper-container">
    		        <div class="swiper-wrapper" >
    		        <?php foreach ($goodsPhoto as $photo){?>
    		            <div class="swiper-slide" style="height:150px">
    		            <img class="goods-img" src="<?= yii::$app->params['photoUrl'].$photo->path.'mobile/'.$photo->photo?>"
    		             data-preview-src="<?= yii::$app->params['photoUrl'].$photo->path.$photo->photo?>"
    		             data-preview-group="1"
    		            >
    		            </div>
    		            <?php }?>
    		        </div>
    		        <div class="swiper-pagination"></div>
    		    </div>	
    		    <ul class="mui-table-view" style="padding-bottom: 100px">
    			 <li class="mui-table-view-cell " ng-click="payOrder(item)">
    				<p ><?= $model->name?></p>
    				
    				<?php if($model->type==0){?>
    				<p><span class="red">￥ <?= $model->price?></span> <span class="sub-txt"> <?= $model->unit?></span></p>
    				<p class="sub-txt">销量:<?= $model->count_sales?></p>
    				<p class="sub-txt">数量:<?= $model->stock - $model->count_sales?></p>
    				<p class="sub-txt">截止时间:<?= CommonUtil::fomatTime($model->end_time)?></p>
    				<?php }?>
    				<p class="sub-txt">收藏:<?= $model->count_love?></p>
    				<p class="sub-txt">浏览:<?= $model->count_view?></p>
    				<p class="sub-txt">加入购物车:<?= $model->count_cart?></p>
    				<p class="sub-txt">发布时间:<?= CommonUtil::fomatTime($model->created_at)?></p>
    				<?php if(!empty($model->template_fields)){
    				$fields=json_decode($model->template_fields);
    				foreach ($fields as $item){
    				    ?>
    				<p class="sub-txt"><?= $item->label?>:<?= $item->value?></p>
    				<?php } }?>
    				<?php if($model->hide_phone==0){?>
    				<p class="sub-txt">电话:<?= $model->mobile?></p>
    				<?php }?>
    				<p class="sub-txt">地址:<?= $model->address?>
    				<a href="#" id="start-nav" class="mui-icon mui-icon-location mui-pull-right">导航</a>
    				</p>
    				<p class="sub-txt">距离:<?= $distance?> Km
    				</p>
    				
    			</li>
    			<li class="mui-table-view-cell " id="template-set"  data-goodsid="<?= $model->id?>" >
    				<p ><a class="success">设置为我的模板</a></p>
    			</li>
    			<li class="mui-table-view-cell mui-media person-goods" id="person-goods" data-uid="<?= $model->user->user_guid ?>">
    				<a href="#" class="mui-navigate-right">
    				<?php if($model->user->register_type=='weixin' || $model->user->register_type=='qq'){ ?>
    				    <img class="mui-media-object mui-pull-left img-circle" src="<?= $model->user->img_path?>">
    				<?php }else if(!empty($model->photo)){?>
    				
    				<img class="mui-media-object mui-pull-left img-circle" src="<?= yii::$app->params['photoUrl'].$model->user->path.'mobile/'.$model->user->photo?>">
    				<?php }else{?>
    				<img class="mui-media-object mui-pull-left img-circle" src="<?= yii::$app->params['uploadUrl'].'avatar/unknown.jpg'?>">
    				
    				<?php }?>
    					<div class="mui-media-body">
    					   <?php if($model->hide_name==0){?>
    						<?php if($model->user->is_auth==1){?>
    						<p class="sub-txt">
        					<?php if($model->userAuth->user_type==1){?>
        					<span><?=  $model->userAuth->name?> </span>
        					<?php }elseif ($model->userAuth->user_type==2){?>
        					<span><?= $model->userAuth->company_name?> </span>
        					<?php }?> 
        					 </p>
        					 <?php }else{?>
        					 <p class="sub-txt"><?= $model->user->name?></p>
        					 <?php }?>
        					 <?php }?>
    					
    						<?php if($model->user->is_auth==1){?>
    						<p ><span class="mui-badge mui-badge-green"><?= CommonUtil::getDescByValue('user_auth', 'user_type', $model->user->user_type)?></span>
    						<span class="mui-badge mui-badge-success">已认证</span>
    						<?php }else{?>
    						<span class="mui-badge mui-badge-danger">未认证</span>
    						<?php }?>
    						</p>
    				</div>
    				</a>
    			</li>
    			 <li class="mui-table-view-cell " ng-click="payOrder(item)">
    				<h5>商品详情</h5>
    				<?= $model->desc?>
    			</li>
    </ul>