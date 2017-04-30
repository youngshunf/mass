<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>

    <ul class="mui-table-view ">
	<li class="mui-table-view-cell" >
	<span class="mui-pull-right">
	<?php foreach ($cates as $v){?>
		<a href="#" class="sub-txt active goods-cate" data-cateid="<?= $v->id?>" ><?= $v->name?></a>
		<?php }?>
	</span>
	</li>
		<?php foreach ($goods as $k=>$v){
		    $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
		    ?>
		<li class="mui-table-view-cell mui-media">
		<a href="javascript:;" class="goods"  data-id="<?= $v->id?>" style="margin: 0">
			<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo  ?>">
			<div class="mui-media-body">
				<p><?= @$v->name?></p>
				<p class='mui-ellipsis sub-txt'><?= CommonUtil::cutHtml(@$v->desc,30) ?></p>
			</div>
		</a>
		</li>
		<?php }?>
		
	
	</ul>
	
	