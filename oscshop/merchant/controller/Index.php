<?php
/**
 * @author    yutonghe
 * yutonghe
 */
namespace osc\merchant\controller;
use osc\common\controller\MerchantBase;
use think\Db;
class Index extends MerchantBase{

	//首页
	public function index(){
		$this->assign('breadcrumb1', '代扣');
		$this->assign('breadcrumb2', '代扣');
		$this->assign('order', get_order_num());
		return $this->fetch();
	}


}
