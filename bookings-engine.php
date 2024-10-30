<?php
/*
Plugin Name: Bookings Engine [Lite Edition]
Plugin URI: http://bookings-engine.com
Description: Bookings Engine is an Booking Calendar Plugin that will allow Wordpress sites to manage all their business bookings/appointments from single jolt.
Author: wp-plugin-guru
Version: 1.0.3
Author URI: http://bookings-engine.com
Copyright 2013 Bookings-Engine.com (email : help@bookings-engine.com)
*/
function executeCreateDatabaseCalls()
{
	include_once 'install-script.php';
	bookingEngineInstall();
}

define('bookings_engine', 'bookings_engine');
function executeDeleteDatabaseCalls()
{
 	global $wpdb;
	$sql = "DROP TABLE " .servicesTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .customersTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .bookingTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .social_Media_settingsTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .payment_Gateway_settingsTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .auto_Responders_settingsTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .generalSettingsTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .currenciesTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .countriesTable();
	$wpdb->query($sql);
		
	$sql = "DROP TABLE " .bookingFormTable();
	$wpdb->query($sql);
		
	$sql = "DROP TABLE " .email_templatesTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .multiple_bookingTable();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .coupons_products();
	$wpdb->query($sql);
	
	$sql = "DROP TABLE " .coupons();
	$wpdb->query($sql);

	$sql = "DROP TABLE " .block_outs();
	$wpdb->query($sql);	
	
	$sql = "DROP TABLE " .bookingsCountTable();
	$wpdb->query($sql);	
}
function servicesTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_Services";
}
function customersTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_Customers";
}
function currenciesTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_Currencies";
}
function countriesTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_Countries";
}
function email_templatesTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_email_templates";
}
function social_Media_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_social_media_Settings";
}
function payment_Gateway_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_payment_gateway_Settings";
}
function auto_Responders_settingsTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_auto_responders_settings";
}
function generalSettingsTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_general_settings";
}
function bookingTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_bookings";
}
function bookingFormTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_booking_form";
}
function multiple_bookingTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_multiple_booking";
}
function coupons()
{
	global $wpdb;
	return $wpdb->prefix . "be_coupons";
}
function coupons_products()
{
	global $wpdb;
	return $wpdb->prefix . 'be_coupon_products';
}
function block_outs()
{
	global $wpdb;
	return $wpdb->prefix . "be_blockouts";
}
function bookingsCountTable()
{
	global $wpdb;
	return $wpdb->prefix . "be_bookings_count";
}
function createMenusForBookingsEngine()
{
	$icon_path = get_option('siteurl') . '/wp-content/plugins/' . basename(dirname(__FILE__));
	add_menu_page('Bookings Engine', 'Bookings Engine', 'manage_options', 'actionPanel', 'actionPanel', $icon_path . '/icon.png');
	$calendarBookings = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','calendarBookings','calendarBookings');
	$discountCoupons = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','discountCoupons', 'discountCoupons');
	$blockOuts = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','blockOuts','blockOuts');	
	$services = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','services','services');
	$clients = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','clients','clients');
	$bookingForm = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','bookingForm','bookingForm');
	$emailTemplates = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','emailTemplates','emailTemplates');
	$ReportBug = add_submenu_page('Bookings Engine', 'Bookings Engine','','manage_options','ReportBug','ReportBug');
}
function css_calls() 
{
   	wp_enqueue_style('farbtastic');	
	wp_enqueue_style('menu.css', plugins_url('/css/menu.css', __FILE__));
	wp_enqueue_style('datatables.css', plugins_url('/css/datatables.css', __FILE__));
	wp_enqueue_style('forms.css', plugins_url('/css/forms.css', __FILE__));
	wp_enqueue_style('forms-btn.css', plugins_url('/css/forms-btn.css', __FILE__));
	wp_enqueue_style('fullcalendar.css', plugins_url('/css/plugins.css', __FILE__));	
	wp_enqueue_style('statics.css', plugins_url('/css/statics.css', __FILE__));
	wp_enqueue_style('style.css', plugins_url('/css/style.css', __FILE__));
	wp_enqueue_style('bootstrap.css', plugins_url('/css/bootstrap.css', __FILE__));
	wp_enqueue_style('system-message.css', plugins_url('/css/system-message.css', __FILE__));
	wp_enqueue_style('mdp.css', plugins_url('/css/mdp.css', __FILE__));
	
}
function js_calls()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('farbtastic');	
	wp_enqueue_script('jquery.ui.datepicker.js', plugins_url('/js/jquery.ui.datepicker.js',__FILE__));
	wp_enqueue_script('jquery-ui.multidatespicker.js', plugins_url('/js/jquery-ui.multidatespicker.js',__FILE__));
	wp_enqueue_script('bootstrap.min.js', plugins_url('/js/bootstrap.min.js',__FILE__));
	wp_enqueue_script('bootstrap-bootbox.min.js', plugins_url('/js/bootstrap-bootbox.min.js',__FILE__));
	wp_enqueue_script('jquery.validate.min.js', plugins_url('/js/jquery.validate.min.js',__FILE__));
	wp_enqueue_script('jquery.datatables.js', plugins_url('/js/jquery.datatables.js',__FILE__));
	wp_enqueue_script('jquery.fullcalendar.min.js', plugins_url('/js/jquery.fullcalendar.min.js',__FILE__));

}
function AjaxExecuteCalls()
{
	global $wpdb;
	include_once 'functions.php'; 
}
function actionPanel()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'dashboard.php';

}
function calendarBookings()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'calendarBookings.php';
}

