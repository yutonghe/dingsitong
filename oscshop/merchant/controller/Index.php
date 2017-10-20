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
		$this->assign('breadcrumb1', '账户管理');
		$this->assign('breadcrumb2', '账户查询');
		return $this->fetch();
	}


}
