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
class Yinsheng extends AdminBase{

	protected function _initialize(){
		parent::_initialize();
	}

	//支付页面
    public function index()
    {
		$this->assign('breadcrumb1','代扣');
		$this->assign('breadcrumb2','代扣');
		$this->assign('order', get_order_num());
		return $this->fetch();
    }

	//支付调用接口
	public function yinsheng_pay(){
		$res = osc_service('admin','yinsheng')->yinsheng_pay();
		$result = $res['result'];
		$postdata = $res['postdata'];
		if($result['result_code'] == '0000'){
			$data = array(
				 'accountId' => $postdata['accountId'],
				'subContractId' => $postdata['subContractId'],
				'amount' => number_format($postdata['amount'], 2, '.', ''),
				'phoneNo' => intval($postdata['phoneNo']),
				'orderId' => $postdata['orderId'],
				'cardNo' => input('post.cardNo'),
				'username' => input('post.name'),
				'idCardNo' => input('post.idCardNo'),
				'status' => '2',
				'create_time' => time(),
			);
			Db::name('yingsheng_orders')->insert($data);
		}
		echo json_encode($result);exit;
	}

	//代扣结果通知
	public function resPay(){
		 $key = config('yinsheng_pay.accountKey');
		 $res = json_decode(file_get_contents("php://input"), true);
		 $str = "accountId=".$res['accountId']."&orderId=".$res['orderId']."&amount=".$res['amount']."&result_code=".$res['result_code']."&result_msg=".$res['result_msg']."&key=".$key;
		if(strtoupper(md5($str)) === $res['mac']){
			if($res['result_code'] == '00'){
				$bool = Db::name('yingsheng_orders')->where(['accountId'=>$res['accountId'], 'orderId'=>$res['orderId']])->update(['status' => 1, 'update_time'=>time()]);
				if($bool) {
					return 'success';
				}else{
					return 'failure';
				}
			}else if($res['result_code'] == '20'){
				Db::name('yingsheng_orders')->where(['accountId'=>$res['accountId'], 'orderId'=>$res['orderId']])->update(['status' => 3, 'update_time'=>time()]);
				return 'failure';
			}
		}else{
			return 'failure';
		}
	}

	//获取子协议
	public function get_scOrder(){
		$result = osc_service('admin','yinsheng')->get_sc_order();
		echo json_encode($result);exit;
	}

	//子协议延期
	public function order_more_time(){
		$url = config('yinsheng_pay.subConstractExtension');
		$contractId = config('yinsheng_pay.contractId');
		$accountId = config('yinsheng_pay.accountId');
		$key = config('yinsheng_pay.accountKey');
		$postdata = [
			'startDate' => date('Ymd', strtotime(input('post.starttime'))),
			'endDate' => date('Ymd', strtotime(input('post.endtime'))),
			'contractId' => $contractId,
			'accountId' => $accountId,
			'subContractId' => input('post.subContractId'),
		];
		$str = "accountId=".$accountId."&contractId=".$contractId."&subContractId=".$postdata['subContractId']."&startDate=".$postdata['startDate']."&endDate=".$postdata['endDate']."&key=".$key;
		$postdata['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postdata));
		echo json_encode($result);exit;
	}

	//订单状态查询
	public function query_order_status(){
		$url = config('yinsheng_pay.queryOrderStatus');
		$accountId = config('yinsheng_pay.accountId');
		$key = config('yinsheng_pay.accountKey');
		$postdata = [
			'accountId' => $accountId,
			'orderId' => '',
		];
		$str = "accountId=".$accountId."&orderId=".$postdata['orderId']."&key=".$key;
		$postdata['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postdata));
		print_r($result);
	}

	//子协议查询
	public function query_subContract(){
		$url = config('yinsheng_pay.querySubContractId');
		$accountId = config('yinsheng_pay.accountId');
		$key = config('yinsheng_pay.accountKey');
		$postdata = [
			'cardNo' => input('post.cardNo'),
			'name' => input('post.name'),
			'idCardNo' => input('post.idCardNo'),
			'accountId' => $accountId,
		];
		$str = "accountId=".$accountId."&name=".$postdata['name']."&cardNo=".$postdata['name']."&idCardNo=".$postdata['name']."&key=".$key;
		$postdata['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postdata));
		print_r($result);
	}

	//代扣订单列表
	public function orders(){
		$this->assign('breadcrumb1','代扣');
		$this->assign('breadcrumb2','代扣列表');
		$filter = input('param.');
		$map = array();
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
		$this->assign('empty', '<tr><td colspan="11">没有数据~</td></tr>');
		return $this->fetch();
	}

	//子协议延期
	public function order_time(){
		$this->assign('breadcrumb1','代扣');
		$this->assign('breadcrumb2','子协议延期');
		$this->assign('starttime', date('Y-m-d'));
		$this->assign('endtime', date('Y-m-d', time() + config('yinsheng_pay.orderTime') * 24 * 60 * 60));
		return $this->fetch();
	}

}
