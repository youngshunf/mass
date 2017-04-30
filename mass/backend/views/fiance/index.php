<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWallet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '财务管理';
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
        'filterModel' => $searchModel,
       'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'balance',
            'paid',
            //'total_amount',
            'frozen',

            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template'=>'{view}'
    ],
        ],
    ]); ?>

</div>
</div>