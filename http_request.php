<?php
class http_request
{
    public $ch;
    function __construct()
    {
        $this->ch = curl_init();
        //将curl_exec()获取的信息以字符串返回
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 500);
    }
    public function getHeader($response, &$res)
    {
        $headerSize = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
        $res['header'] =  substr($response, 0, $headerSize);
        $res['contents'] = substr($response, $headerSize);
    }
    public function open_headInfo()
    {
        curl_setopt($this->ch, CURLOPT_HEADER, true);
    }
    public function post($url, $data = [], $recvHeader = false)
    {
        $res = [];
        //设置目标url
        if ($recvHeader)
            $this->open_headInfo();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        //判断http协议
        $protocol = parse_url($url)['scheme'];
        if ($protocol === "https")
            $this->set_https();
        //设置使用POST方式发送
        curl_setopt($this->ch, CURLOPT_POST, true);
        //设置发送的数据
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($this->ch);
        if ($recvHeader)
            $this->getHeader($response, $res);
        else
            $res['contents'] = $response;
        return $res;
    }
    public function get($url, $recvHeader = false)
    {
        $res = [];
        //设置目标url
        if ($recvHeader)
            $this->open_headInfo();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        //设置使用GET方式发送请求
        $protocol = parse_url($url)['scheme'];
        if ($protocol === "https")
            $this->set_https();
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        $response = curl_exec($this->ch);
        if ($recvHeader)
            $this->getHeader($response, $res);
        else
            $res['contents'] = $response;
        return $res;
    }
    private function set_https()
    {
        //跳过证书检查
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        //从证书中检查SSL加密算法是否存在
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);
    }
}
