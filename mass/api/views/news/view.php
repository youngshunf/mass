<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
?>
<style>
.mui-table-view .mui-media.user{
	padding:5px 10px;
}
.mui-table-view .user .mui-media-object{
	width:40px;
	line-height:40px;
	height:40px
}
.content{
	padding:8px;
	color:#333;
}
.sub-txt{
	font-size:12px;
	color:#999
}
</style>
 <div class="panel-white"> 
<div class="">
  <h4><?= Html::encode($model->title) ?></h4>
</div>
  
 <div class="news-info ">
  <p> <span class="glyphicon glyphicon-time" ></span><?= CommonUtil::fomatDate($model->created_at)?>
    <span class="glyphicon glyphicon-eye-open pull-right" >  <?= $model->count_view?> </span></p>
</div>
   
    <?= $model->content?>
    
    <ul class="mui-table-view">
      <li class="mui-table-view-cell mui-media " >
      精彩评论
      </li>
      <?php foreach ($comment as $v){
              ?>
    <li class="mui-table-view-cell mui-media user" >
       <?php 
       if(!empty($v->user_guid)){
           $user=User::findOne(['user_guid'=>$v->user_guid]);
       if(!empty($user->photo)){?>
				<img class="mui-media-object mui-pull-left img-responsive img-circle" class="img-responsive" src="<?= yii::$app->params['photoUrl'].$user->path.'thumb/'.$user->photo  ?>">
		<?php }else{?>
		<img class="mui-media-object mui-pull-left img-responsive img-circle"  src="<?= yii::$app->urlManager->getBaseUrl()?>/img/virtual/<?= rand(1,20)?>.png">
		<?php } }else{?>
			<img class="mui-media-object mui-pull-left img-responsive img-circle"  src="<?= yii::$app->request->baseUrl?>/img/virtual/<?= rand(1,20)?>.png">
		<?php }?>
				<div class="mui-media-body">
					<p class="" ><?= !empty($user)?@$user->name:'游客'?></p>
					<div class="content">
					<p class="" ><?= @$v->content?></p>
					
				     <span class="sub-txt mui-pull-right" >
                       <?= CommonUtil::fomatTime($v->created_at)?>
                     </span>
					</div>
				</div>
	</li>
	<?php }?>
	
	</ul>
   
   <div style="padding:8px">
   <form action="<?= Url::to(['/news/submit-comment'])?>" method="post">
   <input type="hidden" value="<?= $model->newsid?>" name="newsid">
   <div class="form-group">
   <label class="label-control">评论</label>
   <textarea class="form-control" name="content" rows="5" placeholder="留下你的精彩评论吧">
   
   </textarea>
   <p class="center"><button type="submit" class="btn btn-danger">提交</button></p>
   </div>
   
   </form>
   </div>
</div>




