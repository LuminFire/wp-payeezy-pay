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
  
  if (isset($_POST["x_amount"])) {
  $x_amount = $_POST["x_amount"]; // 
  }

  if (isset($_POST["x_amount1"])) {
  $x_amount1 = $_POST["x_amount1"]; // takes the pre-defined amount 
  }
  if (isset($_POST["x_amount2"])) {
  $x_amount2 = $_POST["x_amount2"]; // takes the manually entered amount
  }
  
  if (isset($_POST["x_amount1"])) {
   if ( $x_amount1 > 0.00 ) {
  $x_amount = $_POST["x_amount1"]; // if there is a pre-defined amount selected, even if there is a value entered in "other", it takes the pre-defined amount.
  } else { $x_amount = $_POST["x_amount2"]; // if there is an "other" amount and its radio button is selected, it takes it. 
  } 
}

if ($x_amount < '0.01'){
echo '<h2>You must first enter an amount before proceeding.';
echo '<h2>Please return to the donation form and select an amount to donate.</h2>';
echo '<br>';
?>
<script>
function goBack() {
    window.history.back();
}
</script>
<?php
echo '<button type="submit" onclick="goBack()">Go Back</button>';
}
else {
	$recurring = isset($_POST['recurring']); // 
	if ( $recurring == TRUE) {
	$x_recurring_billing = "TRUE"; // Sets up recurring.
	} else { ($x_recurring_billing = "FALSE"); //  
	} 
$x_currency_code = $_POST["x_currency_code"];	
$x_invoice_num = $_POST["x_invoice_num"];
$x_po_num = $_POST["x_po_num"];
$x_reference_3 = $_POST["x_reference_3"];
$x_user1 = $_POST["x_user1"];
$x_user2 = $_POST["x_user2"];
$x_user3 = $_POST["x_user3"];
$x_login = $_POST["x_login"];
$x_recurring_billing_id = $_POST["x_recurring_billing_id"];
$x_recurring_billing_start_date = date('Y-m-d', strtotime("+30 days"));
$x_recurring_billing_end_date = date('Y-m-d', strtotime("+4 years"));   
$x_first_name = $_POST["x_first_name"];
$x_last_name = $_POST["x_last_name"];
$x_address = $_POST["x_address"];
$x_city = $_POST["x_city"];
$x_state = $_POST["x_state"];
$x_zip = $_POST["x_zip"];
$x_country = $_POST["x_country"];
$x_email = $_POST["x_email"];
$x_phone = $_POST["x_phone"];

// If there is a Reference Number sent from the form, it is used to populate
// the line item on the final payment form hosted by Payeezy. If not, the
// default "Your Donation" will be used. 
if (!empty($x_invoice_num)) {
$description = $x_invoice_num;
}
else { $description = "One-Time Donation";
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
<input name="x_address" value="<?php echo $x_address ;?>" type="hidden"> 
<input name="x_city" value="<?php echo $x_city ;?>" type="hidden"> 
<input name="x_state" value="<?php echo $x_state ;?>" type="hidden"> 
<input name="x_country" value="<?php echo $x_country ;?>" type="hidden"> 
<input name="x_zip" value="<?php echo $x_zip ;?>" type="hidden"> 
<input name="x_email" value="<?php echo $x_email ;?>" type="hidden">
<input name="x_phone" value="<?php echo $x_phone ;?>" type="hidden">
<input name="x_invoice_num" value="<?php echo $x_invoice_num ;?>" type="hidden">
<input name="x_po_num" value="<?php echo $x_po_num ;?>" type="hidden">
<input name="x_reference_3 " value="<?php echo $x_reference_3  ;?>" type="hidden">
<input name="x_user1" value="<?php echo $x_user1 ;?>" type="hidden">
<input name="x_user2" value="<?php echo $x_user2 ;?>" type="hidden">
<input name="x_user3" value="<?php echo $x_user3 ;?>" type="hidden">
<input name="x_recurring_billing" value="<?php echo $x_recurring_billing ;?>" type="hidden">
<input name="x_recurring_billing_amount" value="<?php echo $x_amount ;?>" type="hidden">
<input name="x_recurring_billing_start_date" value="<?php echo $x_recurring_billing_start_date ;?>" type="hidden">
<input name="x_recurring_billing_end_date" value="<?php echo $x_recurring_billing_end_date ;?>" type="hidden">
<input name="x_recurring_billing_id" value="<?php echo $x_recurring_billing_id ;?>" type="hidden">
<input name="x_line_item" value="Payment<|>Payment<|><?php echo $description ;?><|>1<|><?php echo $x_amount;?><|>N<|><|><|><|><|><|>0<|><|><|><?php echo $x_amount;?>"type="hidden">
<input type="hidden" name="x_show_form" value="PAYMENT_FORM"/>
</form>
<h2>Processing your  $<?php echo $x_amount;?> donation <?php echo $x_first_name;?>, please wait...</h2>
<script type='text/javascript'>document.myForm.submit();</script><!-- Automaticlly sends the final request to the Payeezy Gateway -->
<?php
} // end of else < 0.01
?>
</body>
</html>