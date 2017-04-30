<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>

    <ul class="mui-table-view ">
		<li class="mui-table-view-cell" >
		<p>
		<a href="#" class="sub-txt active"><?=$loveCate->name?></a>
		<a href="#" class="sub-txt" id="latest-info">最新</a> </p>
		</li>
		<?php foreach ($goods as $v){
		    $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
		    ?>
		<li class="mui-table-view-cell mui-media goods" data-id="<?= $v->id?>">
		<a href="javascript:;">
			<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>">
			<div class="mui-media-body">
				<p><?= $v->name?></p>
				<?php if($v->type==0){?>
				<p><span class="red">￥ <?= $v->price ?></span>  <?= $v->unit?></p>
				<?php }?>
				<p class='mui-ellipsis sub-txt'><?= $v->desc?></p>
			</div>
		</a>
		</li>
		<?php }?>
			
	</ul>
