<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>
	<div class="box-container">
				<p class="text-center box-title">精品分类</p>
				<div class="box-content">
					<ul class="mui-table-view mui-grid-view ">
					<?php foreach ($recCate as $v){?>
							<li class="mui-table-view-cell mui-col-xs-6   ">
								<div class="table-container goods-cate" data-cateid="<?= $v->id?>">
											<div class="table-cell left">
												<p class="mui-ellipsis"><?= $v->name?></p>
												<p class="sub-txt"><?= $v->desc?></p>
											</div>
											<div class="table-cell right">
												<img src="<?= yii::$app->params['photoUrl'].$v->path.$v->photo?>" class="img-responsive" />
											</div>
								</div>		
							</li>
							<?php }?>
						</ul>
				</div>
			</div>

 <div class="box-container">
		<p class="text-center box-title">大众喜欢</p>
				<div class="box-content swiper-container" id="mass-love">
					<div class="swiper-wrapper ">
					<div class="swiper-slide">
						<ul class="mui-table-view mui-grid-view mui-grid-9">
						<?php foreach ($loveGoods as $k=>$v){
						    $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
						    if($k<4){
						    ?>
							<li class="mui-table-view-cell mui-media mui-col-xs-3 goods" data-id="<?= $v->id?>">
												<p class="mui-ellipsis"><?= $v->name?></p>
            									<p class="mui-ellipsis sub-txt"> <?= $v->desc?></p>
            									<img src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>" />
            							</li>
							<?php }else{?>
									<li class="mui-table-view-cell mui-media mui-col-xs-6 goods" data-id="<?= $v->id?>">
												<p class="mui-ellipsis"><?= $v->name?></p>
            									<p class="mui-ellipsis sub-txt"> <?= $v->desc?></p>
            									<img src="<?= yii::$app->params['photoUrl'].$photo->path.'mobile/'.$photo->photo?>" />
            						</li>
							<?php }?>
						<?php }?>
						</ul>
					</div>
				</div>
				</div>
			</div>
	<div class="box-container">
				<p class="text-center box-title">诚信商家
				<a class="red mui-pull-right more-merchant" href="#" style="position: absolute; right: 10px;">更多</a>
				</p>
				<div class="box-content">
					<ul class="mui-table-view mui-grid-view ">
					<?php foreach ($authUser as $v){?>
							<li class="mui-table-view-cell mui-col-xs-6  person-goods " data-uid="<?= $v->user_guid ?>">
								<div class="table-container " >
									<div class="table-cell right" style="padding-right: 10px;">
										<?php if($v->register_type=='weixin' || $v->register_type=='qq'){ ?>
                        				    <img class="img-responsive img-circle" src="<?= $v->img_path?>">
                        				<?php }else if(!empty($v->photo)){?>
                        				
                        				<img class="img-responsive img-circle" src="<?= yii::$app->params['photoUrl'].$v->path.'thumb/'.$v->photo?>">
                        				<?php }else{?>
                        				<img class="img-responsive img-circle" src="<?= yii::$app->params['uploadUrl'].'avatar/unknown.jpg'?>">
                        				
                        				<?php }?>
									</div>
									<div class="table-cell left" >
										<p class="mui-ellipsis"><?= $v->name?></p>
										<p class="sub-txt"><?= $v->sign?></p>
									</div>
								</div>		
							</li>
						<?php }?>
						</ul>
				</div>
			</div>
	<div class="box-container">
		<p class="text-center box-title">热门商品</p>
				<div class="box-content swiper-container" id="rec-goods">
						<div class="swiper-wrapper">
                			<?php foreach ($goods as $k=>$v){?>
            						<div class="swiper-slide">
            						<ul class="mui-table-view mui-grid-view mui-grid-9">
            						<?php foreach ($v as $item){
            						    $photo=GoodsPhoto::findOne(['goodsid'=>$item->id]);
            						    ?>
            							<li class="mui-table-view-cell mui-media mui-col-xs-3 goods" data-id="<?= $item->id?>">
            									<img src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>" />
            									<p class="mui-ellipsis"><?= $item->name?></p>
            									<p class="red">￥ <?= $item->price?></p>
            							</li>
            					<?php }?>
            						</ul>
            						</div>
            				<?php }?>
            			</div>
				</div>
			</div>
			
	<div class="box-container">
				<p class="text-center box-title">新品上市</p>
				<div class="box-content" id="new-goods">
					<ul class="mui-table-view ">
					<?php foreach ($newGoods as $v){
					    $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
					    ?>
						<li class="mui-table-view-cell mui-media goods" data-id="<?= $v->id?>">
						<a href="javascript:;">
							<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>">
							<div class="mui-media-body">
								<p><?= $v->name?></p>
								<p class='mui-ellipsis sub-txt'><?= $v->desc?></p>
							</div>
						</a>
						</li>
						<?php }?>
							
					</ul>
				</div>
			</div>
		
	