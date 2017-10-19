<?php
/**
 *
 * @author    李梓钿
 *会员中心
 */
namespace osc\common\controller;
use think\Db;
class MerchantBase extends Base{
	
	protected function _initialize() {
		parent::_initialize();

		define('UID', osc_service('merchant', 'user')->is_login());
		if(!UID){
		//	$this->redirect('Index/index');
		}
	}

	//登录验证
	protected function validate_login($data){

		if(empty($data['username'])){
			return ['error'=>'用户名必填'];
		}elseif(empty($data['password'])){
			return ['error'=>'密码必填'];
		}

		if(1==config('use_captcha')){
			if(!check_verify($data['captcha'])){
				return ['error'=>'验证码错误'];
			}
		}

		$user=Db::name('member')->where('username',$data['username'])->find();

		if(!$user){
			return ['error'=>'账号不存在！！'];
		}elseif(($user['checked']==0)&&(1==config('reg_check'))){//需要审核
			return ['error'=>'该账号未审核通过！！'];
		}

		if(think_ucenter_encrypt($data['password'],config('PWD_KEY'))==$user['password']){

			$auth = array(
				'uid'             => $user['uid'],
				'username'        => $user['username'],
				'nickname'        => $user['nickname'],
				'group_id'		  => $user['groupid'],
			);

			$this->refresh_member($auth);

			$login['lastdate']=time();
			$login['loginnum']		=	array('exp','loginnum+1');
			$login['lastip']	=	get_client_ip();

			DB::name('member')->where('uid',$user['uid'])->update($login);

			storage_user_action($user['uid'],$user['username'],config('FRONTEND_USER'),'登录了网站');

			return ['success'=>'登录成功','total'=>osc_cart()->count_cart_total($user['uid'])];
		}else{
			return ['error'=>'密码错误'];
		}
	}
	//登录
	public function login(){

		if(request()->isPost()){

			$data=input('post.');

			$r=$this->validate_login($data);

			if(isset($r['error'])){
				return $r;
			}elseif($r['success']){
				session('total',$r['total']);
				return ['success'=>true,'total'=>$r['total']];
			}

		}

		if(osc_service('member','user')->is_login()){
			die('您已经登录了账号！！');
		}

		return $this->fetch();
	}

	function logout(){
		osc_service('member','user')->logout();
		$this->redirect('/');
	}

	public function verify(){
		$captcha = new Captcha((array)Config('captcha'));
		return $captcha->entry(1);
	}



}
