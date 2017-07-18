<?php

use common\models\CommonUtil;

?>	
<ul class="mui-table-view">
<?php 
if(!empty($chatlist)){
    foreach ($chatlist as $k=>$v){?>
	
				<li class="mui-table-view-cell mui-media im-chat" data-to="<?= $v->from?>" data-toname="<?= empty($v['fromuser']['name'])?$v['fromuser']['mobile']:$v['fromuser']['name']?>">
					<a href="javascript:;">
					<?php if(!empty($v['fromuser'])){?>
						<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$v['fromuser']['path'].'thumb/'.$v['fromuser']['photo']?>">
						<?php }else{?>
						<img class="mui-media-object mui-pull-left" src="../../images/head/1.png">
						<?php }?>
						<div class="mui-media-body">
							<?= empty($v['fromuser']['name'])?$v['fromuser']['mobile']:$v['fromuser']['name']?>
							<p class='mui-ellipsis'><?= $v['lastmsg']['content'] ?></p>
						</div>
					</a>
				</li>
	

<?php }}else{?>
<li class="mui-table-view-cell score-rec">
	<p>暂时没有私信哦</p>
</li>

<?php }?>
</ul>