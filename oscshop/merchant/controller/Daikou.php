<?php
/**
 * @author    yutonghe
 * yutonghe
 */
namespace osc\merchant\controller;
use osc\common\controller\MerchantBase;
use think\Db;
class Daikou extends MerchantBase{

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

	//提交代扣申请
	public function daikou_pay(){
		$postdata = input('post.');
		if(!$postdata['subContractId']){
			 $this->return_result('子协议为空','1111');
		}
		if(number_format($postdata['amount'], 2, '.', '') <= 0){
			$this->return_result('金额为空','1112');
		}
		if(!$postdata['phoneNo']){
			$this->return_result('手机号为空','1113');
		}
		if(!$postdata['orderId']){
			$this->return_result('订单号为空','1114');
		}
		if(!$postdata['username']){
			$this->return_result('用户姓名为空','1115');
		}
		if(!$postdata['idCardNo']){
			$this->return_result('身份证号为空','1116');
		}
		$conf = osc_service('admin','yinsheng')->conf;
		if(session('PAY_TIME_'.UID) && (time() - session('PAY_TIME_'.UID) < 60)){
			$this->return_result('操作频繁，请稍后再操作','1117');
		}else{
			session('PAY_TIME_'.UID, time());
		}
		$data = array(
			'accountId' => $conf['accountId'],
			'subContractId' => input('post.subContractId'),
			'amount' => number_format(input('post.amount'), 2, '.', ''),
			'phoneNo' => intval(input('post.phoneNo')),
			'orderId' => input('post.orderId'),
			'cardNo' => input('post.cardNo'),
			'username' => input('post.name'),
			'idCardNo' => input('post.idCardNo'),
			'status' => '0',
			'pay_status' => '2',
			'create_time' => time(),
		);
		$id = Db::name('yingsheng_orders')->insert($data);
		if($id){
			$this->return_result('提交成功，待审核');
		}else{
			$this->return_result('提交失败', '1110');
		}
	}

	//返回结果
	private function return_result($result_msg = '操作成功', $result_code = '0000'){
		echo json_encode(array('result_code' => $result_code, 'result_msg' => $result_msg));exit;
	}


}
