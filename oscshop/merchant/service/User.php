<?php
/**
 * oscshop2 B2C电子商务系统
 *
 * ==========================================================================
 * @link      http://www.oscshop.cn/
 * @copyright Copyright (c) 2015-2016 oscshop.cn. 
 * @license   http://www.oscshop.cn/license.html License
 * ==========================================================================
 *
 * @author    李梓钿
 *
 */ 
namespace osc\merchant\service;
use think\Db;
//用户数据
class User{
	
	function is_login(){
				
		$user=('session'==config('merchant_login_type'))?session('merchant_user_auth'):cookie('merchant_user_auth');
		$user_auth_sign=('session'==config('merchant_login_type'))?session('merchant_user_auth_sign'):cookie('merchant_user_auth_sign');

	    if (empty($user)) {
	        return 0;
	    } else {
	        return $user_auth_sign == data_auth_sign($user) ? $user['uid'] : 0;
	    }
		
	}
	
	function logout(){
		
		if('session'==config('merchant_login_type')){
			session('merchant_user_auth',null);
		}elseif('cookie'==config('merchant_login_type')){
			cookie('merchant_user_auth', null);
		}
	}	
	
	function user_info($uid=UID){		
		return Db::name('merchant')->where('id',$uid)->find();
	}

}
?>