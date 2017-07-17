<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wenyuan\ueditor\Ueditor;
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/lrz.bundle.js', ['position'=> View::POS_HEAD]);
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['id'=>'news-form','options' => ['enctype' => 'multipart/form-data','onsubmit'=>'return check()']]); ?>
  
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'desc')->textarea(['rows'=>'6'])?>
    <?= $form->field($model, 'type')->dropDownList(['0'=>'购物','1'=>'信息'])->label('类型')?>
    <?= $form->field($model, 'is_car')->dropDownList(['0'=>'否','1'=>'是'])->label('是否车类')?>
    <?= $form->field($model, 'show_type')->dropDownList(['1'=>'普通','2'=>'特殊'])?>
    <?= $form->field($model, 'keep_type')->dropDownList(['1'=>'普通','2'=>'加油','3'=>'其他'])?>
      <?= $form->field($model, 'parentid')->dropDownList(ArrayHelper::map($cate, 'id', 'name'),['prompt' => '无'])->label('上级分类')?>
	
     <div class="form-group">
        <label class="control-label"> 封面图片</label>
        <div class="img-container">
        <?php if($model->isNewRecord||empty($model->photo)){?>
                <div class="uploadify-button"> 
                </div>
        <?php }else{?>
            <img alt="封面图片" src="<?= yii::$app->params['photoUrl'].'/'.$model->path.'thumb/'.$model->photo?>" class="img-responsive">
        <?php }?>
        </div>
       <input type="file" name="photo"  class="hide"  id="photo">
       </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '确定', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   		 <a href="<?= Url::to(['index'])?>" class="btn btn-warning">返回</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">


$('.img-container').click(function(){
    $('#photo').click();
})

document.getElementById('photo').addEventListener('change', function () {
    var that = this;
    lrz(that.files[0], {
        width: 300
    })
        .then(function (rst) {
            var img        = new Image();            
            img.className='img-responsive';
            img.src = rst.base64;    
            img.onload = function () {
           	 $('.img-container').html(img);
            };                 
            return rst;
        });
});

function check(){
	<?php if($model->isNewRecord){?>
    if(!$('#photo').val()){
        modalMsg('请上传照片');
        return false;
    }
    <?php }?>
  
    showWaiting('正在提交,请稍候...');
    return true;
}

$('#goodscate-parentid').change(function(){
  var that=$(this);
  var parentid=that.val();
  if(!parentid){
     return false;
  }
  console.log(parentid);
  $.ajax({
    url:'<?= Url::to('get-cate')?>',
    type:'post',
    dataType:'json',
    data:{parentid:parentid},
    success:function(res){
      var html="<option value='0'>无</option>";
      for(var i in res){
        html+='<option value="'+res[i].id+'">'+res[i].name+'</option>';
      }

      $('#secCate').html(html);
      
    },
    error:function(e){
     console.log(e);
    }
  });
})


</script>