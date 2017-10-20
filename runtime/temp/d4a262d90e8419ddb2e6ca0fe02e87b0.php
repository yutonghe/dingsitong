<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"./oscshop/merchant\view\index\index.html";i:1508465139;s:40:"./oscshop/merchant\view\public\base.html";i:1508463716;}*/ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo \think\Config::get('SITE_NAME'); ?>-商户自助平台</title>
		<meta name="description" content="<?php echo \think\Config::get('SITE_NAME'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="stylesheet" href="__PUBLIC__/js/bt/bootstrap.min.css" />
		<link rel="stylesheet" href="__PUBLIC__/view_res/merchant/css/style.css"/>
		
			
		

		
		<script src="__PUBLIC__/js/jquery/jquery-2.0.3.min.js"></script>
		
		<script src="__PUBLIC__/view_res/merchant/js/menu.js"></script>
	</head>
	<body class="no-skin">
	<div class="top"></div>
	<div id="header">
		<div class="logo"><?php echo \think\Config::get('SITE_NAME'); ?>-商户自助平台</div>
		<div class="navigation">
			<ul>
				<li>欢迎您！</li>
				<li><a href="">张山</a></li>
				<li><a href="">修改密码</a></li>
				<li><a href="">设置</a></li>
				<li><a href="">退出</a></li>
			</ul>
		</div>
	</div>
	<div id="content">
		<div class="left_menu">
			<ul id="nav_dot">
				<li>
					<h4 class="M4"><span></span>账户管理</h4>
					<div class="list-item none">
						<a href="<?php echo url('Index/index'); ?>">账户查询</a>
						<a href="<?php echo url('Index/list'); ?>">出账明细</a>
					</div>
				</li>
				<li>
					<h4 class="M2"><span></span>代扣</h4>
					<div class="list-item none">
						<a href="<?php echo url('Daikou/index'); ?>">代扣</a>
						<a href="<?php echo url('Daikou/moretime'); ?>">子协议延期</a>
					</div>
				</li>
				<li>
					<h4 class="M3"><span></span>代付 </h4>
					<div class="list-item none">
						<a href=''>单笔代付</a>
					</div>
				</li>

			</ul>
		</div>
		<div class="m-right">
			<div class="right-nav">
				<ul>
					<li><img src="__PUBLIC__/view_res/merchant/images/home.png"></li>
					<li style="margin-left:25px;">当前位置：</li>
					<li><a href="#"><?php echo $breadcrumb1; ?></a></li>
					<li>></li>
					<li><a href="#"><?php echo $breadcrumb2; ?></a></li>
				</ul>
			</div>
			<div class="main">
				
<table class="table table-striped table-bordered table-hover search-form">
    <thead>
    <th width="25%"><input name="starttime" type="text" placeholder="开始时间" value="" />-<input name="endtime" type="text" placeholder="结束时间" value="" /></th>
    <th width="25%"><input name="orderNo" type="text"  value="" placeholder="代扣订单号"/></th>
    <th width="25%">
        <select name="status">
            <option value="0">全部状态</option>
            <option value="1">成功</option>
            <option value="2">处理中</option>
            <option value="3">失败</option>
        </select>
    </th>
    <th width="25%"><a class="btn btn-primary" href="javascript:;" id="search" url="<?php echo url('Yinsheng/orders'); ?>" style="width:120px">查询</a></th>
    </thead>
</table>

<div class="row">
    <div class="col-xs-12">
        <div>
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>商户号</th>
                    <th>子协议号</th>
                    <th>订单号</th>
                    <th>银行卡号</th>
                    <th>手机号</th>
                    <th>用户姓名</th>
                    <th>身份证</th>
                    <th>金额(元)</th>
                    <th>状态</th>
                    <th>交易时间</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>sdf</td>
                    <td>sdf</td>
                    <td>sdf</td>
                    <td>sdf</td>
                    <td>sdf</td>
                    <td>sdf</td>
                    <td>sdf</td>
                    <td>sdf</td>
                    <th>sdf</th>
                    <td>
                      ewr
                    </td>
                    <td>sdfsd</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

			</div>
		</div>
	</div>
	<div class="bottom"></div>
	<div id="footer"><p>Copyright©  2015 版权所有 京ICP备05019125号-10</p></div>
	<script>navList(12);</script>
	
								
	
	</body>
</html>
