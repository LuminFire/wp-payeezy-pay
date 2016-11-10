<?php
$transactionKeyFile = $_POST["x_login"] . '.php';

include $transactionKeyFile;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Processing your payment...</title>
<style media="screen" type="text/css">
body {
	background-color: #efefef;
}
h2 {
	color: #555;
	font-family: Georgia, serif;
	font-weight: 400;
	text-align: center;
	padding-top: 80px;
	font-style: italic;
}
</style>
</head>
<body>
<?php 

$mode = $_POST["mode"];

if ( $mode == "live" ) {
				$post_url = "https://checkout.globalgatewaye4.firstdata.com/payment";
			}

else  { $post_url = "https://demo.globalgatewaye4.firstdata.com/payment";


}

?>
<form action="<?php echo $post_url ;?>" method="POST" name="myForm" id="myForm"->

  <?php
  $x_login = $_POST["x_login"];
$x_amount = $_POST["x_amount"];
$x_currency_code = $_POST["x_currency_code"];
$x_invoice_num = $_POST["x_invoice_num"];
$x_po_num = $_POST["x_po_num"];
$x_reference_3 = $_POST["x_reference_3"];
$x_user1 = $_POST["x_user1"];
$x_user2 = $_POST["x_user2"];
$x_user3 = $_POST["x_user3"];

$x_first_name = $_POST["x_first_name"];
$x_last_name = $_POST["x_last_name"];
$x_company = $_POST["x_company"];
$x_address = $_POST["x_address"];
$x_city = $_POST["x_city"];
$x_state = $_POST["x_state"];
$x_zip = $_POST["x_zip"];
$x_country = $_POST["x_country"];
$x_email = $_POST["x_email"];
$x_phone = $_POST["x_phone"];
$x_description = $_POST["x_description"];


// If there is a Reference Number sent from the form, it is used to populate
// the line item on the final payment form hosted by Payeezy. If not, the
// default "Your Purchase" will be used. 
if (!empty($x_invoice_num)) {
$x_invoice_num = $x_invoice_num;
}
else { $x_invoice_num = "Your Payment";
}

srand(time()); // initialize random generator for x_fp_sequence
$x_fp_sequence = rand(1000, 100000) + 123456;
$x_fp_timestamp = time(); // needs to be in UTC. Make sure webserver produces UTC
// The values that contribute to x_fp_hash
$hmac_data = $x_login . "^" . $x_fp_sequence . "^" . $x_fp_timestamp . "^" . $x_amount . "^" . $x_currency_code;
$x_fp_hash = hash_hmac('MD5', $hmac_data, $transaction_key);
echo ('<input name="x_login" value="' . $x_login . '" type="hidden">' );
echo ('<input name="x_amount" value="' . $x_amount . '" type="hidden">' );
echo ('<input name="x_fp_sequence" value="' . $x_fp_sequence . '" type="hidden">' );
echo ('<input name="x_fp_timestamp" value="' . $x_fp_timestamp . '" type="hidden">' );
echo ('<input name="x_fp_hash" value="' . $x_fp_hash . '" size="50" type="hidden">' );
echo ('<input name="x_currency_code" value="' . $x_currency_code . '" type="hidden">');
?>
<input name="x_first_name" value="<?php echo $x_first_name ;?>" type="hidden">
<input name="x_last_name" value="<?php echo $x_last_name ;?>" type="hidden">
<input name="x_company" value="<?php echo $x_company ;?>" type="hidden">
<input name="x_address" value="<?php echo $x_address ;?>" type="hidden">
<input name="x_city" value="<?php echo $x_city ;?>" type="hidden">
<input name="x_state" value="<?php echo $x_state ;?>" type="hidden">
<input name="x_country" value="<?php echo $x_country ;?>" type="hidden">
<input name="x_zip" value="<?php echo $x_zip ;?>" type="hidden">
<input name="x_email" value="<?php echo $x_email ;?>" type="hidden">
<input name="x_phone" value="<?php echo $x_phone ;?>" type="hidden">
<input name="x_invoice_num" value="<?php echo $x_invoice_num ;?>" type="hidden">
<input name="x_po_num" value="<?php echo $x_po_num ;?>" type="hidden">
<input name="x_reference_3" value="<?php echo $x_reference_3 ;?>" type="hidden">
<input name="x_user1" value="<?php echo $x_user1 ;?>" type="hidden">
<input name="x_user2" value="<?php echo $x_user2 ;?>" type="hidden">
<input name="x_user3" value="<?php echo $x_user3 ;?>" type="hidden">
<input name="x_description" value="<?php echo $x_description ;?>" type="hidden">
<input name="x_line_item" value="Payment<|>Payment<|><?php echo $x_invoice_num ;?><|>1<|><?php echo $x_amount;?><|>N<|><|><|><|><|><|>0<|><|><|><?php echo $x_amount;?>"type="hidden">
<input type="hidden" name="x_show_form" value="PAYMENT_FORM"/>
</form>
<h2>Processing your  $<?php echo $x_amount;?> payment <?php echo $x_first_name;?>, please wait...</h2>
<!-- --> <script type='text/javascript'>document.myForm.submit();</script> <!-- Automaticlly sends the final request to the Payeezy Gateway -->
</body>
</html>