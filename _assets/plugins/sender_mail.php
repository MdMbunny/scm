<?php
/**
 * @package WP Internet
 * @author Dude
 * @version 1.0
 */

/*
Plugin Name: WP Correct "wordpress" sender mail
Plugin URI: http://somewhere.com
Description: Change the default address that WordPress sends it&rsquo;s email from.
Version: 1.0
Author: Dude
Author URI: http://somewhere.com
Last Change: 18.02.2010 20:20:12
*/

if ( !function_exists('add_action') ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

if ( !class_exists('wp_mail_from') ) {
	class wp_mail_from {

		function wp_mail_from() {
			add_filter( 'wp_mail_from', array(&$this, 'fb_mail_from') );
			add_filter( 'wp_mail_from_name', array(&$this, 'fb_mail_from_name') );
		}

		// new name
		function fb_mail_from_name() {
			//$name = 'yourname';
			$name = get_option('blogname');
			$name = esc_attr($name);
			return $name;
		}

		// new email-adress
		function fb_mail_from() {
			$email = 'yourname@host.com';
			$email = is_email($email);
			return $email;
		}

	}

	$wp_mail_from = new wp_mail_from();
}
?>