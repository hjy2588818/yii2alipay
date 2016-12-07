<?php
namespace iqianfang\yii2alipay;
/**
 * Created by PhpStorm.
 * User: 山东千方信息科技 qianfang.me
 * Date: 2016/12/6
 * Time: 16:56
 */
class Alipay
{
    //配置数组
    public $config = [];

    public function varConfig()
    {
        echo '<pre>';
        var_dump($this->config);
    }
}