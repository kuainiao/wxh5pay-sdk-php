<?php
/**
 * 下单类
 * User: adcbguo
 * Date: 2017/10/12
 * Time: 10:15
 */
namespace wxh5pay;
use wxh5pay\lib\Core;
use wxh5pay\lib\Sign;

class Order
{
    /**
     * 参数
     * @var array
     */
    private $params;

    /**
     * 配置数组
     * @var array
     */
    private $config;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->setParams([
            'appid' => $this->config['APP_ID'],
            'mch_id' => $this->config['MCH_ID'],
            'device_info' => $this->config['device_info'],
            'sign_type' => 'MD5'
        ]);
    }

    /**
     * 设置参数
     * @param string|array $name
     * @param string $value
     */
    public function setParams($name, $value = '')
    {
        if(is_array($name)){
            $this->params = array_merge($this->params,$name);
        }else{
            $this->params[$name] = $value;
        }
    }

    /**
     * 获取参数
     * @param $name
     * @return array|mixed
     */
    public function getParams($name)
    {
        if (empty($name)) {
            return $this->params;
        } else {
            return $this->params[$name];
        }
    }

    /**
     * 统一下单
     */
    public function unifiedorder()
    {
        //生成随机串
        $this->setParams('nonce_str', Core::genRandomString());

        //生成签名参数到数组
        $this->setParams('sign', Sign::makeSign($this->params, $this->config['KEY']));

        //发起下单请求
        $res = Core::postXmlCurl(Core::arrayToXml($this->params), $this->config['unifiedorder_url']);

        Core::xmlToArray($res);
    }

    /**
     * 订单查询
     */
    public function orderquery()
    {

    }

    /**
     * 关闭订单
     */
    public function closeorder()
    {

    }
}