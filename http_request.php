<?php
class http_request
{
    public $ch;
    function __construct()
    {
        $this->ch = curl_init();
        //将curl_exec()获取的信息以字符串返回
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }
    public function post($url, $data = [])
    {
        //设置目标url
        curl_setopt($this->ch, CURLOPT_URL, $url);
        //设置使用POST方式发送
        curl_setopt($this->ch, CURLOPT_POST, 1);
        //设置发送的数据
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return curl_exec($this->ch);
    }
    public function get($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        //设置使用GET方式发送请求
        curl_setopt($this->ch, CURLOPT_HTTPGET,true);
        
        return curl_exec($this->ch);
    }
}
