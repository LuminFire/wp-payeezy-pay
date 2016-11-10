<?php
/*
Plugin Name: WP Payeezy Pay
Version: 2.68
Plugin URI: http://gravityrocket.com/
Description: Connects a WordPress site to First Data's Payeezy Gateway using the Payment Page/Hosted Checkout method of integration. 
Author: Rick Rottman
Author URI: http://gravityrocket.com/
*/

function wppayeezypaymentform() {
$x_login = get_option('x_login');
$x_recurring_billing_id = get_option('x_recurring_billing_id');
$x_currency_code = get_option('x_currency_code');
$mode = get_option ('mode') ; // production or demo
$mode2 = get_option ('mode2') ; // payments or donations
$button_text= get_option ('button_text') ; // 
$wp_payeezy_stylesheet = plugins_url('wp-payeezy-pay/css/stylesheet.css');
$wp_payeezy_states = plugins_url('wp-payeezy-pay/select/states.txt'); 
$wp_payeezy_countries = plugins_url('wp-payeezy-pay/select/countries.txt'); 
$url_to_stylesheet = $wp_payeezy_stylesheet; 


if ( $mode2 == "pay") {
  $pay_file = plugins_url('wp-payeezy-pay/pay.php'); 
}
// Payments WITH the option of making the payment recurring.
  elseif ( $mode2 == "pay-rec" ) {
      $pay_file = plugins_url('wp-payeezy-pay/pay-rec.php'); 
}

// Payments WITH the option of making the payment recurring.
elseif ( $mode2 == "pay-rec-req" ) {
  $pay_file = plugins_url('wp-payeezy-pay/pay-rec.php'); 
}

// Donations WITHOUT the option of making the donation recurring.
elseif ( $mode2 == "donate"  ) {
    $pay_file = plugins_url('wp-payeezy-pay/donate.php'); 
}

// Donations WITH the option of making the donation recurring.
else {
    $pay_file = plugins_url('wp-payeezy-pay/donate-rec.php'); 
}

if ( $button_text == "pay-now") {
  $button = 'Pay Now'; 
}

elseif ( $button_text == "donate-now") {
      $button = 'Donate Now'; 
}

elseif ( $button_text == "continue") {
      $button = 'Continue'; 
}

elseif ( $button_text == "make-it-so") {
      $button = 'Make it so'; 
}

else {
      $button = 'Continue to Secure Payment Form'; 
}


// This is the Ref. Num that shows in Transactions on the front page.
$x_invoice_num = get_option('x_invoice_num');

// This is the Cust. Ref. Num that shows in Transactions on the front page. Also referred
// to as Purchase Order or PO number. It's a reference number submitted by the customer
// for their own record keeping.

$x_po_num = get_option('x_po_num');

// This shows up on the final order form as "Item" unless Invoice Number is used.
// If there is an Invoice Number sent, that overrides the Description. 

$x_description = get_option('x_description');

// Just an extra reference number if Invoice Number and Customer Reference Number are
// not enough referance numbers for your purposes. 

$x_reference_3 = get_option('x_reference_3');

// Next three are custom fields that if passed over to Payeezy, will show populated on
// the secure order form and the information collected will be passed a long with all the
// other info. 

$x_user1 = get_option('x_user1') ;
$x_user2 = get_option('x_user2') ;
$x_user3 = get_option('x_user3') ;

// If you want to collect the customer's phone number and/or email address, you can do so
// by giving these two fields a name, such as "phone" and "email."

$x_phone = get_option('x_phone') ;
$x_email = get_option('x_email') ;

// 
$x_amount = get_option('x_amount') ;
$x_company = get_option('x_company') ;


ob_start(); // stops the shortcode output from appearing at the very top of the post/page.
?>
<?php
$wp_payeezy_form_stylesheet = plugins_url('wp-payeezy-pay/css/stylesheet.css'); 
echo file_get_contents( "$wp_payeezy_form_stylesheet" ); ?>
<!-- v.2.68 -->
<div id="wp_payeezy_payment_form">
<form action="<?php echo $pay_file;?>" method="post">
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
<?php
return ob_get_clean();

}

// create custom plugin settings menu
add_action('admin_menu', 'wppayeezypay_create_menu');
function wppayeezypay_create_menu() {

//create new top-level menu
add_menu_page(
  'WP Payeezy Pay', // page title
   'WP Payeezy Pay', // menu title display
    'administrator', // minimum capability to view the menu
     'wp-payeezy-pay/wp-payeezy-pay.php', // the slug
      'wppayeezypay_settings_page', // callback function used to display page content
       plugin_dir_url( __FILE__ ) . 'images/icon.png');

//call register settings function
add_action( 'admin_init', 'register_wppayeezypay_settings' );
}

