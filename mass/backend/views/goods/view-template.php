<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name.'模板详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
	<p>
        <?= Html::a('编辑', ['update-template', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
      <div class="form-group">
      <?php foreach ($model->template_fields as $v){?>
      <div class="input-group">
          <span class="input-group-addon" ><?= $v->label?></span>
          <input type="text" class="form-control" placeholder="请输入" >
        </div>
        <?php }?>
      </div>
   

</div>
</div>
