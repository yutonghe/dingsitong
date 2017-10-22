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

	//签订子协议
	public function get_sc_order(){
		$result = osc_service('admin','yinsheng')->get_sc_order();
		echo json_encode($result);exit;
	}

	//代扣
	public function daikou_pay(){
		if(session('DK_PAY_TIME_'.UID) && (time() - session('DK_PAY_TIME_'.UID) < 60)){
			$this->return_result('操作频繁，请稍后再操作','1117');
		}else{
			session('DK_PAY_TIME_'.UID, time());
		}
		$res = osc_service('admin','yinsheng')->yinsheng_pay();

		$data = array(
			'accountId' => session('merchant_user_auth.username'),
			'subContractId' => input('post.subContractId'),
			'amount' => number_format(input('post.amount'), 2, '.', ''),
			'phoneNo' => intval(input('post.phoneNo')),
			'orderId' => input('post.orderId'),
			'cardNo' => input('post.cardNo'),
			'username' => input('post.name'),
			'idCardNo' => input('post.idCardNo'),
			'status' => '2',
			'create_time' => time(),
		);
		$id = Db::name('yingsheng_orders')->insert($data);
		if($id){
			$this->return_result('提交成功，待审核');
		}else{
			$this->return_result('提交失败', '1110');
		}
	}

	//代扣订单列表
	public function orders(){
		$this->assign('breadcrumb1','代扣');
		$this->assign('breadcrumb2','代扣列表');
		$filter = input('param.');
		$map = array('accountId'=>session('merchant_user_auth.username'));
		$query = array();
		//开始时间
		if(isset($filter['starttime'])){
			$map['create_time'] = ['egt',strtotime($filter['starttime'])];
			$query['starttime'] = urlencode($filter['starttime']);
		}
		//结束时间
		if(isset($filter['endtime'])){
			$map['create_time'] = ['elt',strtotime($filter['endtime'])];
			$query['endtime'] = urlencode($filter['endtime']);
		}
		//代扣订单号
		if(isset($filter['orderNo'])){
			$map['orderId'] = $filter['orderNo'];
			$query['orderNo'] = urlencode($filter['orderNo']);
		}
		//代扣状态
		if(isset($filter['status'])){
			$map['status'] = $filter['status'];
			$query['status'] = urlencode($filter['status']);
		}
		$list = Db::name('yingsheng_orders')->where($map)->order('create_time desc')->paginate(config('page_num'), false, ['query'=>$query]);
		$this->assign('list', $list);
		$this->assign('empty', '<tr><td colspan="12">没有数据~</td></tr>');
		return $this->fetch();
	}

	//返回结果
	private function return_result($result_msg = '操作成功', $result_code = '0000'){
		echo json_encode(array('result_code' => $result_code, 'result_msg' => $result_msg));exit;
	}

	//子协议延期
	public function order_time(){
		$this->assign('breadcrumb1','代扣');
		$this->assign('breadcrumb2','子协议延期');
		$this->assign('starttime', date('Y-m-d'));
		$orderTime = osc_service('admin','yinsheng')->conf['orderTime'];
		$this->assign('endtime', date('Y-m-d', time() + $orderTime * 24 * 60 * 60));
		return $this->fetch();
	}

	//子协议延期
	public function order_more_time(){
		$result = osc_service('admin','yinsheng')->order_more_time();
		echo json_encode($result);exit;
	}

	//订单状态查询
	public function query_order_status(){
		$result = osc_service('admin','yinsheng')->query_order_status();
		$result = json_decode($result, true);
		if($result['result_code'] == '0000' || $result['status'] == '00' || $result['20']){
			$data = [
				'status' => ($result['status'] == '00') ? 1 : 3,
				'status_desc' => $result['desc'],
			];
			Db::name('yingsheng_orders')->where(['orderId'=>input('post.orderId')])->update($data);
		}
		echo json_encode($result);
	}


}
