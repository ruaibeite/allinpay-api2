<?php
header("Content-type:text/html;charset=utf-8");
class AppUtil{
	/**
	 * 将参数数组签名
	 */

	 //RSA签名
		public static function Sign(array $array){
				ksort($array);
		$bufSignSrc = AppUtil::ToUrlParams($array);
		$private_key='';
			$private_key = chunk_split($private_key , 64, "\n");
    $key = "-----BEGIN RSA PRIVATE KEY-----\n".wordwrap($private_key)."-----END RSA PRIVATE KEY-----";
  //   echo $key;
	 if(openssl_sign($bufSignSrc, $signature, $key )){
	//		echo 'sign success';
		}else{
			echo 'sign fail';
		} 
$sign = base64_encode($signature);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
//echo $sign;
// echo $signature,"\n";
		return $sign;

	}
	
	
	public static function ToUrlParams(array $array)
	{
		$buff = "";
		foreach ($array as $k => $v)
		{
			if($v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
/**
	 * 校验签名
	 * @param array 参数
	 * @param unknown_type appkey
	 */

	
		public static function ValidSign(array $array){
	  $sign =$array['sign'];
		unset($array['sign']);
		ksort($array);
		$bufSignSrc = AppUtil::ToUrlParams($array);
		$public_key='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCm9OV6zH5DYH/ZnAVYHscEELdCNfNTHGuBv1nYYEY9FrOzE0/4kLl9f7Y9dkWHlc2ocDwbrFSm0Vqz0q2rJPxXUYBCQl5yW3jzuKSXif7q1yOwkFVtJXvuhf5WRy+1X5FOFoMvS7538No0RpnLzmNi3ktmiqmhpcY/1pmt20FHQQIDAQAB';	
 	  $public_key = chunk_split($public_key , 64, "\n");
	  $key = "-----BEGIN PUBLIC KEY-----\n$public_key-----END PUBLIC KEY-----\n";
	  $result= openssl_verify($bufSignSrc,base64_decode($sign), $key );
    return $result;  
	}
	
	
}
?>
