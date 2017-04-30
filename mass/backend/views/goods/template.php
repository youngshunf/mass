<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模板管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

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
            'name',
            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template'=>'{view-template}{update-template}',
                'buttons'=>[
                    'view-template'=>function ($url,$model,$key){
                    return  Html::a('查看 | ', $url, ['title' => '查看商品'] );
                    },
                    'update-template'=>function ($url,$model,$key){
                    	
                    return  Html::a('编辑', $url, ['title' => '修改商品'] );
                    },
                    ],
             ],
        ],
    ]); ?>

</div>
</div>
