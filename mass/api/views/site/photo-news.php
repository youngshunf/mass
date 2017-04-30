<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>

	<div class="swiper-wrapper" >
	<?php foreach ($goods as $item){?>
						<div class="swiper-slide">
						
						<ul class="mui-table-view mui-grid-view mui-grid-9 pic-news">
						<?php foreach ($item as $v){
						    $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
						    ?>
							<li class="mui-table-view-cell mui-media mui-col-xs-3 goods " data-id="<?= $v->id?>">
									<img src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>" class="img-responsive" />
									<p class="mui-ellipsis sub-txt"><?= @$v->name?></p>
							</li>
							<?php }?>
						</ul>
						</div>
						<?php }?>
					
					</div>
	
	