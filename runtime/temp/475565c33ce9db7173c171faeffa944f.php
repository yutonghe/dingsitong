<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"./oscshop/admin\view\yinsheng\index.html";i:1508234414;s:37:"./oscshop/admin\view\public\base.html";i:1508202076;}*/ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo \think\Config::get('SITE_NAME'); ?>-后台管理中心</title>

		<meta name="description" content="<?php echo \think\Config::get('SITE_NAME'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="__PUBLIC__/js/bt/bootstrap.min.css" />
		<link rel="stylesheet" href="__ADMIN__/ace/font-awesome/4.2.0/css/font-awesome.min.css" />


		<!-- ace styles -->
		<link rel="stylesheet" href="__ADMIN__/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="__ADMIN__/ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="__ADMIN__/ace/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="__ADMIN__/ace/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="__ADMIN__/ace/js/html5shiv.min.js"></script>
		<script src="__ADMIN__/ace/js/respond.min.js"></script>
		<![endif]-->
		<style>
			.table thead > tr > td, .table tbody > tr > td {
			    vertical-align: middle;
			}	
			.table thead td span[data-toggle="tooltip"]:after, label.control-label span:after {
				font-family: FontAwesome;
				color: #1E91CF;
				content: "\f059";
				margin-left: 4px;
			}
		</style>
		
		
			
		
		
		
		<script src="__PUBLIC__/js/jquery/jquery-2.0.3.min.js"></script>
		<script src="__PUBLIC__/js/jquery/jquery-migrate-1.2.1.min.js"></script>
			
		
		<script src="__PUBLIC__/artDialog/artDialog.js"></script>
		<link href="__PUBLIC__/artDialog/skins/default.css" rel="stylesheet" type="text/css" />			
		
		<script>
			var filemanager_url="<?php echo url('admin/FileManager/index'); ?>";
		</script>
		<script src="__PUBLIC__/js/oscshop_common.js"></script>
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="<?php echo url('admin/Index/index'); ?>" class="navbar-brand">
						<small>							
							<?php echo \think\Config::get('SITE_NAME'); ?> 后台管理
						</small>
					</a>
					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								
								<span class="user-info">
									<?php echo session('user_auth.username'); ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								
								<li>
									<a target="_blank" href="<?php echo \think\Request::instance()->root(true); ?>">网站前台</a>
								</li>
								
								<li>
									<a href="<?php echo url('admin/User/edit',array('id'=>session('user_auth.uid'))); ?>">修改密码</a>
								</li>
								
								<li><a href="<?php echo url('admin/Index/clear'); ?>">清空缓存</a></li>

								<li>
									<a href="<?php echo url('admin/Index/logout'); ?>">退出系统</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			
			<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
				
				<ul class="nav nav-list">
					<li class="hover">
						<a target="_blank" href="<?php echo \think\Request::instance()->root(true); ?>">
							<i class="menu-icon fa fa fa-home fa-lg"></i>
							<span class="menu-text">前台 </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>
						<b class="arrow"></b>
					</li>
					
					<?php if(is_array($admin_menu) || $admin_menu instanceof \think\Collection || $admin_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?>					
					<li class="hover <?php if(isset($breadcrumb1) AND ($breadcrumb1 == $m["title"])): ?> active open <?php endif; ?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa <?php echo $m['icon']; ?>"></i>
							<span class="menu-text"> <?php echo $m['title']; ?> </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<?php if(isset($m['children'])): ?>
						<ul class="submenu">
							
							<?php if(is_array($m['children']) || $m['children'] instanceof \think\Collection || $m['children'] instanceof \think\Paginator): if( count($m['children'])==0 ) : echo "" ;else: foreach($m['children'] as $key=>$vo): ?>   
							<li class="hover">
								<a href="<?php echo \think\Request::instance()->root(true); ?>/<?php echo $vo['url']; ?>">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo $vo['title']; if(isset($vo['children'])): ?>
										<b class="arrow fa fa-angle-down"></b>
									<?php endif; ?>
								</a>

								<b class="arrow"></b>
								
									<?php if(isset($vo['children'])): ?>
										<ul class="submenu">
											<?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v2): ?> 
												<li class="hover">
													<a href="<?php echo \think\Request::instance()->root(true); ?>/<?php echo $v2['url']; ?>">
														<i class="menu-icon fa fa-caret-right"></i>
														<?php echo $v2['title']; ?>
													</a>
			
													<b class="arrow"></b>
												</li> 
											<?php endforeach; endif; else: echo "" ;endif; ?> 
										</ul>	
									<?php endif; ?>
								
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
							
						</ul>
						<?php endif; ?>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					
				</ul><!-- /.nav-list -->

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						
<link rel="stylesheet" href="__ADMIN__/css/index.css" />
<div>
	<div class="page-header">
		<h1>
			<?php echo $breadcrumb1; ?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?php echo $breadcrumb2; ?>
			</small>
		</h1>
	</div>
	<div class="col-xs-3"></div>
	<form id="form" class="col-xs-6">
		<div class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">银行卡号 </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="cardNo" id="cardNo" value="6214837846493702" maxlength="25" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">用户姓名 </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="name" id="name" value="余统和" maxlength="32" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">身份证号 </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="idCardNo" id="idCardNo" value="450821198912055334" maxlength="18" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">手机号 </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="phoneNo" id="phoneNo" value="15814695088" class="form-control" maxlength="11"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">金额(元) </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="amount" id="amount" value="1" class="form-control" maxlength="11"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">扣款目的 </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="purpose" id="purpose" class="form-control" value="测试" maxlength="32"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-left">子协议 </label>
				<div class="col-sm-10">
					<div class="clearfix">
						<input type="text" name="subContractId" id="subContractId" value="" class="form-control col-sm-8" maxlength="11" style="width:66.66666666666%" readonly/>
						<button id="scOrder" class="btn btn-sm btn-primary col-sm-4">获取子协议</button>
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
		<div class="form-group">
			<label class="col-sm-4 control-label no-padding-left"> </label>
			<div class="col-sm-8">
				<button type="submit" id="send" class="btn btn-sm btn-primary" style="width:120px;margin-right:30px">提交</button>
				<button type="reset" id="reset" class="btn btn-sm btn-primary" style="width:120px">重置</button>
			</div>
		</div>
	</form>
