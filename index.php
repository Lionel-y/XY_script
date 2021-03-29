<?php
require "http_request.php";
$req = new http_request();
print_r($req->get("https://www.baidu.com",1)['header']);