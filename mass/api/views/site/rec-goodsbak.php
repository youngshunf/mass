<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>
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
					<ul class="mui-table-view ">
					<?php foreach ($recGoods as $v){
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