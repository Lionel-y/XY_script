<?php
require "http_request.php";
$req = new http_request();
$res = $req->get("https://www.ecut.edu.cn/");
file_put_contents("index.html",$res);