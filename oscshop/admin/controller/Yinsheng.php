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

	//支付页面
    public function index()
    {
		$this->assign('order', get_order_num());

		return $this->fetch();   
    }

	//支付调用接口
	public function yinsheng_pay(){
		return json_encode(input('post.'));
	}

	//获取子协议
	public function get_scOrder(){
		$url = config('yinsheng_pay.signSimpleSubContract');
		$accountId = config('yinsheng_pay.accountId');
		$key = config('yinsheng_pay.accountKey');
		$postData = [
			'cardNo' => input('post.cardNo'),
			'name' => input('post.name'),
			'idCardNo' => input('post.idCardNo'),
			'cardNo' => input('post.cardNo'),
			'phoneNo' => input('post.phoneNo'),
			'startDate' => date('Ymd'),
			'endDate' => date('Ymd', time()+3600),
			'contractId' => $accountId,
			'accountId' =>input('post.accountId'),
		];
		$str = "accountId=".$accountId."&contractId=".$accountId."&name=".$postData['name']."&phoneNo=".$postData['phoneNo']."&cardNo=".$postData['cardNo']."&idCardNo=".$postData['idCardNo']."&sta rtDate=".$postData['startDate']."&endDate=".$postData['endDate']."&key=".$key;
		$postData['mac'] = strtoupper(md5($str));
		$result = create_request($url, $postData);
		return json_encode($result);
	}

	//扫码支付
	public function qrpay(){
		$url = "http://112.74.25.79:9999/gyprovider/getNativeUrl.do";
		$gymcht = '1000001221';
		$key = "sLbAsG00RWs1eF13juevu5WfEFLDSe0c";
		$tradeSn = date('YmdHis').rand(1000, 9999);
		$postData = [
			'gymchtId' => $gymcht,
			'tradeSn' => $tradeSn,
			'orderAmount' => 1,
			'goodsName' => '扫码支付测试',
			'expirySecond' => 500,
			'tradeSource' => '2',
			'notifyUrl' => 'http://1860z45q02.51mypc.cn:11345/bjsm/public/getQrNotify',
			't0Flag' => '1',
		];
		$postData['sign'] = getSign($postData, $key);
		$result = create_request($url, $postData);
		print_r($result);
	}

}