function services()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'services.php';
}
function clients()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'clients.php';
}
function ReportBug()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'ReportBug.php';
}
function bookingForm()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'bookingForm.php';
}
function emailTemplates()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'emailTemplates.php';
}
function discountCoupons()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'discountCoupons.php';
}
function blockOuts()
{
	include_once 'header.php';
	include_once 'menus.php';
	include_once 'blockOuts.php';
}

function bookingEngineShortCode() 
{
	return extract_ShortCodes();
}
function bookingEngineShortCode1() 
{
	return extract_ShortCodes1();
}
function extract_ShortCodes() 
{
	?>
	<div class="modal2 fade in" role="dialog" aria-hidden="false" id="bookNewService" style="display: block;">
		<div class="modal-header">
			<h4 style="margin:15px 5px !important"><?php _e( "Book New Service", bookings_engine); ?></h4>
		</div>
		<div class="body">
			<?php include_once 'bookingCalendar.php' ?>
		</div>
	</div>
	<?php
}
function extract_ShortCodes1() 
{
	?>
	<a href="#bookNewService" data-toggle="modal">
		<img src="<?php echo plugins_url('/images/bookNow.png', __FILE__) ?>" alt="">
	</a>
	<div class="modal hide fade" role="dialog" aria-hidden="true" id="bookNewService">
		<div class="modal-header">
			<input type="button" class="close" data-dismiss="modal" aria-hidden="true" value="x"/>
			<h3><?php _e( "Book New Service", bookings_engine); ?></h3>
		</div>
		<div class="body">
			<?php include_once 'bookingCalendar.php' ?>
		</div>
	</div>
	<?php
}

function languages_loader() 
{
	if( function_exists( 'languages_loader' ) )
	{
		load_plugin_textdomain(bookings_engine, false, dirname( plugin_basename( __FILE__ ) ) .'/languages' );
	}
}

add_action('admin_menu','createMenusForBookingsEngine');
add_action('init','css_calls');
add_action('init','js_calls');
add_action('admin_init','AjaxExecuteCalls');
register_activation_hook(__FILE__,'executeCreateDatabaseCalls');
register_uninstall_hook(__FILE__,'executeDeleteDatabaseCalls');
add_shortcode('bookingEngineEmbed','bookingEngineShortCode' );
add_shortcode('bookingEnginePopUp','bookingEngineShortCode1' );
add_action('plugins_loaded','languages_loader');
?>