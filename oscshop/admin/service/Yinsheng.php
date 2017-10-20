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
 * @author    yutonghe
 *
 * 银生代扣
 * 
 */
namespace osc\admin\service;
class Yinsheng{

	public $conf1 = [
		'contractId' => '1120171016165338001', //协议号
		'accountId' => '1120171016165338001', // 商户号
		'accountKey' => '123456abc', //商户秘钥
		'signSimpleSubContract' => 'http://180.166.114.155:58082/delegate-collect-front/subcontract/signSimpleSubContractJson', //子协议录入接口
		'collect' => 'http://180.166.114.155:58082/delegate-collect-front/delegateCollect/collectJson', //代扣接口
		'queryOrderStatus' => 'http://180.166.114.155:58082/delegate-collect-front/delegateCollect/queryJson', //订单状态查询
		'querySubContractId' => 'http://180.166.114.155:58082/delegate-collect-front/subcontract/querySubContractIdJson', //子协议号查询
		'subConstractExtension' => 'http://180.166.114.155:58082/delegate-collect-front/subcontract/subConstractExtensionJson', //子协议延期
		'orderTime' => 1,         //默认子协议有效期(天)
	];

	public $conf = [
		'contractId' => '1120171020095241001', //协议号
		'accountId' => '1120171020095241001', // 商户号
		'accountKey' => '123456abc', //商户秘钥
		'signSimpleSubContract' => 'http://180.166.114.155:8081/unspay-external/subcontract/signSimpleSubContract', //子协议录入接口
		'collect' => 'http://180.166.114.155:8081/unspay-external/delegateCollect/collect', //代扣接口
		'queryOrderStatus' => 'http://180.166.114.155:8081/unspay-external/delegateCollect/queryOrderStatus', //订单状态查询
		'querySubContractId' => 'http://180.166.114.155:8081/unspay-external/subcontract/querySubContractId', //子协议号查询
		'subConstractExtension' => 'http://180.166.114.155:8081/unspay-external/subcontract/subConstractExtension', //子协议延期
		'orderTime' => 1,         //默认子协议有效期(天)
	];

	//签订子协议
	function get_sc_order(){
		$url = $this->conf['signSimpleSubContract'];
		$contractId = $this->conf['contractId'];
		$accountId = $this->conf['accountId'];
		$key = $this->conf['accountKey'];
		$postData = [
			'cardNo' => input('post.cardNo'),
			'name' => input('post.name'),
			'idCardNo' => input('post.idCardNo'),
			'cardNo' => input('post.cardNo'),
			'phoneNo' => input('post.phoneNo'),
			'startDate' => date('Ymd'),
			'endDate' => date('Ymd', time()+3600),
			'contractId' => $contractId,
			'accountId' => $accountId,
		];
		$str = "accountId=".$accountId."&contractId=".$contractId."&name=".$postData['name']."&phoneNo=".$postData['phoneNo']."&cardNo=".$postData['cardNo']."&idCardNo=".$postData['idCardNo']."&startDate=".$postData['startDate']."&endDate=".$postData['endDate']."&key=".$key;
		$postData['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postData));
		return $result;
	}

	//代扣调用
	function yinsheng_pay(){
		$url = $this->conf['collect'];
		$accountId = $this->conf['accountId'];
		$key = $this->conf['accountKey'];
		$postData = [
			'purpose' => input('post.purpose'),
			'amount' => input('post.amount'),
			'phoneNo' => input('post.phoneNo'),
			'subContractId' => input('post.subContractId'),
			'accountId' => $accountId,
			'orderId' => input('post.orderId'),
			'responseUrl' => "http://". $_SERVER['SERVER_ADDR'] ."/admin/yinsheng/resPay",
		];
		$str = "accountId=".$accountId."&subContractId=".$postData['subContractId']."&orderId=".$postData['orderId']."&purpose=".$postData['purpose']."&amount=".$postData['amount']."&phoneNo=".$postData['phoneNo']."&responseUrl=".$postData['responseUrl']."&key=".$key;
		$postData['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postData));
		$result['subContractId'] =  $postData['subContractId'];
		return array('postdata' => $postData, 'result' => $result);
	}

	//子协议延期
	public function order_more_time(){
		$url = $this->conf['subConstractExtension'];
		$contractId = $this->conf['contractId'];
		$accountId = $this->conf['accountId'];
		$key = $this->conf['accountKey'];
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
		return $result;
	}

	//订单状态查询
	function query_order_status(){
		$url = $this->conf['queryOrderStatus'];
		$accountId = $this->conf['accountId'];
		$key = $this->conf['accountKey'];
		$postdata = [
			'accountId' => $accountId,
			'orderId' => '',
		];
		$str = "accountId=".$accountId."&orderId=".$postdata['orderId']."&key=".$key;
		$postdata['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postdata));
		return $result;
	}

	//子协议查询
	function query_subContract(){
		$url = $this->conf['querySubContractId'];
		$accountId = $this->conf['accountId'];
		$key = $this->conf['accountKey'];
		$postdata = [
			'cardNo' => input('post.cardNo'),
			'name' => input('post.name'),
			'idCardNo' => input('post.idCardNo'),
			'accountId' => $accountId,
		];
		$str = "accountId=".$accountId."&name=".$postdata['name']."&cardNo=".$postdata['name']."&idCardNo=".$postdata['name']."&key=".$key;
		$postdata['mac'] = strtoupper(md5($str));
		$result = create_request($url, json_encode($postdata));
		return $result;
	}
}
