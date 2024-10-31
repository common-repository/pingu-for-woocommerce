<?php
function Pingu_for_Woocommerce_fun_page()
{
	add_submenu_page( 'woocommerce', 'Pingu For WooCommerce', 'Pingu For WooCommerce', 'manage_options', 'my_pingu_for_woocommerce_page', 'Pingu_For_WooCommerce_main_set_page', '');	
	global $wpdb;
	$table_name = $wpdb->prefix . "multi_add_ak";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
      $sql = "CREATE TABLE " . $table_name . " (
      id mediumint(225) NOT NULL AUTO_INCREMENT,
      cus_id varchar(225) NOT NULL,
      div_id varchar(225) NOT NULL,
      country varchar(225) NOT NULL,
      fname varchar(225) NOT NULL,
      lname varchar(225) NOT NULL,
      street_add varchar(225) NOT NULL,
      apart varchar(225) NOT NULL,
      city varchar(225) NOT NULL,
      state varchar(225) NOT NULL,
      pcode varchar(225) NOT NULL,
      email varchar(225) NOT NULL,
      phone varchar(225) NOT NULL,
      PRIMARY KEY  (id)
      );";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
   }
}

		$plugin_file = 'Pingu-For-WooCommerce/main.php';
		add_filter( "plugin_action_links_{$plugin_file}", 'pingu_for_woocomerce_action_link', 10, 2 );
		function pingu_for_woocomerce_action_link( $links, $file ) 
		{
			$settings_link = '<a href="' . admin_url( 'admin.php?page=my_pingu_for_woocommerce_page' ) . '">' . __( 'Settings', 'my_pingu_for_woocommerce_page' ) . '</a>';
			array_unshift( $links, $settings_link );
			return $links;
		}
		 
		add_filter( 'woocommerce_product_add_to_cart_text', 'Pingu_cart_button_txt' );    // 2.1 +
		function Pingu_cart_button_txt() {
			global $woocommerce;
			foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];
				if( get_the_ID() == $_product->id ) {
					return __('Already in cart', 'woocommerce');
				}
			}
			return __('Add to cart', 'woocommerce');
		}
		add_action( 'woocommerce_review_order_after_submit', 'pingu_for_woocomerce_cartrev' );
		function pingu_for_woocomerce_cartrev()
		 {
			 ?>
				<script>
				jQuery(document).ready(function(){
					jQuery('.whs_go').click(function(){
						window.location.href = '<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>';
					});
				});
				</script>
			 <?php
		 }
		 
		function Pingu_For_WooCommerce_main_set_page()
		{
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		if(isset($_POST['my_sub']))
		{
			global $wpdb;
			$rfview = sanitize_text_field($_POST['vc_sel']);
			update_option( 'view_r_or_l', $rfview, no );
			
			$vc_txt = sanitize_text_field($_POST['vc_txt']);
			update_option( 'vc_cs_txt', $vc_txt, no );
			
			$vc_col = sanitize_text_field($_POST['vc_col']);
			update_option( 'vc_cs_col', $vc_col, no );
			
			$bx_mn_col = sanitize_text_field($_POST['box_vc_main']);
			update_option( 'box_mn_col', $bx_mn_col, no );
			
			$put_box_width = sanitize_text_field($_POST['box_width']);
			update_option( 'the_box_width', $put_box_width, no );
			
			$put_box_height = sanitize_text_field($_POST['box_height']);
			update_option( 'the_box_height', $put_box_height, no );
			
			$ck_box_cl_v = sanitize_text_field( $_POST['ck_box_cl'] );
			update_option( 'ck_cl_ckp', $ck_box_cl_v, no );
			
			echo "<h4 style='color:green'>Settings saved!</h4>";
		}
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		?>
		<style>
			.buy_now_pingufw a{
			text-decoration:none; color:white; display:block; 
			  width:84px;
			  -webkit-border-radius: 5px;
			  -moz-border-radius: 5px;
			  border-radius: 5xp;
			  border-radius:5px;
			  font-family: Courier New;
			  color: #ffffff;
			  font-size: 20px;
			 
			  padding: 12px;
			  text-decoration: none;
              background:#0091CD;
			}
				
			.buy_now_pingufw {
			 display:inline-block; margin-right:15px;
			}
			
			.text_buy_nw{display:inline-block; color:#fff; font-size:16px;}

			.main_buy_pp{background:#006600; padding:20px;}
			
			.main-all h1{line-height:30px!important;}
			.tech_add2 img{max-width:800px;}
			
			@media screen and (max-width:767px){
				.buy_now_pingufw{margin-bottom:20px;}
				.main-all img{width:100%}
			}
			
			</style>
		<div class="main-all">
		<a href='http://www.techpingu.com/' target='_blank'><div class='tech_add2'><img src="<?php echo $plugin_dir_url . 'img/TechPingu.jpg';?>"/></div></a>
		<br/><hr/>
		<h1>Pingu For WooCommerce : Settings</h1>
		<form action="" method="post">
		<table class="wp-list-table widefat fixed striped posts">
		<tbody id="the-list">
		<tr class=" author-self level-0 post-30 type-post status-draft format-standard category-aaaa entry">
		<td>
		<h3>Shop Page Settings</h3>
		</td><td></td><td></td>
		</tr>
		<tr class=" author-self level-0 post-30 type-post status-draft format-standard category-aaaa entry">
			<td><h4>1. View Cart Position : </h4></td><td>
			<select class="vc_sel" name="vc_sel" style="width:150px; border-radius:3px">
			<?php $getl_or_r = get_option( 'view_r_or_l', $default ); ?>
			<option <?php if($getl_or_r == 'Right'){ echo "selected"; } else if($rfview['vc_sel'] == 'Right'){ echo "selected"; } ?> value="Right">Right</option>
			<option	<?php if($getl_or_r == 'Left'){ echo "selected"; } else if($rfview['vc_sel'] == 'Left'){ echo "selected"; } ?> value="Left">Left</option>
			</select></td><td><input type="text" id="box_vc_main" name="box_vc_main" value="<?php $get_box_main = get_option( 'box_mn_col', $default ); if($get_box_main != '' ){ echo $get_box_main ; } else { echo '#74b24a' ; }?>" />
			</td>
		</tr>
		<tr class=" author-self level-0 post-30 type-post status-draft format-standard category-aaaa entry">
		<td><h4>2. ViewCart Text : </h4></td><td><input style="width:150px; border-radius:3px" type="text" value="<?php $get_vc =  get_option( 'vc_cs_txt', $default ); if($get_vc != '' ){ echo $get_vc ; } ?>" id="vc_txt" <?php if($get_vc == '') { echo 'Placeholder = "View Cart"' ; } ?> name="vc_txt" maxlength="25"/></td><td> <input type="text" name="vc_col" value="<?php $get_vs_col = get_option( 'vc_cs_col', $default ); if($get_vs_col != '' ){ echo $get_vs_col ; } else { echo '#dd3333' ; }?>" id="vc_cs_col" />
		</td>
		</tr>

		<tr class=" author-self level-0 post-30 type-post status-draft format-standard category-aaaa entry">
		<td><h4>3. Remove Change Login button : </h4></td>
		<td><?php $ck_bx_qry = get_option( 'ck_cl_ckp', $default ); ?>
		<input type="checkbox" value="1" <?php if($ck_box_cl_v == 1){ echo "checked"; } else if($ck_bx_qry['ck_box_cl'] == 1){ echo "checked"; }?>  id="ck_box_cl" name="ck_box_cl" >
		</td><td></td>
		</tr>
		<tr><td>
			<input type="submit" style="width:120px" name="my_sub" class="button button-primary" value="Save Settings">
		</td><td></td><td></td></tr>
		</tbody>
		</table>
		</form>
		<br/><hr/><br/>
		<div class='main_buy_pp'><div class='buy_now_pingufw'>
				<a href='http://products.techpingu.com/product/pingu-for-woocommerce/'>Buy Now</a>
			</div><div class='text_buy_nw'>Click on Buy Now button to buy the Premium version of Pingu For WooCommerce.</div></div><br/><br/><hr/>
			<h1><u>Premium version images are shown below:</u></h1><br/><br/>
			<h3>1. Checkout Page.</h3><br/>
			<img class='pr_img' src="<?php echo $plugin_dir_url . 'img/pr1.jpg';?>"/><br/><hr/><br/>
			<h3>2. Backend Settings page.</h3><br/><br/>
			<img class='pr_img' src="<?php echo $plugin_dir_url . 'img/pr2.jpg';?>"/>
			</div>
		<script>
		jQuery(document).ready(function(){
			jQuery('#vc_cs_col').wpColorPicker();
			jQuery('#scc_col').wpColorPicker();
			jQuery('#box_vc_main').wpColorPicker();
			jQuery('#cl_txt_col').wpColorPicker();
			jQuery('#cl_box_c').wpColorPicker();
			jQuery('#all_box_c').wpColorPicker();
		})
		</script>
		<?php
		}
		add_action("template_redirect", 'Pingu_for_woocommerce_redirection');
		function Pingu_for_woocommerce_redirection()
		{
			global $woocommerce;
			if( is_cart() && sizeof($woocommerce->cart->cart_contents) == 0){
				wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
			}
			if( is_cart() && sizeof($woocommerce->cart->cart_contents) >= 1){
			wp_safe_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
			exit;
			}
		}
		function Pingu_For_WooCommerce_cart_item(){
			remove_action( 'wp_logout', array( WC()->session, 'destroy_session' ) );
		} 
		add_action( 'woocommerce_init', 'Pingu_For_WooCommerce_cart_item' );
		add_action( 'woocommerce_before_shop_loop' , 'Pingu_For_WooCommerce_shop_loop' );
		function Pingu_For_WooCommerce_shop_loop()
		{
				global $woocommerce;
				$checkout_url = $woocommerce->cart->get_checkout_url();
				$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
				?>
				<div class="ffgg">
				<h2><?php $sac_text_get =  get_option( 's_a_c_text', $default ); if($sac_text_get != '' ){ echo $sac_text_get ; } else { echo "Successfully added to Cart" ; } ?></h2>
				<a title = 'click to goto Cart' href='<?php echo $checkout_url; ?>'> <?php $vc_check =  get_option( 'vc_cs_txt', $default ); if($vc_check != '' ){ echo $vc_check ; } else { echo "View Cart" ; } ?></a>
				<img class="pop_cls" src ="<?php echo $plugin_dir_url . 'img/fg.png';?>"/>
				</div>
				<style>
				.ffgg{display:none; position:relative;}
				.pop_cls{position:absolute;top:0px;right:0px;}
				.woocommerce #content, .woocommerce-page #content{ overflow:visible!important;}
				.added_to_cart.wc-forward{ display: none !important;}
				#content{position:relative;}
				.ffgg{width:<?php $fth_box_width = get_option( 'the_box_width', $default ); if($fth_box_width != '' ){ echo $fth_box_width ; } else { echo '340' ; }?>px;
				box-shadow: 0px 10px 14px -7px rgb(62, 115, 39); position:absolute; top:-68px; right:-20px; <?php $ram_char =  get_option( 'view_r_or_l', $default ); if($ram_char != '' ){ echo $ram_char ; } else { echo "Right" ; } ?>:0%; z-index:9999;
				height:<?php $fth_box_height = get_option( 'the_box_height', $default ); if($fth_box_height != '' ){ echo $fth_box_height ; } else { echo '140' ; }?>px;
						background: <?php $main_bx_col =  get_option( 'box_mn_col', $default ); if($main_bx_col != '' ){ echo $main_bx_col ; } else { echo "#74b24a" ; } ?>;
						border-radius: 4px; border: 1px solid rgb(75, 143, 41); cursor: pointer; font-family: Arial; font-size: 18px; font-weight: bold; font-style: italic; padding: 7px 18px; text-decoration: none; text-shadow: 0px 1px 0px rgb(91, 138, 60);}
				.ffgg {margin:0 0 0px 0;}
				.ffgg h2{color: <?php $scc_col_gt =  get_option( 's_a_c_col', $default ); if($scc_col_gt != '' ){ echo $scc_col_gt ; } else { echo "#000000" ; } ?> ;}
				.ffgg a{color: <?php $vc_col_me =  get_option( 'vc_cs_col', $default ); if($vc_col_me != '' ){ echo $vc_col_me ; } else { echo "#dd3333" ; } ?> ;display:block; margin:0 0 5px 0;}
			    .my-az-rem{font-size:14px!important; width:100%; padding:15px 0!important;
					   text-align:center!important;}
				.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button
					{font-size:14px!important; display:block!important; float:none!important; padding:10px 0!important; 
					   text-align:center!important;}
			
				
			@media screen and (max-width: 640px){
			
			{width:50%!important; height:auto!important; }
			.ffgg h2{font-size:18px;}
			.products button{font-size:12px!important;}
			}
			
			@media screen and (max-width: 480px){
				{width:66%!important;}
				}
			
			@media screen and (max-width:360px){
			.ffgg{width:100%!important;}	
			.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button
			{font-size:12px!important;}
			.whs_go.ak_bgo.full-bot{width:100%!important; float:left; border-radius:5px; background:#73B353; border: 1px solid rgb(75, 143, 41);}
			
			
			}
			
				</style>
				<script type="text/javascript">
				jQuery(document).ready(function(){
					fgjs = "<?php echo $plugin_dir_url.'ajax/ajax.php';?>";
					ccjs = "<?php echo $plugin_dir_url.'ajax/ajax.php';?>";
					fgtxt = "<?php $sac_text_get =  get_option( 's_a_c_text', $default ); if($sac_text_get != '' ){ echo $sac_text_get ; } else { echo "Successfully added to Cart" ; } ?>";
					jQuery('.pop_cls').click(function(){
						jQuery('.ffgg').css({'display':'none'});
					});
				});
				</script>
				<?php
				wp_enqueue_script( 'script_ak_jsreq', $plugin_dir_url.'js/js_f1.js', array('jquery'), false, true );
		}

			add_action('woocommerce_cart_updated', 'Pingu_For_WooCommerce_cart_updated');
			function Pingu_For_WooCommerce_cart_updated() {
			if ( !empty($_POST['is_wac_ajax'])) {
				$resp = array();
				$resp['update_label'] = __( 'Update Cart', 'woocommerce' );
				$resp['price'] = 0;
				ob_start();
				do_action( 'woocommerce_after_cart_table' );
				do_action( 'woocommerce_cart_collaterals' );
				do_action( 'woocommerce_after_cart' );
				$resp['html'] = ob_get_clean();
				if ( !empty($_POST['cart_item_key']) ) {
					$items = WC()->cart->get_cart();
					$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
					if ( array_key_exists($cart_item_key, $items)) {
						$cart_item = $items[$cart_item_key];
						$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$price = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						$resp['price'] = $price;
					}
				}
				echo json_encode($resp);
				exit;
			}
		}
			add_action( 'woocommerce_before_checkout_form', 'Pingu_For_WooCommerce_before_checkout' );
			function Pingu_For_WooCommerce_before_checkout()
			{
				$d_qry_for_cl = get_option( 'ck_cl_ckp', $default );
				if($d_qry_for_cl != '')
				{	
							$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
							wp_enqueue_script('google-autocomplete', "https://maps.googleapis.com/maps/api/js?v=3&libraries=places");
							wp_enqueue_script( 'script_auto_jsreq', $plugin_dir_url .'js/auto.js');
							?>
							<button class ='my_order_tab amit'>Order Details
							</button></br>
							<div class ='all_pr'><div class="cart_call"><?php print do_shortcode( '[woocommerce_cart]'); ?>
							</div></div>
							<button class="show_deliv amit">Delivery Address</button>
							<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500"/>
							<div class="main_tab">
							<form class="checkout woocommerce-checkout" enctype="multipart/form-data" action="" method="post" name="checkout">
							<div class="chk_f">
							<input type="hidden" id="cus_id_p" value="<?php global $current_user; echo $current_user->ID; ?>"/>
							<div class ='my_bill'>
							<div class="mul_call">
										<script>
										jQuery(document).ready(function(){
										jQuery('#bill_ship').show();
										jQuery('.add_new').hide();
										jQuery('.cont').show();
										});
										</script>
							</div>
							<div class="myyy_div">
							<div id="bill_ship">			
							</div>			
							</div>
							</div>			
							</div>			
							<button class = "cont amit">Save & Continue To Payment</button>
							<div class ='my_pay_tab'><h4>Payment Details</h4></div>
							<div class ='my_pay'></div>
							</form>
							</div>
						<?php
				}
				else
				{
						if (!is_user_logged_in())
						{
							$my_log_get = get_option( 'log_phn_save', $default );
							if($my_log_get != '')
							{
								$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
							?>
									<form method="post" action="">
									<div class="response">
									<div class="rep">
									Enter Your Email Id/Phone No.:		
									<input type="text" id="new_e" name="new_e"/>
									<input type="submit"value="Submit" id="new_s" name="new_s"/>
									</div>
									</div>
									</form>
									<button disabled class ='my_order_tab amit'>Order Details</button>
										<div class='pus_main'>
										<?php
											global $woocommerce;
											$items = $woocommerce->cart->get_cart();
												$i = '1';
												foreach($items as $item => $values) { 
													$_product = $values['data']->post; 
													echo $i++." . <b> ".$_product->post_title.'</b> , Quantity: '.$values['quantity']; 
													$price = get_post_meta($values['product_id'] , '_price', true);
													
													echo " , Price: ".$price * $values['quantity'].".</br>";
												} 
										?>
										</div>
									<button disabled class="show_deliv amit">Delivery Address</button>
									<button disabled class = "cont amit">Save & Continue To Payment</button>
									<style>
									.woocommerce-info{display:none}
									#new_s{background:#dd3333!important; border-radius:5px; border:none; margin:15px 0;}
									</style>
									<script type="text/javascript">
									jQuery(document).ready(function(){	
									jQuery('#new_s').click(function(){
										var a1 = jQuery('#new_e').val();
										if(a1 == '')
										{
											jQuery('.ak_error').remove();
											jQuery("#new_s").after("<span class ='ak_error' style='color:red'><br/>Email Address/Phone cannot be left empty.!</span>");
											return false;
										}
										else
										{
											jQuery.ajax({
											type: 'POST',
											url: "<?php echo $plugin_dir_url . 'ajax/ajax.php';?>",
											data: 'the_e='+a1,
											success: function(response)
											{
												jQuery('.rep').replaceWith(response);
											}
											});
											return false;
										}
									});
								});
									</script>
							<?php
							}
							else
							{
								$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
							?>
									
									<form method="post" action="">
									<div class="response">
									<div class="rep">
									Enter Your Email Id:		
									<input type="text" id="new_e" name="new_e"/>
									<input type="submit"value="Submit" id="new_s" name="new_s"/>
									</div>
									</div>
									</form>
									<button disabled class ='my_order_tab amit'>Order Details</button>
										<div class='pus_main'>
										<?php
											global $woocommerce;
											$items = $woocommerce->cart->get_cart();
												$i = '1';
												foreach($items as $item => $values) { 
													$_product = $values['data']->post; 
													echo $i++." . <b> ".$_product->post_title.'</b> , Quantity: '.$values['quantity']; 
													$price = get_post_meta($values['product_id'] , '_price', true);
													
													echo " , Price: ".$price * $values['quantity'].".</br>";
												} 
										?>
										</div>
									<button disabled class="show_deliv amit">Delivery Address</button>
									<button disabled class = "cont amit">Save & Continue To Payment</button>
									<style>
									.woocommerce-info{display:none}
									#new_s{background:#dd3333!important; border-radius:5px; border:none; margin:15px 0;}
									</style>
									<script type="text/javascript">
									jQuery(document).ready(function(){
										jQuery('.my_order_tab').click(function(){
											jQuery('.pus_main').slideToggle();
										});
									jQuery('#new_s').click(function(){
										var a1 = jQuery('#new_e').val();
										function isValidEmailAddress(a1) {
										var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
										return pattern.test(a1);
										};
										if(a1 == '')
										{
											jQuery('.ak_error').remove();
											jQuery("#new_e").after("<span class ='ak_error' style='color:red'><br/>Email Address cannot be left empty.!</span>");
											return false;
										}
										else if( !isValidEmailAddress( a1 ) ) 
										{ 
											jQuery('.ak_error').remove();
											jQuery("#new_e").after("<span class ='ak_error' style='color:red'><br/>Email Format not Correct (example - paul@viber.com).!</span>");
											return false;
										}
										else
										{
											jQuery.ajax({
											type: 'POST',
											url: "<?php echo $plugin_dir_url . 'ajax/ajax.php';?>",
											data: 'the_e='+a1,
											success: function(response)
											{
												jQuery('.rep').replaceWith(response);
											}
											});
											return false;
										}
									});
								});
									</script>
							<?php
							}
							?>
							<style>
							.woocommerce-billing-fields{display:none !important}
							#order_review_heading{display:none !important}
							#order_review{display:none !important}
							.woocommerce-shipping-fields{display:none !important}
							</style>
							<?php
						}			
						else if (is_user_logged_in()) 
						{	
							global $current_user;
							?>
							<div class="cstm_all"><div class="cstm_email_txt">Logged in as: <b><?php echo $current_user->user_login; ?></b></div>
							<em><a class="confirmation amit4" href="<?php echo wp_logout_url(get_permalink()); ?>"><?php $ct_cl_sv =  get_option( 'ct_cl_txt_sv', $default ); if($ct_cl_sv != '' ){ echo $ct_cl_sv ; } else { echo "CHANGE LOGIN" ; }?></a></em>
							</div>
							<script>
							jQuery(document).ready(function(){
								jQuery('.whs_go').click(function(){
									window.location.href = '<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>';
								});
							});
							</script>
							<style>
							.ak_anc{font-style: normal;}
							.amit4{box-shadow: 0px 5px 5px -7px rgb(255, 176, 176); background-color:<?php $cl_box_get =  get_option( 'cl_box_col_sav', $default ); if($cl_box_get != '' ){ echo $cl_box_get ; } else { echo "#dd3333" ; } ?>; border-radius: 4px; border: 1px solid rgb(168, 65, 65); cursor: pointer; font-family: Arial; font-size: 13px; font-weight: bold; padding:5px 10px; text-decoration: none;  margin:0 0 10px 0; display:inline-block;}
							.amit4{color:<?php $cl_txt_col_me =  get_option( 'cl_txt_col_sav', $default ); if($cl_txt_col_me != '' ){ echo $cl_txt_col_me ; } else { echo "#F7F7F7" ; } ?>!important;}
							.whs_go.ak_anc.full-buy-top{float:right!important;  border-radius:5px; background:#73B353; border: 1px solid rgb(75, 143, 41);  font-size: 13px !important;
							font-weight: 600; padding: 8px 8px; width: auto !important; }
							@media screen and (max-width: 640px){
								.amit4{padding:7px 10px;}
								.woocommerce .quantity .qty{width:4em!important;}
								.woocommerce table.shop_table td{padding:2px!important;}
								.product-name{width:auto!important;}
								.product-name a{font-size:12px!important;}
								.product-price{width:60px!important;}
								.product-price span{font-size:12px!important}
							}
							
							@media screen and (max-width: 320px){
								
								.cstm_all em .whs_go.ak_anc.full-buy-top{float:none!important; display:inline-block!important; margin-bottom:10px!important;}
								}
								
							
							</style>
                            
							<?php
							$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
							wp_enqueue_script('google-autocomplete', "https://maps.googleapis.com/maps/api/js?v=3&libraries=places");
							wp_enqueue_script( 'script_auto_jsreq', $plugin_dir_url .'js/auto.js');
							?>
							<button class ='my_order_tab amit'>Order Details
							</button></br>
							<div class ='all_pr'><div class="cart_call"><?php print do_shortcode( '[woocommerce_cart]'); ?></div></div>
							<button class="show_deliv amit">Delivery Address</button>
							<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500"/>
							<div class="main_tab">
							<form class="checkout woocommerce-checkout" enctype="multipart/form-data" action="" method="post" name="checkout">
							<div class="chk_f">
							<input type="hidden" id="cus_id_p" value="<?php global $current_user; echo $current_user->ID; ?>"/>
							<div class ='my_bill'>
							<div class="mul_call">
										<script>
										jQuery(document).ready(function(){
										jQuery('#bill_ship').show();
										jQuery('.add_new').hide();
										jQuery('.cont').show();
										});
										</script>
							</div>
							<div class="myyy_div">
							<div id="bill_ship">			
							</div>			
							</div>
							</div>			
							</div>			
							<button class = "cont amit">Save & Continue To Payment</button>
							<div class ='my_pay_tab'><h4>Payment Details</h4></div>
							<div class ='my_pay'></div>
							</form>
							</div>
 <style>
@media screen and (max-width:640px){
	.woocommerce-placeholder.wp-post-image{width:100%!important; height:100%!important;}
	}
							</style>
						<?php
						}		
				}
					$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
					wp_enqueue_style( 'style_ak_req', $plugin_dir_url.'css/style.css' );
					?>
					<script type="text/javascript">
					jQuery('.woocommerce-error').hide();
						jQuery(document).ready(function(){
							jQuery('.shop_table').addClass('khopcha');
						jQuery('.all_pr form').attr('action', '<? echo get_permalink(); ?>');
						var elems = document.getElementsByClassName('confirmation');
						var confirmIt = function (e) {
							if (!confirm('Are you sure to Change Email?')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener('click', confirmIt, false);
						}
						
						var woocommercefORM = jQuery("#customer_details");
						woocommercefORM.clone(true).appendTo('#bill_ship');
						woocommercefORM.remove();
						
						var woocommercePayment = jQuery("#payment");
						woocommercePayment.clone(true).appendTo('.my_pay');
						woocommercePayment.remove();
						
						var woocommerceOrder = jQuery("#order_review");
						woocommerceOrder.clone(true).appendTo('.my_ordr');
						woocommerceOrder.remove();
						jQuery( "#billing_address_1" ).before( "Street Address :" );
						jQuery( "#billing_address_2" ).before( "Apartment, Suite, House No. etc :" );
						jQuery(".woocommerce-billing-fields h3").replaceWith( "<h4>Fill Your Shipping Details!</h4>" );
						jQuery(".woocommerce-shipping-fields h3").replaceWith( '<h4 id="ship-to-different-address"><label class="checkbox" for="ship-to-different-address-checkbox">Bill to a different address?</label><input id="ship-to-different-address-checkbox" class="input-checkbox" type="checkbox" value="1" name="ship_to_different_address"></h4>' );
						jQuery('#order_review_heading').hide();
						jQuery('.woocommerce-info').hide();
						jQuery('.woocommerce-error').hide();
						var jdj = jQuery('.woocommerce-error li').html();
						if(!jdj)
						{
							jQuery('.cou').remove();
						}
						else
						{
							jQuery('<tr><td class="cou" colspan="6"><h4 style="color:red!important;">'+jdj+'</h4></td></tr>').insertAfter('.cart_item:last');
						}
						var jdj2 = jQuery('.woocommerce-message').html();
						if(!jdj2)
						{
							jQuery('.cou2').remove();
						}
						else
						{
							jQuery('<tr><td class="cou2" colspan="6"><h4 style="color:green!important;">'+jdj2+'</h4></td></tr>').insertAfter('.cart_item:last');
						}
						jQuery('.checkout-button').hide();
						jQuery('.my_pay').hide();
						jQuery('.my_pay_tab').hide();
						jQuery('#order_comments_field').hide();
						jQuery('.shipping').hide();
						jQuery('.close_clk').hide();
					

					
					jQuery('.show_deliv').live('click', function(){
						jQuery('.main_tab').show();
						jQuery('.mul_call').show();
						jQuery('.add_new').show();
						jQuery('.all_pr').hide();
						jQuery('.my_pay').hide();
						jQuery('.my_pay_tab').hide();
						jQuery('.cont').show();
						jQuery('html, body').animate({
							scrollTop: jQuery(".show_deliv").offset().top - 10 }, 'slow');
					});
					jQuery('.add_new').live('click' , function(adnw)					
					{
						adnw.preventDefault();
						jQuery('#bill_ship').show('slow');
						jQuery('.cont').show();
						jQuery('.my_pay_tab').hide();
						jQuery('.my_pay').hide();
						jQuery('.close_clk').show();
					});
					jQuery('.close_clk').live('click' , function(adnw)					
					{
						adnw.preventDefault();
						jQuery('.cont').hide();
						jQuery('.my_pay_tab').hide('slow');
						jQuery('.my_pay').hide('slow');
						jQuery('.close_clk').hide('slow');
					});
					jQuery('.del_add').live('click' , function(qq)					
					{
						qq.preventDefault();
						var deladd = jQuery('.del_class').val();
						var curr_i = jQuery('#cus_id_p').val();
								jQuery.ajax({
								type: 'POST',
								url: "<?php echo $plugin_dir_url . 'ajax/ajax.php';?>",
								data: 'del_add='+deladd+'&cur='+curr_i,
								success: function(response)
								{
									jQuery(".mul_call").replaceWith(response);
									alert("Address has been Deleted!")
								}
								});
					});
					jQuery('.addr_add').live('click', function(rr)					
					{						
							rr.preventDefault();												
							var carr = jQuery(this).find('.hid_div_class').val();						
							var courep = jQuery(".counn" + carr).val();						
							var statrep = jQuery(".stan" + carr).val();						
							var frep = jQuery(".fnn" + carr).html();						
							var lrep = jQuery(".lnn" + carr).html();						
							var strep = jQuery(".snn" + carr).html();						
							var aprep = jQuery(".apn" + carr).html();
							var ctrep = jQuery(".ctn" + carr).html();
							var erep = jQuery(".emn" + carr).html();
							var pcrep = jQuery(".pcn" + carr).html();
							var phrep = jQuery(".phnn" + carr).html();												
							jQuery('#billing_country option[value='+ courep +']').prop('selected', 'selected').change();
							jQuery("#billing_first_name").val(frep);						
							jQuery("#billing_last_name").val(lrep);						
							jQuery("#billing_address_1").val(strep);						
							jQuery("#billing_address_2").val(aprep);						
							jQuery("#billing_city").val(ctrep);						
							jQuery("#billing_postcode").val(pcrep);						
							jQuery("#billing_email").val(erep);						
							jQuery("#billing_phone").val(phrep);
							if((statrep.length) >= '3')
							{
								jQuery('#billing_state').val(statrep);
								jQuery('.my_pay_tab').show('slow');
								jQuery('.my_pay').show('slow');
								jQuery(".add_new").hide();
								jQuery(".all_pr").hide();
							}
							else
							{
								setTimeout(						
								function(){							
								jQuery('#billing_state option[value='+ statrep +']').prop('selected', 'selected').change();
								jQuery('.my_pay_tab').show('slow');
								jQuery('.my_pay').show('slow');
								jQuery(".all_pr").hide();
								jQuery(".add_new").hide();
								},						
								500);
							}
					});	

					jQuery('.my_order_tab').live('click', function(){
						jQuery('.all_pr').slideToggle();
						jQuery('.main_tab').hide();
					});
					
					jQuery('.woocommerce-remove-coupon').click(function(){
						setTimeout(						
									function(){							
									window.location.href = window.location.href;
									},						
								500);
						});
					jQuery('.cont').click(function(event){
						event.preventDefault();
						var country = jQuery('#billing_country').val();
						var cusid = jQuery('#cus_id_p').val();
						var fname = jQuery('#billing_first_name').val();
						var lname = jQuery('#billing_last_name').val();
						var add = jQuery('#billing_address_1').val();
						var apart = jQuery('#billing_address_2').val();
						var cty = jQuery('#billing_city').val();
						var pcode = jQuery('#billing_postcode').val();
						var bem = jQuery('#billing_email').val();
						var bphn = jQuery('#billing_phone').val();
						var sel_st = jQuery('#billing_state').val();
						
						function ValidEmailAddress(bem) {
								var pattern2 = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
								return pattern2.test(bem);
								};
						
						if(fname == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_first_name").after("<span class ='ak_err' style='color:red'>Fill First Name!</span>");
							return false;
						}
						else if(lname == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_last_name").after("<span class ='ak_err' style='color:red'>Fill Last Name!</span>");
							return false;
						}
						else if(add == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_address_1").after("<span class ='ak_err' style='color:red'>Fill Address!</span>");
							return false;
						}
						else if(apart == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_address_2").after("<span class ='ak_err' style='color:red'>Fill Apartment/House No.!</span>");
							return false;
						}
						else if(cty == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_city").after("<span class ='ak_err' style='color:red'>Fill Address!</span>");
							return false;
						}
						else if(pcode == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_postcode").after("<span class ='ak_err' style='color:red'>Fill PostCode!</span>");
							return false;
						}
						else if(bem == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_email").after("<span class ='ak_err' style='color:red'>Fill Your Email!</span>");
							return false;
						}
						else if( !ValidEmailAddress( bem ) ) 
								{ 
									jQuery('.ak_err').remove();
									jQuery("#billing_email").after("<span class ='ak_err' style='color:red'><br/>Email Format not Correct!</span>");
									return false;
								}
						else if(bphn == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_phone").after("<span class ='ak_err' style='color:red'>Fill Your Phone-No.!</span>");
							return false;
						
						}else if(isNaN(bphn))
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_phone").after("<span class ='ak_err' style='color:red'>Only Numbers allowed!</span>");
							return false;
						}
						
						else if(sel_st == '')
						{
							jQuery('.ak_err').remove();
							jQuery("#billing_state").after("<span class ='ak_err' style='color:red'>Select a State.!</span>");
							return false;
						}
						else
						{
							jQuery('.ak_err').remove();
							jQuery.ajax({
								type: 'POST',
								url: "<?php echo $plugin_dir_url . 'ajax/ajax.php';?>",
								data: 'cusid='+cusid+'&country='+country+'&fname='+fname+'&lname='+lname+'&street='+add+'&apart='+apart+'&city='+cty+'&state='+sel_st+'&pcode='+pcode+'&email='+bem+'&phone='+bphn ,
								success: function(response)
								{
									jQuery(".my_pay").show();
									jQuery(".all_pr").show();
									jQuery(".close_clk").hide();
									jQuery(".add_new").hide();
								}
								});
							jQuery('.my_pay').show('slow');
							jQuery('.my_pay_tab').show('slow');														
						}
						
						});
					});
					
				jQuery(document).ready(function(){
					jQuery('.qty').live('change', function(){
					form = jQuery(this).closest('form');
					jQuery("<input type='hidden' name='update_cart' id='update_cart' value='1'>").appendTo(form);
					jQuery("<input type='hidden' name='is_wac_ajax' id='is_wac_ajax' value='1'>").appendTo(form);
					el_qty = jQuery(this);
					matches = jQuery(this).attr('name').match(/cart\[(\w+)\]/);
					cart_item_key = matches[1];
					form.append( jQuery("<input type='hidden' name='cart_item_key' id='cart_item_key'>").val(cart_item_key) );
					formData = form.serialize();
					jQuery("input[name='update_cart']").val('Updating...').prop('disabled', true);
					jQuery.post( form.attr('action'), formData, function(resp) 
					{
							jQuery('.cart-collaterals').html(resp.html);
							el_qty.closest('.cart_item').find('.product-subtotal').html(resp.price);
							jQuery('#update_cart').remove();
							jQuery('#is_wac_ajax').remove();
							jQuery('#cart_item_key').remove();
							jQuery("input[name='update_cart']").val(resp.update_label).prop('disabled', false);
							jQuery('.checkout-button').hide();
							var nobi_lg = 'hello world';
							jQuery.ajax({
									type: 'POST',
									url: "<?php echo $plugin_dir_url . 'ajax/ajax.php';?>",
									data:'gola_me='+nobi_lg,
									success: function(response)
									{
										jQuery('.order-total').replaceWith(response);
									}
								});
							},
							'json'
						);
					});
				});
					</script>
					<style>
					.amit{width:100%; box-shadow: 0px 5px 5px -7px rgb(62, 115, 39); background:rgb(119, 181, 90) linear-gradient(to bottom, <?php $get_all_box_c =  get_option( 'all_box_col_sav', $default ); if($get_all_box_c != '' ){ echo $get_all_box_c ; } else { echo "#74b24a" ; } ?> 5%, <?php $get_all_box_c =  get_option( 'all_box_col_sav', $default ); if($get_all_box_c != '' ){ echo $get_all_box_c ; } else { echo "#74b24a" ; } ?> 100%) repeat scroll 0% 0% !important;
					border-radius: 4px; border: 1px solid rgb(75, 143, 41); cursor: pointer; color: <?php $get_all_tcl =  get_option( 'all_box_txtc_sav', $default ); if($get_all_tcl != '' ){ echo $get_all_tcl ; } else { echo "#ffffff" ; } ?>; font-family: Arial; font-size: 13px; font-weight: bold; font-style: italic; padding: 7px 5px; text-decoration: none; text-shadow: 0px 1px 0px rgb(91, 138, 60); margin:0 0 10px 0;}

					.amit3{height:35px;width:100px;box-shadow: 0px 5px 5px -7px rgb(62, 115, 39);
					background: rgb(119, 181, 90) linear-gradient(to bottom, <?php $gt_con_add_bx = get_option( 'con_add_bx_col', $default ); if($gt_con_add_bx != '' ){ echo $gt_con_add_bx ; } else { echo '#74b24a'; }?> 5%, <?php $gt_con_add_bx = get_option( 'con_add_bx_col', $default ); if($gt_con_add_bx != '' ){ echo $gt_con_add_bx ; } else { echo '#74b24a' ; }?> 100%) repeat scroll 0 0 !important; border-radius: 4px; border: 1px solid rgb(75, 143, 41); cursor: pointer; color: rgb(255, 255, 255); font-family: Arial; font-size: 10px; font-weight: bold; font-style: italic; padding: 5px; text-decoration: none; text-shadow: 0px 1px 0px rgb(91, 138, 60); line-height:11px;}

					.add_new { width: 50% !important;}
					.whs_go.ak_bgo.full-bot{width:auto; float:left; border-radius:5px; background:#73B353; border: 1px solid rgb(75, 143, 41); font-size:13px!important; padding:10px!important; text-shadow:1px 1px 1px #666; color:#fff; font-style:italic; font-weight:600!important;}
					.amit2{height:35px;width:90px;box-shadow: 0px 10px 14px -7px rgb(255, 176, 176);
					background: rgb(224, 47, 56) linear-gradient(to bottom, <?php $gt_con_add_bx1 = get_option( 'del_adr_bx_sav', $default ); if($gt_con_add_bx1 != '' ){ echo $gt_con_add_bx1 ; } else { echo '#dd3333' ; }?> 5%, <?php $gt_con_add_bx1 = get_option( 'del_adr_bx_sav', $default ); if($gt_con_add_bx1 != '' ){ echo $gt_con_add_bx1 ; } else { echo '#dd3333' ; }?> 100%) repeat scroll 0% 0% !important; border-radius: 4px; border: 1px solid rgb(168, 65, 65); cursor: pointer; color: rgb(255, 255, 255); font-family: Arial; font-size: 13px; font-weight: bold; padding: 5px; text-decoration: none; text-shadow: 0px 1px 0px rgb(235, 14, 14); display:inline-block; vertical-align:top;}
					table td.actions input.button:nth-child(2){display:none!important;}
					.woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text	
					{width:200px!important; margin-right:10px!important;}	
					#place_order{box-shadow: 0px 5px 5pxpx -7px rgb(62, 115, 39); background: rgb(119, 181, 90) linear-gradient(to bottom, rgb(119, 181, 90) 5%, rgb(114, 179, 82) 100%) repeat scroll 0% 0% !important; border-radius: 4px; border: 1px solid rgb(75, 143, 41); cursor: pointer; color: rgb(255, 255, 255); font-family: Arial; font-size: 13px; font-weight: bold; font-style: italic; padding: 10px; text-decoration: none; text-shadow: 0px 1px 0px rgb(91, 138, 60); float:right!important; width:auto!important}
					#coupon_code {float:left}
					.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {float:right; width:45%}
					@media screen and (max-width:768px){
						
						.woocommerce #content table.cart .product-thumbnail, .woocommerce table.cart .product-thumbnail, .woocommerce table.my_account_orders tr td.order-actions::before, .woocommerce-page #content table.cart .product-thumbnail, .woocommerce-page table.cart .product-thumbnail, .woocommerce-page table.my_account_orders tr td.order-actions::before
						{display:block!important;}
						.attachment-shop_thumbnail.wp-post-image{max-width:50px!important; height:46px!important; padding:0; margin:0;}
						
					}
					
					@media screen and (max-width:640px){
						.whs_go{width:40%!important}
					.woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text	
					{width:120px!important;}			
					.woocommerce #content table.cart td.actions .button.alt, .woocommerce #content table.cart td.actions .input-text + .button, .woocommerce table.cart td.actions .button.alt, .woocommerce table.cart td.actions .input-text + .button, .woocommerce-page #content table.cart td.actions .button.alt, .woocommerce-page #content table.cart td.actions .input-text + .button, .woocommerce-page table.cart td.actions .button.alt, .woocommerce-page table.cart td.actions .input-text + .button	
					{float:none!important; margin-left:3%!important;}
					}
					
					@media screen and (max-width: 480px){
						.woocommerce form {overflow-x:scroll; overflow-y:hidden; -webkit-overflow-scrolling: touch;}				
						table.shop_table.cart.khopcha{width:480px!important; float:left; }
						.whs_go{font-size:9px !important; height: 37px;}
						.woocommerce #payment #place_order, .woocommerce-page #payment #place_order{font-size:12px!important; height:37px!important; margin-top: 3px;}
						.show_mul_here {width:100%!important;}
						.amit3{width:47%!important;}
						.amit2{width:47%!important; margin-left:2%;}
						.woocommerce #payment #place_order, .woocommerce-page #payment #place_order{width:auto!important;}
						.whs_go.ak_bgo.full-bot{width:160px!important; margin-top:3px;}
					}
					@media screen and (max-width: 320px){
						.woocommerce form{overflow-x:scroll; overflow-y:hidden; -webkit-overflow-scrolling: touch;}				
						table.shop_table.cart.khopcha{width:480px!important; float:left;  }	
						.caberty{display:block; text-align:center;}
						.whs_go.ak_bgo.full-bot{font-size:12px!important; margin: 0 20%!important; }
						#place_order{font-size:12px!important; margin:0 28% 20px 28%!important; float:none!important;}	
						
					}
					</style>
					<?php
			
}
?>