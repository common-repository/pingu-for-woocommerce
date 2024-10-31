<?php
	include(dirname(__FILE__).'/all_etc_pingu.php');
	global $table_prefix, $wpdb, $woocommerce;
if(isset($_POST['the_e']))
{
	$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
	$the_mailid = sanitize_text_field($_POST['the_e']);
	$multi_add_ak = $table_prefix . "multi_add_ak";
	$results = $wpdb->get_results( "SELECT * FROM `".$table_prefix ."users` WHERE `user_email` = '$the_mailid'" );
	$res_mul = $wpdb->get_results("SELECT * FROM ".$multi_add_ak." WHERE `phone` = '$the_mailid' ", OBJECT);
	if(count($results) == 1)
	{
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		?>
		<div class="rep">
		<form class="l_f_top" method="POST" action="">
		<table>
		<tr><td>Password</td><td><input type="password" id="rep_p" name="rep_p"/></td></tr>		<tr><td></td><td><a href='<?php echo get_site_url() . '/my-account/lost-password/'; ?>'>Forgot password?</a></td></tr>
		<input type="hidden" id="the_mail_old" value="<?php echo $the_mailid; ?>" />
		<tr><td><input type="submit"value="Submit" id="rep_s" name="rep_s"/></td></tr>
		</table>
		</form>		<style>
		.l_f_top table tr td{border: none;!important}
		.l_f_top table tr{border: none;!important}
		#rep_s{background:#dd3333; border-radius:5px; border:none; margin:15px 0;}
		</style>
		</div>
		<script>
		jQuery('#rep_s').click(function(){
				var rep_p = jQuery('#rep_p').val();
				var rep_p22 = jQuery('#the_mail_old').val();
				if(rep_p == '')
				{
					jQuery('.ak_error2').remove();
					jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Field cannot be Empty.!</span>");
					return false;
				}
				else
				{
					jQuery.ajax({
					type: 'POST',
					url: "<?php echo $plugin_dir_url . 'ajax.php';?>",
					data: 'the_confirm='+rep_p+'&rep_old_id='+rep_p22,
					success: function(response)
					{
						if(response == 'yes' )
						{
							window.location.reload();
						}
						else
						{
							jQuery('.ak_error2').remove();
							jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Incorrect.!</span>");
							return false;
						}
					}
					});
				}
				return false;
			});
			jQuery( "#rep_p" ).keyup(function(){
			var rep_p = jQuery('#rep_p').val();
				if(rep_p == '')
				{
					jQuery('.ak_error2').remove();
					jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Field cannot be Empty.!</span>");
					return false;
				}
				else
				{
					jQuery('.ak_error2').remove();
				}
			});
			jQuery('#rep_p').click(function(){
			var rep_p = jQuery('#rep_p').val();
				if(rep_p == '')
				{
					jQuery('.ak_error2').remove();
					jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Field cannot be Empty.!</span>");
					return false;
				}
				else
				{
					jQuery('.ak_error2').remove();
				}
			});
		</script>
		<?php
	}
	elseif(count($res_mul) >= 1)
	{
		 $plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		 $bat = $res_mul[0]->phone;
		 $bat2 = $res_mul[0]->email;
		global $wpdb;
		$results2by = $wpdb->get_results( "SELECT * FROM `".$table_prefix ."users` WHERE `user_login` = '$bat2'" );
		if(count($results2by) >= 1)
		{
			$cxnx = $bat2;
		}
		else
		{
			$cxnx = $bat;
		}
		?>
		<div class="rep">
		<form class="l_f_top" method="POST" action="">
		<table>
		<tr><td>Password</td><td><input type="password" id="rep_p" name="rep_p"/></td></tr>
		<tr><td></td><td><a href='<?php echo get_site_url() . '/my-account/lost-password/'; ?>'>Forgot password?</a></td></tr>
		<input type="hidden" id="the_phn" value="<?php  echo $cxnx; ?>" />
		<tr><td><input type="submit"value="Submit" id="rep_s" name="rep_s"/></td></tr>
		</table>
		</form>
		<style>
		.l_f_top table tr td{border: none;!important}
		.l_f_top table tr{border: none;!important}
		#rep_s{background:#dd3333; border-radius:5px; border:none; margin:15px 0;}
		</style>
		</div>
		<script>
		jQuery('#rep_s').click(function(){
				var rep_p = jQuery('#rep_p').val();
				var rep_p22 = jQuery('#the_phn').val();
				alert(the_phn);
				if(rep_p == '')
				{
					jQuery('.ak_error2').remove();
					jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Field cannot be Empty.!</span>");
					return false;
				}
				else
				{
					jQuery.ajax({
					type: 'POST',
					url: "<?php echo $plugin_dir_url . 'ajax.php';?>",
					data: 'the_confirm='+rep_p+'&rep_old_id='+rep_p22,
					success: function(response)
					{
						if(response == 'yes' )
						{
							window.location.reload();
						}
						else
						{
							jQuery('.ak_error2').remove();
							jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Incorrect.!</span>");
							return false;
						}
					}
					});
				}
				return false;
			});
			jQuery( "#rep_p" ).keyup(function(){
			var rep_p = jQuery('#rep_p').val();
				if(rep_p == '')
				{
					jQuery('.ak_error2').remove();
					jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Field cannot be Empty.!</span>");
					return false;
				}
				else
				{
					jQuery('.ak_error2').remove();
				}
			});
			jQuery('#rep_p').click(function(){
			var rep_p = jQuery('#rep_p').val();
				if(rep_p == '')
				{
					jQuery('.ak_error2').remove();
					jQuery("#rep_p").after("<span class ='ak_error2' style='color:red'><br/>Password Field cannot be Empty.!</span>");
					return false;
				}
				else
				{
					jQuery('.ak_error2').remove();
				}
			});
		</script>
		<?php
	}
	else
	{
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		?>
		<div class="rep">
		<form class="l_f_top" method="POST" action="">
		<table>
		<tr><td>New Password</td><td><input type="password" id="rep_pn2" name="rep_pn2"/></td></tr>
		<tr><td>Confirm Password</td><td><input type="password" id="rep_cp2" name="rep_cp2"/></td></tr>
		<input type="hidden" id="the_mail_h" value="<?php echo $the_mailid; ?>" />
		<tr><td><input type="submit"value="Submit" id="rep_s2" name="rep_s2"/></td></tr>
		</table>
		</form>
		</div>		<style>
		.l_f_top table tr td{border: none;!important}
		.l_f_top table tr{border: none;!important}
		#rep_s2{background:#dd3333; border-radius:5px; border:none; margin:15px 0;}
		</style>
		<script>
		jQuery('#rep_s2').click(function(){
						var rep_pn2 = jQuery('#rep_pn2').val();
						var rep_cp2 = jQuery('#rep_cp2').val();
						var rep_mm = jQuery('#the_mail_h').val();
						if(rep_pn2 == '')
						{
							jQuery('.ak_error4').remove();
							jQuery("#rep_pn2").after("<span class ='ak_error4' style='color:red'><br/>New Password Field cannot be Empty.!</span>");
							return false;
						}
						else if((rep_pn2.length) <= '5')
						{
							jQuery('.ak_error4').remove();

							jQuery("#rep_pn2").after("<span class ='ak_error4' style='color:red'><br/>New Password must be atleast 6 Digits.!</span>");

							return false;
						}
						else if(rep_cp2 == '')
						{
							jQuery('.ak_error4').remove();
							jQuery("#rep_pn2").after("<span class ='ak_error4' style='color:red'><br/>Confirm Password Field cannot be Empty.!</span>");
							return false;
						}
						if(rep_pn2 != rep_cp2)
						{
							jQuery('.ak_error4').remove();
							jQuery("#rep_cp2").after("<span class ='ak_error4' style='color:red'><br/>New Password and Confirm Password Field Donot Match.!</span>");
							return false;
						}
						else
						{
							jQuery.ajax({
							type: 'POST',
							url: "<?php echo $plugin_dir_url . 'ajax.php';?>",
							data: 'the_nw='+rep_pn2+'&rep_mailid='+rep_mm,
							success: function(response)
							{
								if(response == 'yes' )
								{
									window.location.reload();
								}
								else
								{
									alert('awdawd');
								}
							}
							});
						}
						return false;
					});
		</script>
		<?php
	}
}

