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
		$private_key='MIIEpAIBAAKCAQEAxvJZNmjtDcMJ+xMrjfdXYiDcErP6mPBQNXyK7i0utvb9FSOoTmtSNoHqgYYsuCQid026EiJlRWVHb2iNUolBC7gvxgM6t5G5Oh3eny9GJ2ApnqNEuVjf8ZExtyJNzkjBBwM3HMeCKIjx9p3JwkdA0hqaJ8JwJGDaAx1C36nStcljbsS4HmLrNYlUwkGp3dTOZAhXTdwh0qN0yqxPMZcaW2c8fxhcil/Hoev7yMCcls/yHYNOr7Ve4ZeI0bVvFT58uVGJGFqOatVLGqVOoH9bzHc/im9JwLS6LGIi/v94W+pO2BLKUwLpLnFm47IJsOTT2fyFrPdkD52SxypB2RDdtQIDAQABAoIBAB/5s6ewaulbVQSrABpr4U+UQyApF+NHkfIGzQ2a6syIG1qFG01Up9IQRMYB8A4TQLbhd0E9kKlRWI8/bqIQDV76K4jX3AgaaSWTchnZBJ2E3IDyx4jtZTueP9n/WXdeRNKrtvVD26zy1cZIILVpCQdmidWkxVa+JPbQgn8QUcgwXWaa8X1/sxs18ta9kROfy9Wi8KgEQrxgzkij5TsXxFjkqYIbmEhu3GD/RKm+Qfu+B+sfvG+aozjKVHI2xAuc2wZ+3K+YzQ8O2GtbbwywrdonSApGmHGqAtBnOa9P8lY4ubFohZKRwSly9RNGB+UIxrOqL2cVF4bVz7pap2xgbcECgYEA8SiXNtvirDUFXft5emJ6zjUInuGxn2OT+nCALGtY3n8pLQvNXHw+V3AFvABeSCXDisg5E/A9S0AKaGWyR2ZbHaCzYQNX4uJEbyYqA4zlxJ/+KyKjnfvO7HrG0oFvpWNTP4PsbGyb4yrFYyOpx2HQj+EIzrkJpwixkqBk3BO/SfMCgYEA0zC3nOxGSohEXioPrOzgsHb3yk2V9m2tnWEecqUiHq4CHhACa2mZOFUArwmDGRd7AqesCeWqK8lneWzoCrhUHABEpCqGDoB/06urxw4pmgV2TetDgOxfR0ihKVDeNEuqw6S4R3cjyh3ifbNyy2/8hN586G/dswQBW6jJgI+YO7cCgYEA41V0Vs6pu9Svnoz1Ux2KzuDHo572pl5knO14pmb7e6M72a8KhGjLC/oaLcPbHQAcebONuvH5lfpk1U0o5o3izucysf1I2CSchnrfmEE2SEjafSdGPiOmSN7kloRWDv6292URdpRbz6X+NRrlbYMT7M4iU12zb7aOTr7M1Xn4FWkCgYEAwEZDdTA8UtE7hYu/182WR7MYqGv403JJtdZdFT25EbuVG++xdD+hCwOA6tu7KtYQ3Xrwi9Y4F0N33LpFjLUDhrbLx7cbdAqT1pAehc0kHSFJ82j1fWQ23ryGVgpVM8GMSDEowY/72qFYut7s7cEYY5P4ntpyOvCzl9LVGiIiFIMCgYAspDkWz9CTFy75F6Fyjce3ythYFiPuefX6cFKC+IOMFD6fC58A7COaqrBl9mcQ0aOtgy1eFQNYmj5XpStt6BXe1rLvahbGCtgkVGt1Qa9S77W1KvVE2Wlo/nswiz1xVB9a/7Ubm2ycL5DaZ/x9jXep6XN4+AxZF44nnmdixSv/dQ==';
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