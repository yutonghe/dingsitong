<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"./oscshop/merchant\view\index\index.html";i:1508405467;s:40:"./oscshop/merchant\view\public\base.html";i:1508404862;}*/ ?>
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
					<h4 class="M2"><span></span>代扣</h4>
					<div class="list-item none">
						<a href=''>代扣</a>
						<a href=''>子协议延期</a>
					</div>
				</li>
				<li>
					<h4 class="M3"><span></span>代付 </h4>
					<div class="list-item none">
						<a href=''>单笔代付</a>
					</div>
				</li>
				<li>
					<h4 class="M4"><span></span>账户管理</h4>
					<div class="list-item none">
						<a href=''>账户查询</a>
						<a href=''>出账明细</a>
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
				
<div class="row" style="margin-top:30px;">
    <div class="col-xs-3"></div>
    <form id="form" class="col-xs-6">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">银行卡号 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="cardNo" id="cardNo" value="" maxlength="25" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">用户姓名 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="name" id="name" value="" maxlength="32" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">身份证号 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="idCardNo" id="idCardNo" value="" maxlength="18" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">手机号 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="phoneNo" id="phoneNo" value="" class="form-control" maxlength="11"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">金额(元) </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="amount" id="amount" value="" class="form-control" maxlength="11"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">扣款目的 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="purpose" id="purpose" class="form-control" value="" maxlength="32"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">子协议 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="subContractId" id="subContractId" value="" class="form-control col-sm-8" maxlength="11" style="width:66.66666666666%"/>
                        <button id="scOrder" class="btn btn-sm btn-primary col-sm-4" style="height:34px">获取子协议</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-left">订单号 </label>
                <div class="col-sm-10">
                    <div class="clearfix">
                        <input type="text" name="orderId" id="orderId" class="form-control" readonly value="<?php echo $order; ?>"/>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group" style="margin-top:20px;">
            <label class="col-sm-2 control-label no-padding-left"> </label>
            <div class="col-sm-10" style="text-align: center">
                <button type="submit" id="send" class="btn btn-sm btn-primary" style="width:120px;margin-right:30px">提交</button>
                <button type="reset" id="reset" class="btn btn-sm btn-primary" style="width:120px">重置</button>
            </div>
        </div>
    </form>
</div>

			</div>
		</div>
	</div>
	<div class="bottom"></div>
	<div id="footer"><p>Copyright©  2015 版权所有 京ICP备05019125号-10  来源:<a href="http://www.qdxw.net/" target="_blank">青岛星网</a></p></div>
	<script>navList(12);</script>
	
								
	
	</body>
</html>