if($_POST['the_confirm'] != '')
{
	$username = sanitize_text_field($_POST['rep_old_id']);
	$password = sanitize_text_field($_POST['the_confirm']);
	$results22 = $wpdb->get_results( "SELECT * FROM `".$table_prefix ."users` WHERE `user_login` = '$username'" );
	foreach($results22 as $god)
	{
		$hash = $god->user_pass;
		$user_id = $god->ID;
		$ddd = wp_check_password( $password, $hash, $user_id );
		if($ddd)
		{
			$user = get_user_by( 'id', $user_id ); 
			wp_set_current_user( $user_id, $user->user_login );
			wp_set_auth_cookie( $user_id );
			do_action( 'wp_login', $user->user_login );
			echo "yes";
		}
	}
}

if($_POST['the_nw'] != '')
{
	$username = sanitize_text_field($_POST['rep_mailid']);
	$password = sanitize_text_field($_POST['the_nw']);		
	$email = sanitize_text_field($_POST['rep_mailid']);
	$created = wp_create_user( $username, $password, $email);
	$results225 = $wpdb->get_results( "SELECT * FROM `".$table_prefix ."users` WHERE `user_login` = '$username'" );
	foreach($results225 as $super)
	{
		$user_id = $super->ID;
		$user = get_user_by( 'id', $user_id ); 
		wp_set_current_user( $user_id, $user->user_login );
		wp_set_auth_cookie( $user_id );
		do_action( 'wp_login', $user->user_login );
		echo "yes";
	}
}

if(isset($_POST['nak_u']))
{
	if ( $woocommerce->cart->get_cart_contents_count() == 0 ) {
	echo "no";
	}
	else
	{
	echo "yes";
	}
}

if($_POST['the_pc'] != '')
{
		$pcr= sanitize_text_field($_POST['the_pc']);
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
		$cart_item_key;
		if($cart_item['product_id'] == $pcr )
		{
			$woocommerce->cart->remove_cart_item( $cart_item_key );
			echo "Removed";
		}
		}
}

if(isset($_POST['gola_me']))
{
echo '<tr class="order-total">
<th>Total</th>
<td><strong><span class="amount">';
echo $woocommerce->cart->get_cart_total();
echo '</span></strong></td>
</tr>
<style>
.wc-proceed-to-checkout{display:none;}
</style>';
}
?>