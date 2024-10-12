<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	header("Content-type:text/html;charset=utf-8");
	require_once 'AppConfig.php';
	require_once 'AppUtil.php';
    //统一支付接口
	function pay(){
        $orderId = $_POST['orderId'];
        $txnAmt = $_POST['txnAmt'];
        $orderDesc = $_POST['orderDesc'];
		$params = array();
        $params["cusid"] = AppConfig::CUSID;
	  $params["appid"] = AppConfig::APPID;
	  $params["version"] = AppConfig::APIVERSION;
	  $params["orgid"] = '';
      $params["trxamt"] = 100;
      $params["reqsn"] = 'TESTO1';
	  $params["paytype"] = 'W01';
	  $params["body"] = 'TEST1';
  	$params["remark"] = 'ceshi';
	  $params["validtime"] = 12;
	  $params["acct"] = 'oM4tN4x6Cdp51AYTZCYzPN2E8gLU';
	  $params["notify_url"] = '/notify.php';
	  $params["limit_pay"] ='';
	  $params["sub_appid"] = '';
  	$params["subbranch"] = '';
	  $params["cusip"] = '';
	  $params["idno"] = '';
	  $params["truename"] ='';
	  $params["fqnum"] ='';
	  $params["randomstr"] =12;
	  $params["signtype"] ='RSA';
		$params["front_url"] ='';
    $params["sign"] = urlencode(AppUtil::Sign($params));//签名  
	  $paramsStr = AppUtil::ToUrlParams($params);
	    $url = AppConfig::APIURL . "/pay";
	    $rsp = request($url, $paramsStr);
//	    echo "请求返回:".$rsp;
        echo "<br/>";
	    $rspArray = json_decode($rsp, true);
//        echo $rspArray['payinfo'];
        echo "<br/>";
	    if(AppUtil::validSign($rspArray)){
//	    	echo "微信支付";
            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>支付二维码</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    background-color: #f4f4f9;
                    font-family: Arial, sans-serif;
                }
                h2{
                    font-size: 18px;
                }
                .payment-container {
                    text-align: center;
                    background: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .payment-container h2 {
                    margin-bottom: 20px;
                    color: #333;
                }

                #myQrcode {
                    margin: 0 auto;
                    padding: 10px;
                    border: 2px solid #ddd;
                    border-radius: 8px;
                    background-color: #fff;
                }

                .instructions {
                    margin-top: 15px;
                    color: #666;
                }
            </style>
            <body>
            <div class="payment-container">
                <h2>请使用微信扫码完成支付</h2>
                <div id="myQrcode"></div>
            </div>
            <script src="https://cdn.bootcss.com/jquery/1.5.1/jquery.min.js"></script>
            <script src="https://cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
            <script>
                jQuery('#myQrcode').qrcode({
                    width: 200,  // 调整二维码宽度
                    height: 200, // 调整二维码高度
                    text: "<?php echo $rspArray['payinfo']; ?>"
                });
            </script>
            </body>
            <?php
	    }
	    
	}


	
	//发送请求操作仅供参考,不为最佳实践
	function request($url,$params){
		$ch = curl_init();
		$this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
		curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//如果不加验证,就设false,商户自行处理
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 
		$output = curl_exec($ch);
		curl_close($ch);
		return  $output;
	}
	
	//验签
	function validSign($array){
		if("SUCCESS"==$array["retcode"]){
			$signRsp = strtolower($array["sign"]);
			$array["sign"] = "";
			$sign =  strtolower(AppUtil::Sign($array));
			if($sign==$signRsp){
				return TRUE;
			}
			else {
				echo "验签失败:".$signRsp."--".$sign;
			}
		}
		else{
			echo $array["retmsg"];
		}
		
		return FALSE;
	}
	
	 pay();


?>