$x_login = get_option('x_login');

if ( !file_exists(plugin_dir_path(__FILE__) . $x_login . '.php') ) {
add_action( 'admin_notices', 'wppayeezypay_no_transaction_key' );
}

function wppayeezypay_no_transaction_key() {  
      echo '<div class="error"><p>WP Payeezy Pay does not have a Transaction Key file saved. Please go into WP Payeezy Pay and press the "Update WP Payeezy Settings" button at the bottom of the screen</p></div>';
}

add_shortcode('wp_payeezy_payment_form', 'wppayeezypaymentform');

function register_wppayeezypay_settings() {
//register our settings
register_setting( 'wppayeezypay-group', 'x_login' );
register_setting( 'wppayeezypay-group', 'transaction_key' );
register_setting( 'wppayeezypay-group', 'response_key' );
register_setting( 'wppayeezypay-group', 'x_recurring_billing_id' );
register_setting( 'wppayeezypay-group', 'x_currency_code' );
register_setting( 'wppayeezypay-group', 'x_amount' );
register_setting( 'wppayeezypay-group', 'x_user1' );
register_setting( 'wppayeezypay-group', 'x_user2' );
register_setting( 'wppayeezypay-group', 'x_user3' );
register_setting( 'wppayeezypay-group', 'mode' ); // Production or Demo
register_setting( 'wppayeezypay-group', 'mode2' ); // Payments of Donations
register_setting( 'wppayeezypay-group', 'button_text' );
register_setting( 'wppayeezypay-group', 'x_invoice_num' );
register_setting( 'wppayeezypay-group', 'x_po_num' );
register_setting( 'wppayeezypay-group', 'x_description' );
register_setting( 'wppayeezypay-group', 'x_reference_3' );
register_setting( 'wppayeezypay-group', 'x_phone' );
register_setting( 'wppayeezypay-group', 'x_email' );
register_setting( 'wppayeezypay-group', 'x_company' );
}

