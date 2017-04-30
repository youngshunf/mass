<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>
<div class="box-container">
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
	