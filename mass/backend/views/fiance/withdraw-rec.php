<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWallet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',
            'user.alipay',
            'amount',
            'payno',
            ['attribute'=>'status',
            'value'=>function ($model){
                return CommonUtil::getDescByValue('withdraw', 'status', $model->status);
                }
            ],
            ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            ['attribute'=>'updated_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            

            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template'=>'{pay-money}{refuse}',
                'buttons'=>[
                    'pay-money'=>function ($url,$model,$key){
                     if($model->status==1)
                        return  Html::a('付款 | ', 'javascript:;', ['title' => '付款','class'=>'pay-money','data-id'=>$model->id] );
                        },
                    'refuse'=>function ($url,$model,$key){
                    if($model->status==1)
                     return  Html::a('驳回 ', $url, ['title' => '驳回'] );
                    },
                    'bank-pay'=>function ($url,$model,$key){
                    if($model->status==1)
                        return  Html::a('银行付款', $url, ['title' => '银行付款'] );
                    },
                    ]
    ],
        ],
    ]); ?>

</div>
</div>

<!-- 导入当前环节状态 -->
<div class="modal fade" id="relationModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               付款
            </h4>
         </div>
         <div class="modal-body">
            	
              <form enctype="multipart/form-data" method="post" action="<?php echo Url::to('pay-money')?>" onsubmit="return check1()">						
        			<input type="hidden" name="_csrf" value="<?= yii::$app->request->csrfToken ?>">
        			<input type="hidden" name="payid"  value="" id="payid">
        			<label>付款单号:</label>
        			<input type="text" name="payno" id="payno"  value="" class="form-control">
        			<br>
        			<input type="submit" value="付款"  class="btn btn-success" >
        			
        		  <p id="errorImport1"></p>		
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
</div><!-- /.modal -->

<script>

$('.pay-money').click(function(){
	var payid=$(this).data('id');
	$('#payid').val(payid);
	$('#relationModal').modal('show');
 });
function check1(){
	var payno = $("#payno").val();
	if(!payno){
		$("#errorImport1").html("<font color='red'>请输入付款单号</font>");
		return false;
	}else{
		showWaiting('正在提交,请稍候...');
		return true;
	}
}
</script>