function wppayeezypay_settings_page() {
$readme_wp_payeezy_pay = plugins_url('wp-payeezy-pay/readme.txt');
?>
<div class="wp-payeezy-pay-wrap">
<style>
a {
  text-decoration: none;
}
</style>
  <h2>WP Payeezy Pay version 2.68</h2>
    <div style="background-color: transparent;border: none;color: #444;margin: 0; float:left;padding: none;width:950px">    
    <form method="post" action="options.php">
      <?php settings_fields( 'wppayeezypay-group' ); ?>
      <?php do_settings_sections( 'wppayeezypay-group' ); ?>
       <div style="background: none repeat scroll 0 0 #fff;border: 1px solid #bbb;color: #444;margin: 10px 20px 0 0; float:left;padding: 20px;text-shadow: 1px 1px #FFFFFF;width:500px">
       <h3>Required Settings</h3>
      
      <table class="form-table">
        <tr valign="top">
      <th scope="row">Currency Code</th>
       <td valign="top"><input type="text" size="5" name="x_currency_code" value="<?php echo esc_attr( get_option('x_currency_code') ); ?>" required/><br>
        <em>Needs to be a three-letter code and it must match the Currency Code of the terminal. For the United States Dollar, enter USD. For other currencies, <a href="https://support.payeezy.com/hc/en-us/articles/203730689-Payeezy-Gateway-Supported-Currencies" target="_blank">here is the list</a>.</em></td>  

      </tr>
      <tr valign="top">
        <th scope="row">Payment Page ID</th>
          <td valign="top"><input type="text" style="font-family:'Lucida Console', Monaco, monospace;" size="35" name="x_login" value="<?php echo esc_attr( get_option('x_login') ); ?>" required/></td>
      </tr>
      <tr valign="top">
      <th scope="row">Transaction Key</th>
        <td valign="top"><input type="text" style="font-family:'Lucida Console', Monaco, monospace;" size="35" name="transaction_key" value="<?php echo esc_attr( get_option('transaction_key') ); ?>" required/></td>  
      </tr>

</tr>
      <tr valign="top">
      <th scope="row">Response Key</th>
        <td valign="top"><input type="text" style="font-family:'Lucida Console', Monaco, monospace;" size="35" name="response_key" value="<?php echo esc_attr( get_option('response_key') ); ?>" /><br>
        <em> Required only if you are using an add-on premium plugin <a href="http://gravityrocket.com/payeezy-premium/" target="_blank">handles transaction results from Payeezy.</em></td>  
      </tr>

      <tr valign="top">
        <th scope="row">Mode</th>
          <td><select name="mode"/>
            <option value="live" <?php if( get_option('mode') == "live" ): echo 'selected'; endif;?> >Live</option>
            <option value="demo" <?php if( get_option('mode') == "demo" ): echo 'selected'; endif;?> >Demo</option>
            </select><br>
           <em>To get a free Payeezy demo account,<br> <a href="https://provisioning.demo.globalgatewaye4.firstdata.com/signup" target="_blank">go here.</em>
          </td>

      </tr>
      <tr valign="top">
        <th scope="row">Type of Transactions</th>
          <td><select name="mode2"/>
            <option value="pay" <?php if( get_option('mode2') == "pay" ): echo 'selected'; endif;?> >Payments</option>
            <option value="pay-rec" <?php if( get_option('mode2') == "pay-rec" ): echo 'selected'; endif;?> >Payments with optional Recurring</option>
            <option value="pay-rec-req" <?php if( get_option('mode2') == "pay-rec-req" ): echo 'selected'; endif;?> >Payments with automatic Recurring</option>
            <option value="donate" <?php if( get_option('mode2') == "donate" ): echo 'selected'; endif;?> >Donations</option>
            <option value="donate-rec" <?php if( get_option('mode2') == "donate-rec" ): echo 'selected'; endif;?> >Donations with optional Recurring</option>
            </select>
          </td>
      </tr>

      <tr valign="top">
        <th scope="row">Button Text</th>
          <td><select name="button_text"/>
            <option value="pay-now" <?php if( get_option('button_text') == "pay-now" ): echo 'selected'; endif;?> >Pay Now</option>
            <option value="donate-now" <?php if( get_option('button_text') == "donate-now" ): echo 'selected'; endif;?> >Donate Now</option>
            <option value="make-it-so" <?php if( get_option('button_text') == "make-it-so" ): echo 'selected'; endif;?> >Make it so</option>
            <option value="continue" <?php if( get_option('button_text') == "continue" ): echo 'selected'; endif;?> >Continue</option>
            <option value="continue-to-secure" <?php if( get_option('button_text') == "continue-to-secure" ): echo 'selected'; endif;?> >Continue to Secure Payment Form</option>
            </select><br>
           <em>This is the text that is displayed on the button a cardholder selects to go to the secure form hosted by First Data.</em></td>
      </tr>

    </table>
    <hr>
      <h3>Optional Settings</h3>
      <table class="form-table">
      <tr valign="top">
      <th scope="row">Amount</th>
       <td valign="top"><span class="large">$</span><input type="text" size="7" name="x_amount" value="<?php echo esc_attr( get_option('x_amount') ); ?>" /><br>
        <em>If an amount is entered above, the card holder will not have the option of entering an amount. They will be charged what you enter here.</em></td>  
      </tr>

      
      <tr valign="top">
        <th scope="row">Recurring Billing ID</th>
          <td valign="top"><input type="text" style="font-family:'Lucida Console', Monaco, monospace;" size="35" name="x_recurring_billing_id" value="<?php echo esc_attr( get_option('x_recurring_billing_id') ); ?>" /><br>
          <em>Leave blank unless processing recurring transactions. The recurring plan <b>must</b> have the Frequecy set to "Monthly."</em></td>
        <?php
        // If one of the recurring modes is selected and there is not a Recurring Plan ID entered,
        // a red warning appears next to the field pointing out that one needs to be entered. 
        $recurring = get_option('x_recurring_billing_id');
        if (empty($recurring)) {
        if (( get_option('mode2') === "pay-rec") || ( get_option('mode2') === "donate-rec" ) || ( get_option('mode2') === "pay-rec-req" )){ 
          echo "<td valign='top' style='color:red'>&#8656; Please enter a Recurring Billing ID</td>";
        }}
          ?>
        </tr>
       
    </table>
    <hr>
    <h3>Optional Payment Form Fields</h3>
    <table class="form-table">
      <tr valign="top"> <em>If you would like to use any of these fields, just assign a name to them
        and they will appear on your form with that name. Do not assign a name, and they will not appear. If a field appears on your form,
        the cardholder cannot proceed to Payeezy until they enter a value.</em> </tr>
      <tr valign="top">
        <th scope="row">x_invoice_num</th>
        <td><input type="text" name="x_invoice_num" value="<?php echo esc_attr( get_option('x_invoice_num') ); ?>" /><br>
        <em>Truncated to the first 20 characters and becomes part of the transaction. It appears in column “Ref Num” under Transaction Search.</em></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_po_num</th>
        <td><input type="text" name="x_po_num" value="<?php echo esc_attr( get_option('x_po_num') ); ?>" /><br>
        <em>Purchase order number. Truncated to the first 20 characters and becomes part of the transaction. It appears in column “Customer Reference Number” under Transaction Search.</em></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_reference_3</th>
        <td><input type="text" name="x_reference_3" value="<?php echo esc_attr( get_option('x_reference_3') ); ?>" /><br>
        <em>Additional reference data. Maximum length 30 and becomes part of the transaction. It appears in column "Reference Number 3" under Transaction Search.</em></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_user1</th>
        <td><input type="text" name="x_user1" value="<?php echo esc_attr( get_option('x_user1') ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_user2</th>
        <td><input type="text" name="x_user2" value="<?php echo esc_attr( get_option('x_user2') ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_user3</th>
        <td><input type="text" name="x_user3" value="<?php echo esc_attr( get_option('x_user3') ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_phone</th>
        <td><input type="text" name="x_phone" value="<?php echo esc_attr( get_option('x_phone') ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_email</th>
        <td><input type="text" name="x_email" value="<?php echo esc_attr( get_option('x_email') ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_description</th>
        <td><input type="text" name="x_description" value="<?php echo esc_attr( get_option('x_description') ); ?>" /><br>
        <em>This field is a large textarea input that the customer can write a note or memo. Not displayed to the customer.</em></td>
      </tr>
      <tr valign="top">
        <th scope="row">x_company</th>
        <td><input type="text" name="x_company" value="<?php echo esc_attr( get_option('x_company') ); ?>" /><br>
       </td>
      </tr>
    </table>
    
<?php
   submit_button('Update WP Payeezy Settings'); 

   // Begin process of saving the transaction key to a seperate php file.
    $transaction_key = ( get_option('transaction_key') );
    $base = dirname(__FILE__); // That's the directory path
    $filename = get_option('x_login') . '.php';
    $fileUrl = $base . '/' . $filename;
    $data = '<?php $transaction_key = "'. get_option('transaction_key') . '"?>';
    file_put_contents($fileUrl, $data);
    // end of process of saving transaction key
?>
    
</form>
 </div>
<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #bbb;color: #444;margin: 10px 0; float:left;padding: 20px;text-shadow: 1px 1px #FFFFFF;width:300px">
<p>To add the Payeezy payment form to a Page or a Post, add the following <a href="https://codex.wordpress.org/Shortcode" target="_blank">shortcode</a> in the Page or Post's content:<br>
<p style="text-align:center;font-size: 120%;font-family:'Lucida Console', Monaco, monospace;">[wp_payeezy_payment_form]</p> 
</div>

<div style="background-color: #fff;background-position: bottom right;border: 1px solid #bbb;color: #444;margin: 10px 0; float:left;padding: 20px;text-shadow: 1px 1px #FFFFFF;width:300px">
<p>If you like <b>WP Payeezy Pay</b> please leave a <a href="https://wordpress.org/support/view/plugin-reviews/wp-payeezy-pay?filter=5#postform" target="_blank">★★★★★</a> rating.</p>
<p>You can also buy me a coffee by throwing <a href="https://www.paypal.me/RichardRottman">a few bucks my way</a>.</p>
</div>

<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #bbb;color: #444;margin: 10px 0; float:left;padding: 20px;text-shadow: 1px 1px #FFFFFF;width:300px">
<p>Need help? If it's plugin related, check out the official <a href="https://wordpress.org/support/plugin/wp-payeezy-pay/" target="_blank">WP Payeezy Pay Support Forum</a>.</p>
<p>If it has to do with Payeezy and not the plugin, call Payeezy Hosted Checkout (HCO) support at 855-448-3493, option 2, and then option 3.</p>
</div>

<?php $url_to_stylesheet = site_url( 'wp-admin/plugin-editor.php?file=wp-payeezy-pay%2Fcss%2Fstylesheet.css&plugin=wp-payeezy-pay%2Fcss%2Fwp-payeezy-pay.php');
?>
<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #bbb;color: #444;margin: 10px 0; float:left;padding: 20px;text-shadow: 1px 1px #FFFFFF;width:300px">
 <p>If you'd like to change the way the payment form looks on your website, you can edit the stylesheet. </p>
 <a class="button" style="display: block;text-align: center" href="<?php echo $url_to_stylesheet;?>" target="_blank">Open Stylesheet in Plugin Editor</a>
</div>

</div>
<?php } ?>