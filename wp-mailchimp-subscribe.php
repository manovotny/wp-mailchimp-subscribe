<?php
/**
 * A MailChimp subscription widget for WordPress.
 *
 * @package WP_MailChimp_Subscribe
 * @author Michael Novotny <manovotny@gmail.com>
 * @license GPL-3.0+
 * @link https://github.com/manovotny/wp-mailchimp-subscribe
 * @copyright 2014 Michael Novotny
 *
 * @wordpress-plugin
 * Plugin Name: WP MailChimp Subscribe
 * Plugin URI: https://github.com/manovotny/wp-mailchimp-subscribe
 * Description: A MailChimp subscription widget for WordPress.
 * Version: 1.0.0
 * Author: Michael Novotny
 * Author URI: http://manovotny.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * GitHub Plugin URI: https://github.com/manovotny/wp-mailchimp-subscribe
 */

/* Access
---------------------------------------------------------------------------------- */

if ( ! defined( 'WPINC' ) ) {

    die;

}

/* Libraries
---------------------------------------------------------------------------------- */

require_once __DIR__ . '/lib/wp-file-util/wp-file-util.php';
require_once __DIR__ . '/lib/wp-url-util/wp-url-util.php';

/* Classes
---------------------------------------------------------------------------------- */

if ( ! class_exists( 'WP_MailChimp_Subscribe' ) ) {

    require_once __DIR__ . '/classes/class-wp-mailchimp-subscribe.php';

    WP_MailChimp_Subscribe::get_instance();

}

/* Widgets
---------------------------------------------------------------------------------- */

if ( ! class_exists( 'WP_MailChimp_Subscribe_Widget' ) ) {

    require_once __DIR__ . '/classes/widgets/class-wp-mailchimp-subscribe-widget.php';

    add_action( 'widgets_init', create_function( '', 'register_widget( "WP_MailChimp_Subscribe_Widget" );' ) );

}