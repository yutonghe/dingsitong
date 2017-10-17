<?php
return [
	/***********框架系统配置*************/
	//'app_trace' =>  true,
	'app_debug' => true,
	'default_module'=> 'index',	
    'url_route_on' => true,
	'url_route_must'=>  false,	
	// 是否自动转换URL中的控制器和操作名
    'url_convert'            => false,
	// 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => 'htmlspecialchars',
	
    'view_replace_str'=>[
	    '__PUBLIC__'=>'/public/static',
	    '__RES__'=>'/public/static/view_res',
	    '__ADMIN__' =>'/public/static/view_res/admin',
	    'IMG_ROOT'=>'/'
	],		
	'session'                => [
		'type'           => '',
		'auto_start'     => true,
	],	
	'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => 'osc_',        
        // cookie 保存路径
        'path'      => '/'       
    ],
		
	'URL_HTML_SUFFIX'=>'',
	//默认错误跳转对应的模板文件
	'dispatch_error_tmpl' => APP_PATH.'common/view/public/error.tpl',
	//默认成功跳转对应的模板文件
	'dispatch_success_tmpl' => APP_PATH.'common/view/public/success.tpl',

	//银生宝配置
	'yinsheng_pay' => [
		'contractId' => '1120171016165338001', //协议号
		'accountId' => '1120171016165338001', // 商户号
		'accountKey' => '123456abc', //商户秘钥
		'signSimpleSubContract' => 'http://180.166.114.155:58082/delegate-collect-front/subcontract/signSimpleSubContractJson', //子协议录入接口
		'signSimpleSubContract2' => 'http://180.166.114.155:8081/delegate-collect-front/subcontract/signSimpleSubContract', //子协议录入接口
		'collect' => 'http://180.166.114.155:8081/unspay-external/delegateCollect/collect', //代扣接口
		'queryOrderStatus' => 'http://180.166.114.155:8081/unspay-external/delegateCollect/queryOrderStatus', //订单状态查询
		'querySubContractId' => 'http://180.166.114.155:8081/unspay-external/subcontract/querySubContractId', //子协议号查询
		'subConstractExtension' => 'http://180.166.114.155:8081/unspay-external/subcontract/subConstractExtension', //子协议延期
	]
];
