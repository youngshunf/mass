<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>

	
							
										<ul class="mui-table-view ">
											<li class="mui-table-view-cell">
											大众新闻
												<span class="mui-pull-right">
                                            	<?php foreach ($newsCate as $v){?>
                                            		<a href="#" class="sub-txt active news-cate" data-cateid="<?= $v->cateid?>" ><?= $v->name?></a>
                                            		<?php }?>
                                            	</span>
											</li>
											<?php foreach ($news as $k=>$v){ ?>
                                        		<li class="mui-table-view-cell mui-media">
                                        		<a href="javascript:;" class="news"  data-newsid="<?= $v->newsid?>" style="margin: 0;">
                                        			<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$v->path.'thumb/'.$v->photo  ?>">
                                        			<div class="mui-media-body">
                                        				<p><?= @$v->title?></p>
                                        				<p class='mui-ellipsis sub-txt'><?= CommonUtil::cutHtml(@$v->content,30) ?></p>
                                        			</div>
                                        		</a>
                                        		</li>
                                        		<?php }?>
										</ul>
								
							