</div>

					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->



			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='__ADMIN__/ace/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='__ADMIN__/ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='__ADMIN__/ace/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='__ADMIN__/ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="__PUBLIC__/js/bt/bootstrap.min.js"></script>

		<!-- ace scripts -->
		<script src="__ADMIN__/ace/js/ace-elements.min.js"></script>
		<script src="__ADMIN__/ace/js/ace.min.js"></script>

		
<script>
	//获取订单号
	$('#scOrder').on('click', function(){
		var postdata = {
			'cardNo': $('#cardNo').val(),
			'name': $('#name').val(),
			'idCardNo': $('#idCardNo').val(),
			'phoneNo': $('#phoneNo').val(),
		};
		$.ajax({
			url: "<?php echo url('Yinsheng/get_scOrder'); ?>",
			type: 'post',
			dataType: 'json',
			data: postdata,
			success: function(res){
				if(res.result_code == '0000' && res.status == '00') {
					$('#subContractId').val(res.subContractId);
				}else{
					alert(res.result_msg);
				}
			},
			error: function(){
				alert('服务器出错');
			}
		});
		return false;
	});

	//提交
	$('#form').on('submit', function(){
		var postdata = {
			'cardNo': $('#cardNo').val(),
			'name': $('#name').val(),
			'idCardNo': $('#idCardNo').val(),
			'phoneNo': $('#phoneNo').val(),
			'amount': $('#amount').val(),
			'purpose': $('#purpose').val(),
			'subContractId': $('#subContractId').val(),
			'orderId': $('#orderId').val(),
		};
		$.ajax({
			url: "<?php echo url('Yinsheng/yinsheng_pay'); ?>",
			type: 'post',
			dataType: 'json',
			data: postdata,
			success: function(res){
				alert(res.result_msg);
				if(res.result_code == '0000') {
					$('#reset').click();
				}
			},
			error: function(){
				alert('服务器出错');
			}
		});
		return false;
	})
</script>

	</body>
</html>
