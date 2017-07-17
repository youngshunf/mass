<?php

use common\models\CommonUtil;
use common\models\GoodsPhoto;
?>	
 
<ul class="mui-table-view">
		<?php foreach ($goods as $v){
		   $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
		    ?>
		<li class="mui-table-view-cell">
					<div class="mui-slider-right mui-disabled">
						<a class="mui-btn mui-btn-red del-goods" data-id="<?= $v->id?>">删除</a>
						<a class="mui-btn mui-btn-green edit-goods" data-id="<?= $v->id?>">编辑</a>
					</div>
					<div class="mui-slider-handle  goods" data-id="<?= $v->id?>"style="max-width: 100%;"  >
					  <div class="cart-container-left">
					  	<img src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>" />
					  	</div>
					  	<div class="cart-container-right">
					  	<p class="mui-ellipsis"><?= $v->name?></p>
					  	<p ><span class="red">￥<?= $v->price?></span> <?= @$v->unit?></p>
					  	<p class="sub-txt"><?= CommonUtil::fomatTime($v->created_at)?></p>
					  	</div>
					  	<div class="clear"></div>
					</div>
		</li>
    <?php }?>
    </ul>
