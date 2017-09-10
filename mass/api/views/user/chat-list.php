<?php

use common\models\CommonUtil;
use common\models\User;
use common\models\Chat;
use common\models\ChatMsg;

?>	
<ul class="mui-table-view">
<?php 
if(!empty($chatlist)){
    $user=yii::$app->user->identity;
    foreach ($chatlist as $k=>$v){
    $lastMsg=ChatMsg::find()->where(['chatid'=>$v['id']])->orderBy('created_at desc')->One();
    $sender=User::findOne(['user_guid'=>$lastMsg['from']]);
    if($user->user_guid==$lastMsg['from']){
        $to=$lastMsg['to'];
    }else{
        $to=$lastMsg['from'];
    }
    $toUser=User::findOne(['user_guid'=>$to]);
        ?>
	
				<li class="mui-table-view-cell mui-media im-chat" data-to="<?= $to?>" data-toname="<?= empty($toUser['name'])?$toUser['mobile']:$toUser['name']?>">
					<a href="javascript:;">
					<?php if(!empty($toUser)){?>
						<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$toUser['path'].'thumb/'.$toUser['photo']?>">
						<?php }else{?>
						<img class="mui-media-object mui-pull-left" src="../../images/head/1.png">
						<?php }?>
						<div class="mui-media-body">
							<?= empty($toUser['name'])?$toUser['mobile']:$toUser['name']?>
							<p class='mui-ellipsis'><?= $lastMsg['content'] ?></p>
						</div>
					</a>
				</li>
	

<?php }}else{?>
<li class="mui-table-view-cell score-rec">
	<p>暂时没有私信哦</p>
</li>

<?php }?>
</ul>