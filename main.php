<?php
/*
Plugin Name: Pingu For WooCommerce Free Version
Plugin URI: http://www.TechPingu.com
Description: The Plugin lets the user to save multiple addresses and change email address without loosing cart items.User shops in a very simplified way with auto update of cart items through ajax. User finds the checkout more easy and compact with the tabbing system(tabs for order/delivery address/payment box). Backend settings are very helpful to customize the plugin as per theme.
Author: TechPingu
Version: 1.1
Author URI: http://www.techpingu.com/
*/
/**
 * Exit if accessed directly
 **/
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
/**
 * Get The Function File
 **/
require_once(dirname(__FILE__).'/function_file.php');
require_once(dirname(__FILE__).'/ajax/ajax.php');
/**
 * Add actions for backend menu(settings and submenu)
 **/
add_action('admin_menu', 'Pingu_for_Woocommerce_fun_page');
}