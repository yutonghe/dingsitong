<?php
/**
 * @author    yutonghe
 *商户登录注册相关
 */
namespace osc\merchant\controller;
use osc\common\controller\Base;
use think\Db;
use think\captcha\Captcha;
class Login extends Base{

	//保存会员信息
	private function refresh_member($auth){
		
		if(empty($auth)&&!is_array($auth)){
			return;	
		}
		if('session'==config('merchant_login_type')){
		 	session('merchant_user_auth', $auth);
			session('merchant_user_auth_sign',data_auth_sign($auth));
		 }elseif('cookie'==config('merchant_login_type')){		
		 	cookie('merchant_user_auth',$auth,3600*7);
			cookie('merchant_user_auth_sign',data_auth_sign($auth),3600*7);
		 }
	}

	//登录验证
	public function validate_login($data){
		
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
			
			$user=Db::name('merchant')->where('username',$data['username'])->find();
			
			if(!$user){
				return ['error'=>'账号不存在！！'];
			}
			/*elseif(($user['checked']==0)&&(1==config('reg_check'))){//需要审核
				return ['error'=>'该账号未审核通过！！'];
			}*/
			
			if(think_ucenter_encrypt($data['password'],config('PWD_KEY'))==$user['pword']){
		
				$auth = array(
		            'uid'             => $user['id'],
		            'username'        => $user['username'],
				 );			
								
				$this->refresh_member($auth);
				
				/*$login['lastdate']=time();
				$login['loginnum']		=	array('exp','loginnum+1');
				$login['lastip']	=	get_client_ip();
				
				DB::name('member')->where('uid',$user['uid'])->update($login);*/
				
				//storage_user_action($user['uid'],$user['username'],config('FRONTEND_USER'),'登录了网站');
				
				return ['success'=>'登录成功'];
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
				//session('total',$r['total']);
				return ['success'=>true];
			}
			
		}

		if(osc_service('merchant','user')->is_login()){
			//die('您已经登录了账号！！');
			$this->redirect('merchant/index/index');
		}
		  
		return $this->fetch();  
	}

	function logout(){
		osc_service('merchant','user')->logout();
		$this->redirect('merchant/index/index');
	}

	 public function verify(){	 	
		$captcha = new Captcha((array)Config('captcha'));
		return $captcha->entry(1);	 	
    }

	public function edit_pwd(){

		if(request()->isPost()){
			$data=input('post.');

			$r=$this->validate_pwd($data);

			return $r;

		}
		$this->assign('breadcrumb1','修改密码');
		$this->assign('breadcrumb2','');
		return $this->fetch();
	}

	private function validate_pwd($data){
		if(empty($data['old_pwd'])){
			return ['error'=>'旧密码为空'];
		}
		if(empty($data['new_pwd1'])){
			return ['error'=>'新密码为空'];
		}
		if($data['new_pwd2'] !=  $data['new_pwd1']){
			return ['error'=>'两次密码不一样'];
		}

		$map = [
			'id' => session('merchant_user_auth.uid'),
			'pword' => think_ucenter_encrypt($data['old_pwd'], config('PWD_KEY'))
		];
		$user = Db::name('merchant')->where($map)->find();
		if(!$user){
			return ['error'=>'旧密码不正确'];
		}
		$n_pwd = think_ucenter_encrypt($data['new_pwd2'],config('PWD_KEY'));
		$bool = Db::name('merchant')->where('id', session('merchant_user_auth.uid'))->update(['pword' => $n_pwd]);
		if($bool){
			return ['success'=>'修改成功'];
		}else{
			return ['error'=>'修改失败'];
		}
	}
}
