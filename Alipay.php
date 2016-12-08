<?php
namespace iqianfang\yii2alipay;
use common\models\Order;

/**
 * Created by PhpStorm.
 * User: 山东千方信息科技 qianfang.me
 * Date: 2016/12/6
 * Time: 16:56
 */
class Alipay
{
    public $config = []; //配置数组
    public $_config = []; //固定配置数组

    /**
     * 设置一些固定的配置
     */
    public function __construct()
    {
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $this->_config['cacert'] = __DIR__ . '\\cacert.pem';
        // 支付类型 ，无需修改
        $this->_config['payment_type'] = '1';
        // 产品类型，无需修改
        $this->_config['service'] = 'create_direct_pay_by_user';
    }

    public function varConfig()
    {
        echo '<pre>';
        var_dump($this->config, $this->_config);
    }

    /**
     * @param Order $order
     * @return \提交表单HTML文本
     * @author WangTao <78861190@qq.com>
     */
    public function submit($order)
    {
        require_once("lib/alipay_submit.class.php");
        $alipay_config = array_merge($this->config,$this->_config);

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],

            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $order->sn,
            "subject"	=> '购买课程',
            "total_fee"	=> $order->amount,
            "body"	=> '',
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"

        );

        $alipaySubmit = new \AlipaySubmit($alipay_config);
        return $alipaySubmit->buildRequestForm($parameter,"get", "确认");
    }
}