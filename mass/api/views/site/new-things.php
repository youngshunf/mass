<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>

    <ul class="mui-table-view  ">
    <?php foreach ($goods as $v){
        $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
        ?>
						<li class="mui-table-view-cell mui-media user-list goods" data-id="<?= $v->id?>">
						<a href="javascript:;">
							<?php if($v->user->register_type=='weixin' || $v->user->register_type=='qq'){ ?>
        				    <img class="mui-media-object mui-pull-left img-circle" src="<?= $v->user->img_path?>">
        				<?php }else if(!empty($v->user->photo)){?>
        				
        				<img class="mui-media-object mui-pull-left img-circle" src="<?= yii::$app->params['photoUrl'].$v->user->path.'thumb/'.$v->user->photo?>">
        				<?php }else{?>
        				<img class="mui-media-object mui-pull-left img-circle" src="<?= yii::$app->params['uploadUrl'].'avatar/unknown.jpg'?>">
        				
        				<?php }?>
							<div class="mui-media-body">
								<p><?= $v->user->name?> <?php if($v->type==0){?><span class="mui-pull-right red"> ￥ <?= $v->price?></span><?php }?></p>
								<p class='mui-ellipsis sub-txt'><?= CommonUtil::fomatTime($v->created_at)?></p>
							</div>
							
						</a>
						 <img src="<?= yii::$app->params['photoUrl'].$photo->path.'mobile/'.$photo->photo?>" style="height: 150px;width: 100%;" class="img-responsive"/>
					    <div class="mui-content-padded">
					    	  <p><?= $v->name?></p>
					    	  <p class="sub-txt mui-ellipsis-2"><?= $v->desc?></p>
					    </div>
						</li>
			<?php }?>		
							
			</ul>