<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '修改'.$model->name.'模板';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
   <div >
   <form action="<?= Url::to(['/goods/update-template-do'])?>" method="post">
     <input type="hidden" name="id"  value="<?= $model->id?>">
     
      <div class="form-group" id="optArr">
      <?php if(count($model->template_fields)>0){?>
      <?php foreach ($model->template_fields as $v){?>
      <div class="input-group">
          <span class="input-group-addon" >栏位名称</span>
          <input type="text" class="form-control" name="labelArr[]"  value="<?= $v->label?>" placeholder="请输入栏位名称" >
        </div>
      <?php } }else{?>
      <div class="input-group">
          <span class="input-group-addon" >栏位名称</span>
          <input type="text" class="form-control" name="labelArr[]" placeholder="请输入栏位名称" >
        </div>
      
      <?php }?>
       </div>
       <p class="pull-right"><a id="addOpt" href="javascript:;"><span class="glyphicon glyphicon-plus " style="color: red;font-size:26px"> </span></a></p>
     <p class="center"><button type="submit" class="btn btn-success">提交</button></p>
   </form>
   </div>

</div>
</div>
<script>
$("#addOpt").click(function(){
    var innerHtml='<div class="input-group">\
        <span class="input-group-addon" >栏位名称</span>\
        <input type="text" class="form-control" name="labelArr[]" placeholder="请输入栏位名称" ></div>';
    $("#optArr").append(innerHtml);
});
</script>