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
 * @author    余统和
 *
 */
namespace osc\admin\controller;
use osc\common\controller\AdminBase;
use think\Db;

class Merchant extends AdminBase{

	protected function _initialize(){
		parent::_initialize();
	}

	//商户列表
	public function index(){
		$this->assign('breadcrumb1', '商户管理');
		$this->assign('breadcrumb2','商户列表');
		$filter = input('param.');
		$map = array();
		$query = array();
		//商户号
		if(isset($filter['uname'])){
			$map['username'] = array('like', '%'.$filter['uname'].'%');
			$query['uname'] = urlencode($filter['uname']);
		}

		$list = Db::name('merchant')->where($map)->paginate(config('page_num'), false, ['query'=>$query]);
		$this->assign('list', $list);
		$this->assign('empty', '<tr><td colspan="11">没有数据~</td></tr>');
		return $this->fetch();
	}

	//新增商户
	public function add(){
		if(request()->isAjax()){
			if(!input('post.uname')){
				$this->return_result('参数错误');
			}
			$data = [
				'username' => input('post.uname'),
				'pword' => think_ucenter_encrypt('123456', config('PWD_KEY')),
				'create_time' => time(),
			];
			$result = $this->validate($data, 'merchant');
			if($result!==true){
				$this->return_result($result, '1111');
			}
			$id = Db::name('merchant')->insert($data);
			if($id){
				$this->return_result('添加成功');
			}else{
				$this->return_result('添加失败', '1111');
			}
		}else{
			$this->assign('breadcrumb1', '商户管理');
			$this->assign('breadcrumb2', '商户添加');
			return $this->fetch();
		}

	}

	//返回结果
	private function return_result($result_msg = '操作成功', $result_code = '0000'){
		echo json_encode(array('result_code' => $result_code, 'result_msg' => $result_msg));exit;
	}


}
