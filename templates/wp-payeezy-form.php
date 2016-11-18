<?php
$wp_payeezy_form_stylesheet = plugins_url('wp-payeezy-pay/css/stylesheet.css'); 
echo file_get_contents( "$wp_payeezy_form_stylesheet" ); ?>
<!-- v.2.68 -->
<div id="wp_payeezy_payment_form">
<form method="post">
<?php wp_nonce_field( 'wp_payeezy_post', 'wp_payeezy_pay' ); ?>
<input name="x_recurring_billing_id" value="<?php echo $x_recurring_billing_id;?>" type="hidden" >
<input name="x_login" value="<?php echo $x_login;?>" type="hidden" >
<input name="mode" value="<?php echo $mode;?>" type="hidden" >
<input name="x_currency_code" value="<?php echo $x_currency_code;?>" type="hidden" >
<p><label>First Name</label><input name="x_first_name" value="" id="x_first_name" type="text" required></p> 
<p><label>Last Name</label><input name="x_last_name" id="x_last_name" value="" type="text" required></p> 
<?php if (!empty($x_company)) {
  echo '<p><label>';
  echo $x_company;
  echo '</label>';
  echo '<input name="x_company" value="" type="text" id="x_company" required>';
  echo '</p>';
}
else {
  echo '<input name="x_company" value="" type="hidden" >';
  }?>
<p><label>Street Address</label><input name="x_address" id="x_address" value="" type="text" required></p> 
<p><label>City</label><input name="x_city" id="x_city" value="" type="text" required></p> 
<p><label>State</label><select name="x_state" id="x_state" required>
<?php
echo file_get_contents( "$wp_payeezy_states" ); // 
?>
</select></p>
<p><label>Zip Code</label><input name="x_zip" id="x_zip" value="" type="text" required></p> 
<p><label>Country</label><select id="x_country" name="x_country" onchange="switch_province()" tabindex="10">
<?php
echo file_get_contents( "$wp_payeezy_countries" ); //
?>
</select></p>
     
<?php

//// Invoice ////
if (!empty($x_invoice_num)) {
  echo '<p><label>';
  echo $x_invoice_num;
  echo '</label>';
  echo '<input name="x_invoice_num" value="" type="text" id="x_invoice_num" required>';
  echo '</p>';
}
else {
  echo '<input name="x_invoice_num" value="" type="hidden" >';
  }

//// PO Number ////
  if (!empty($x_po_num)) {
    echo '<p><label>';
  echo $x_po_num;
  echo '</label>';
  echo '<input name="x_po_num" value="" type="text" id="x_po_num" required>';
  echo '</p>';
}

else {
  echo '<input name="x_po_num" value="" type="hidden">';
  }
//// Reference Number 3 ////
if (!empty($x_reference_3)) {
    echo '<p><label>';
  echo $x_reference_3;
  echo '</label>';
  echo '<input name="x_reference_3" value="" type="text" id="x_reference_3" required>';
  echo '</p>';
}

else {
  echo '<input name="x_reference_3" value="" type="hidden">';
  }

//// User Defined 1 //// 
if (!empty($x_user1)) {                                                              
    echo '<p><label>';
  echo $x_user1;
  echo '</label>';
  echo '<input name="x_user1" value="" type="text" id="x_user_1" required>';
  echo '</p>';
}

else {
  echo '<input name="x_user1" value="" type="hidden">';
  }

//// User Defined 2 ////
if (!empty($x_user2)) {
    echo '<p><label>';
  echo $x_user2;
  echo '</label>';
  echo '<input name="x_user2" value="" type="text" id="x_user_2" required>';
  echo '</p>';
}

else {
  echo '<input name="x_user2" value="" type="hidden">';
  }

//// User Defined 3 ////
if (!empty($x_user3)) {
    echo '<p><label>';
  echo $x_user3;
  echo '</label>';
  echo '<input name="x_user3" value="" type="text" id="x_user_3" required>';
  echo '</p>';
}

else {
  echo '<input name="x_user3" value="" type="hidden">';
  }

//// Email ////
if (!empty($x_email)) {
  echo '<p><label>';
  echo $x_email;
  echo '</label>';
  echo '<input name="x_email" value="" type="email" id="x_email" required>';
  echo '</p>';
}

else {
  echo '<input name="x_email" value="" type="hidden">';
  }

//// Phone Number ////
if (!empty($x_phone)) {
  echo '<p><label>';
  echo $x_phone;
  echo '</label>';
  echo '<input name="x_phone" value="" type="tel" id="x_phone" required>';
  echo '</p>';
}

else {
  echo '<input name="x_phone" value="" type="hidden">';
  }

//// Description ////
if ( !empty( $x_description ) ) {
  echo '<p><label>';
  echo $x_description;
  echo '</label>';
  echo '<textarea cols="40" rows="5" name="x_description" id="x_description"></textarea>';
  echo '</p>';
}

else {
  echo '<input name="x_description" value="" type="hidden">';
}


if (!empty($x_amount)) {
  
  echo '<input name="x_amount" value="';
  echo $x_amount;
  echo '" type="hidden" id="x_amount" >';
  
  }

else {

if (($mode2 == "donate") || ($mode2 == "donate-rec")) {
?>
<p><label>Donation Amount</label>
<?php
//$wp_payeezy_donation_amounts = plugins_url('wp-payeezy-pay/select/donation_amounts.php'); 
//echo file_get_contents( "$wp_payeezy_donation_amounts" ); ?>
<input type="radio" name="x_amount1" value="10.00"> $10&nbsp;<?php echo $x_currency_code;?></br>
<input type="radio" name="x_amount1" value="25.00"> $25&nbsp;<?php echo $x_currency_code;?></br>
<input type="radio" name="x_amount1" checked="checked" value="50.00"> $50&nbsp;<?php echo $x_currency_code;?></br>
<input type="radio" name="x_amount1" value="75.00"> $75&nbsp;<?php echo $x_currency_code;?></br>
<input type="radio" name="x_amount1" value="100.00"> $100&nbsp;<?php echo $x_currency_code;?></br>
<input type="radio" name="x_amount1" value="0.00"> Other $ <input name="x_amount2" id="x_amount2" value="" min="1" step="0.01" type="number">&nbsp;<?php echo $x_currency_code;?></br>
</p>
<?php
}
 
else {
echo '<p><label>Amount</label><input name="x_amount" id="x_amount" value="" min="1" step="0.01" type="number">&nbsp;';
echo $x_currency_code;
echo '</p>';
}

}

if ($mode2 == "donate-rec" ) {
      echo '<p><input type="checkbox" name="recurring" id="recurring" value="TRUE" >&nbsp;Automatically repeat this same donation once a month, beginning in 30 days.</p>';
}
// Pay with optional Recurring
if ($mode2 == "pay-rec" ) {
    echo '<p><input type="checkbox" name="recurring" id="recurring" value="TRUE" >&nbsp;Automatically repeat this same payment once a month, beginning in 30 days.</p> ';
}

// Pay with required Recurring
if ($mode2 == "pay-rec-req" ) {
    echo '<input type="hidden" name="recurring" value="TRUE" >';
}
?>
<p><input type="submit" id="submit" value="<?php echo $button;?>"></p>
</form>
<br>

</div>
