<?php
/**
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/20
 * Time: 9:28
 * 拼多多demo
 */

class duoduoke_server_data{

    public $duoduoke_server;  //发送数据对象

    public function __construct()
    {
        $this->duoduoke_server = new duoduoke_server_sennd();
    }

    /**
     * 多多客主题
     */
    public function _ddk_theme_list($action,$data){
        $result = $this->duoduoke_server->call($action,$data);
        return $result;
    }
}
class duoduoke_server_sennd
{
    /**
     * client_id
     */
    public $client_id;
    /**
     *
     */
    public $client_secret;
    /**
     * the is formal environment
     */
    public $url;

    public function __construct()
    {
        $this->client_id = "0717de59f9c145ff95282ca510912363";
        $this->client_secret = "cbc8727cb07cf4393c3698e9eba318a309b1990c";
        $this->url = "https://gw-api.pinduoduo.com/api/router";
    }

    public function call($action, $data)
    {
        $data = $this->array_json($data);
        $sysment_data = $this->sysment_data($action, $data);
        $result = $this->post($this->url, $data, $sysment_data);
        return $result;
    }

    /**
     * 返回多多客公共参数
     */
    public function sysment_data($action, $data)
    {
        $sysment_data = [
            'type' => $action,
            'client_id' => $this->client_id,
            'timestamp' => $this->getMillisecond(),
        ];
        $data_array = array_merge($data, $sysment_data);
        return $this->sysment_sign($data_array);
    }

    /**
     * 生成sign
     */
    public function sysment_sign($data)
    {
        //第一步ksort ask 升序
        ksort($data);
        //第二步 数字转字符串
        $str = "";
        foreach ($data as $k => $v) {
            $str .= $k . $v;
        }
        //第三步 首位拼接client_secret
        $data['sign'] = strtoupper(md5($this->client_secret . $str . $this->client_secret));
        return $data;
    }

    /*
    * 模拟post方法
    */
    public function post($url, $body = [], $url_params = [], $headers = ['Content-Type: application/json'])
    {
        try {
            $url .= '?' . http_build_query($url_params);
            //初始化
            $ch = curl_init();
            //设置请求的URL地址
            curl_setopt($ch, CURLOPT_URL, $url);
            //设置请求头
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //设置请求体信息
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //设置
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //发送请求
            $res = curl_exec($ch);
            //关闭
            if (curl_errno($ch)) {
                //存在错误
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                error_log(date('Y-m-d H:i:s', time()) . "-向erp推送数据信息失败 curl位置报错>> 失败原因：" . curl_error($ch) . "状态码:" . $httpCode . "\r\n", '3', ROOT_PATH . "/log/Jst_Order_Push.log");
            }
            curl_close($ch);
            return json_decode($res, true);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * 获取13位时间戳
     * Enter description here ...
     */
    private function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

    /**
     * 处理value 为数组的问题
     */
    public function array_json($data)
    {
        array_walk($data, function (&$val) {
            if(is_array($val)){
                $val = json_encode($val);
            }
            if (is_bool($val)) {
                $val = ['false', 'true'][intval($val)];
            }
        });
        return $data;
    }
}
