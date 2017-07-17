<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\AdminAsset;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
$this->registerCssFile('@web/css/common.css');
$this->registerCssFile('@web/css/site.css');
$this->registerJsFile('@web/js/common.js');
$user=yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
       <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-purple sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="<?= Url::to(['site/index'])?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>众</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>大众广告</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
    

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= yii::$app->user->identity->username?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg " class="img-circle" alt="User Image">
                    <p>
                    <?= yii::$app->user->identity->username?>
                      <small><?= date("Y-m-d")?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-6 text-center">
                      <a href="<?= Url::to(['user/index'])?>">用户管理</a>
                    </div>
                    <div class="col-xs-6 text-center">
                      <a href="<?= Url::to(['goods/index'])?>">产品管理</a>
                    </div>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
<!--                     <div class="pull-left"> -->
<!--                       <a href="#" class="btn btn-default btn-flat"></a> -->
<!--                     </div> -->
                    <div class="pull-right">
                       <?= Html::a('注销', ['site/logout'], [
                                    'class'=>'btn btn-default btn-flat',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]) ?>

                    </div>
                  </li>
                </ul>
              </li>
           
            </ul>
          </div>
        </nav>
      </header>
      
       <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=yii::getAlias('@avatar')?>/unknown.jpg" class="img-circle" alt="头像">
            </div>
            <div class="pull-left info">
              <p><?= yii::$app->user->identity->username?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
          </div>
      
    
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="<?php if(yii::$app->controller->id=='site'&&yii::$app->controller->action->id=='index') echo "active";?> treeview">
              <a href="<?= Url::to(['site/index'])?>">
                <i class="fa fa-home"></i> <span>首页</span>
              </a>          
            </li>
            <?php if($user->role_id==99){?>
            <li class="<?php if(yii::$app->controller->id=='user') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>用户管理</span>
               <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if(yii::$app->controller->id=='user'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['user/index'])?>"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                 <li class="<?php if(yii::$app->controller->id=='user'&&yii::$app->controller->action->id=='auth') echo "active";?>" ><a href="<?= Url::to(['user/auth'])?>"><i class="fa fa-circle-o"></i> 用户审核</a></li>
                <li class="<?php if(yii::$app->controller->id=='user'&&yii::$app->controller->action->id=='admin') echo "active";?>" ><a href="<?= Url::to(['user/admin'])?>"><i class="fa fa-circle-o"></i> 管理员管理</a></li>
              </ul>
            </li>
            <?php }?>
            <?php if($user->role_id==97){?>
            <li class="<?php if(yii::$app->controller->id=='user') echo "active";?> treeview">
              <a href="<?= Url::to(['user/index'])?>">
                <i class="fa fa-user"></i>
                <span>用户管理</span>
               <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li>
            <?php }?>
            
            <li class="<?php if(yii::$app->controller->id=='goods') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>分类信息</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
               <ul class="treeview-menu">
                <li class="<?php if(yii::$app->controller->id=='goods'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['goods/index'])?>"><i class="fa fa-circle-o"></i> 分类管理</a></li>
                 <li class="<?php if(yii::$app->controller->id=='goods'&&yii::$app->controller->action->id=='template') echo "active";?>" ><a href="<?= Url::to(['goods/template'])?>"><i class="fa fa-circle-o"></i> 模板管理</a></li>
                <li class="<?php if(yii::$app->controller->id=='goods'&&yii::$app->controller->action->id=='goods') echo "active";?>" ><a href="<?= Url::to(['goods/goods'])?>"><i class="fa fa-circle-o"></i> 信息管理</a></li>
              </ul>
            </li>
            
            <li class="<?php if(yii::$app->controller->id=='orders') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-reorder"></i>
                <span>订单管理</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
               <ul class="treeview-menu">
                <li class="<?php if(yii::$app->controller->id=='orders'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['orders/index'])?>"><i class="fa fa-circle-o"></i> 订单管理</a></li>
                <li class="<?php if(yii::$app->controller->id=='appeal'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['appeal/index'])?>"><i class="fa fa-circle-o"></i> 申诉处理</a></li>
              </ul>
            </li>
            
            <li class="<?php if(yii::$app->controller->id=='news') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>大众新闻</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
               <ul class="treeview-menu">
                <li class="<?php if(yii::$app->controller->id=='news'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['news/index'])?>"><i class="fa fa-circle-o"></i> 分类管理</a></li>
                <li class="<?php if(yii::$app->controller->id=='news'&&yii::$app->controller->action->id=='news') echo "active";?>" ><a href="<?= Url::to(['news/news'])?>"><i class="fa fa-circle-o"></i> 新闻管理</a></li>
               
              </ul>
            </li>
              <li class="<?php if(yii::$app->controller->id=='fiance') echo "active";?> treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>财务管理</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li class="<?php if(yii::$app->controller->id=='fiance'&&yii::$app->controller->action->id=='index') echo "active";?>"><a href="<?= Url::to(['fiance/index'])?>"><i class="fa fa-circle-o"></i> 会员财务</a></li>
                <li class="<?php if(yii::$app->controller->id=='fiance'&&yii::$app->controller->action->id=='withdraw-rec') echo "active";?>" ><a href="<?= Url::to(['fiance/withdraw-rec'])?>"><i class="fa fa-circle-o"></i> 提现申请</a></li>
              </ul>
            </li>
             <li class="<?php if(yii::$app->controller->id=='setting'&&yii::$app->controller->action->id=='index') echo "active";?> treeview">
             <a href="#">
                <i class="fa fa-gear"></i>
                <span>设置</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
                <ul class="treeview-menu">
               <li class="<?php if(yii::$app->controller->id=='setting'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['setting/index'])?>"><i class="fa fa-circle-o"></i> 参数设置</a></li>
               <li class="<?php if(yii::$app->controller->id=='score-setting'&&yii::$app->controller->action->id=='index') echo "active";?>" ><a href="<?= Url::to(['score-setting/index'])?>"><i class="fa fa-circle-o"></i> 积分设置</a></li>
                <li class="<?php if(yii::$app->controller->id=='website'&&yii::$app->controller->action->id=='contact') echo "active";?>" ><a href="<?= Url::to(['website/contact'])?>"><i class="fa fa-circle-o"></i> 联系我们</a></li>
              </ul>  
            </li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      

        <div class="content-wrapper">
        <section class="content-header">
    
         <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="clear"></div>
        </section>

        <!-- Main content -->
        <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
        </section>
        </div>
    </div>

    
        <div id="overlay">
            <div class="overlay-body">
            <p class="overlay-msg"></p>
            <i class="icon-spinner icon-spin icon-2x"></i>
            </div>
            
    </div>
    
       <!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               提示
            </h4>
         </div>
         <div class="modal-body">
            	提示内容
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default"  id="modal-close"
               data-dismiss="modal">关闭
            </button>
         
         </div>
      </div><!-- /.modal-content -->
</div>
	</div><!-- /.modal -->
    

     <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>e油网</b>
        </div>
        
      </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
