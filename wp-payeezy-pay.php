<?php
/*
Plugin Name: WP Payeezy Pay
Version: 2.69
Plugin URI: http://gravityrocket.com/
Description: Connects a WordPress site to First Data's Payeezy Gateway using the Payment Page/Hosted Checkout method of integration. 
Author: Rick Rottman
Author URI: http://gravityrocket.com/
*/

define( 'WP_PAYEEZY_DIR', trailingslashit( dirname( __FILE__ ) ) );

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

if ( $overridden_template = locate_template( 'wp-payeezy-form.php' ) ) {
	// locate_template() returns path to file if either the child
	// theme or the parent theme have overridden the template
	include $overridden_template;
} else {
	// If neither the child nor parent theme have overridden the template,
	// we load the template from the 'templates' sub-directory.
	include WP_PAYEEZY_DIR . 'templates/wp-payeezy-form.php';
}

return ob_get_clean();

}

add_action( 'template_include', 'wppayeezypay_maybe_post' );
function wppayeezypay_maybe_post( $original_template ) {
	if ( isset( $_POST['wp_payeezy_pay'] ) &&
		 wp_verify_nonce( $_POST['wp_payeezy_pay'], 'wp_payeezy_post' ) ) {

		$mode2 = get_option ('mode2') ; // payments or donations
		if ( $mode2 == "pay") {
			$pay_file = WP_PAYEEZY_DIR . 'pay.php';
		}

		// Payments WITH the option of making the payment recurring.
		elseif ( $mode2 == "pay-rec" ) {
			$pay_file = WP_PAYEEZY_DIR . 'pay-rec.php';
		}

		// Payments WITH the option of making the payment recurring.
		elseif ( $mode2 == "pay-rec-req" ) {
			$pay_file = WP_PAYEEZY_DIR . 'pay-rec.php';
		}

		// Donations WITHOUT the option of making the donation recurring.
		elseif ( $mode2 == "donate"  ) {
			$pay_file = WP_PAYEEZY_DIR . 'donate.php';
		}

		// Donations WITH the option of making the donation recurring.
		else {
			$pay_file = WP_PAYEEZY_DIR . 'donate-rec.php';
		}
		return $pay_file;
	}
	// Else.
	return $original_template;
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
