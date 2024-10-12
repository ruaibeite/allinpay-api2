<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通联支付统一下单</title>
</head>
<body>
<h1>通联支付统一下单</h1>
<form id="paymentForm" method="POST">
    <label for="orderId">订单号:</label>
    <input type="text" id="orderId" name="orderId" required><br><br>

    <label for="txnAmt">金额:</label>
    <input type="number" id="txnAmt" name="txnAmt" required><br><br>

    <label for="orderDesc">订单描述:</label>
    <input type="text" id="orderDesc" name="orderDesc" required><br><br>


    <!-- WeChat Pay button -->
    <input type="image" src="wechat_image.png" alt="微信支付" formaction="allinpay1.php" style="border: none;"/>

    <!-- Alipay button -->
    <input type="image" src="alipay_image.png" alt="支付宝支付" formaction="allinpay2.php" style="border: none;"/>

    <!-- UnionPay button -->
    <input type="image" src="unionpay_image.png" alt="银联支付" formaction="allinpay3.php" style="border: none;"/>

</form>
</body>
</html>
