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
			$this->redirect('merchant/login/login');
		}
	}



}
