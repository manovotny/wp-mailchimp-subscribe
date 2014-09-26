<?php
/**
 * @package WP_MailChimp_Subscribe
 *
 * @wordpress-plugin
 * Plugin Name: WP MailChimp Subscribe
 * Plugin URI: https://github.com/manovotny/wp-mailchimp-subscribe
 * Description: A MailChimp subscription widget for WordPress.
 * Version: 1.1.1
 * Author: Michael Novotny
 * Author URI: http://manovotny.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /TRANSLATIONS_PATH
 * Text Domain: TRANSLATIONS_DOMAIN
 * GitHub Plugin URI: https://github.com/manovotny/wp-mailchimp-subscribe
 */

/* Access
---------------------------------------------------------------------------------- */

if ( ! defined( 'WPINC' ) ) {

    die;

}

/* Composer
---------------------------------------------------------------------------------- */

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {

    require_once __DIR__ . '/vendor/autoload.php';

}

/* Initialization
---------------------------------------------------------------------------------- */

require_once __DIR__ . '/src/initialize.php';