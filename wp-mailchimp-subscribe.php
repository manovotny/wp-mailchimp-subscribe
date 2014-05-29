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
 * Version: 0.0.0
 * Author: Michael Novotny
 * Author URI: http://manovotny.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * GitHub Plugin URI: https://github.com/manovotny/wp-mailchimp-subscribe
 */

/* Libraries
---------------------------------------------------------------------------------- */

require_once __DIR__ . '/lib/wp-file-util/wp-file-util.php';

/* Widget
---------------------------------------------------------------------------------- */

add_action( 'widgets_init', create_function( '', 'register_widget("WP_MailChimp_Subscribe");' ) );

class WP_MailChimp_Subscribe extends WP_Widget {

    protected $slug = 'wp-mailchimp-subscribe';
    
    public function __construct() {

        parent::__construct(
            $this->slug,
            __( 'MailChimp Subscription', $this->slug ),
            array(
                'classname'  => $this->slug.'-class',
                'description' => __( 'A MailChimp subscription widget for WordPress.', $this->slug )
            )
        );

        add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

    }

    public function widget( $args, $instance ) {

        $cache = wp_cache_get( $this->slug, 'widget' );

        if ( !is_array( $cache ) ) {

            $cache = array();

        }

        if ( ! isset ( $args[ 'widget_id' ] ) ) {

            $args[ 'widget_id' ] = $this->id;

        }

        if ( isset ( $cache[ $args[ 'widget_id' ] ] ) ) {

            return print $cache[ $args[ 'widget_id' ] ];

        }







        $file_util = WP_File_Util::get_instance();
        $view_path = $file_util->get_absolute_path( __DIR__, 'views/subscribe.php' );

        $title = $this->get_widget_title( $args, $instance );
        $url = stripslashes( strip_tags( $instance[ 'url' ] ) );

        extract( $args, EXTR_SKIP );

        $widget_string = $before_widget;
        $widget_string .= $title;

        ob_start();

        include $view_path;

        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;






        $cache[ $args[ 'widget_id' ] ] = $widget_string;

        wp_cache_set( $this->slug, $cache, 'widget' );

        print $widget_string;

    }


    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance[ 'title' ] = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
        $instance[ 'url' ] = strip_tags( stripslashes( $new_instance[ 'url' ] ) );

        return $instance;

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array)$instance,
            array(
                'title' => '',
                'url'   => ''
            )
        );

        $title = stripslashes( strip_tags( $instance[ 'title' ] ) );
        $url = stripslashes( strip_tags( $instance[ 'url' ] ) );

        $file_util = WP_File_Util::get_instance();
        $view_path = $file_util->get_absolute_path( __DIR__, 'admin/views/subscribe.php' );

        include $view_path;

    } // end form

    public function register_admin_styles() {

        $file_util = WP_File_Util::get_instance();
        $url_util = WP_Url_Util::get_instance();

        $path = $file_util->get_absolute_path( __DIR__, 'admin/css/subscribe.min.css' );
        $url = $url_util->convert_path_to_url( $path );

        wp_enqueue_style( $this->slug . '-admin-styles', $url, null, 'TODO' );

    }

    public function register_styles() {

        $file_util = WP_File_Util::get_instance();
        $url_util = WP_Url_Util::get_instance();

        $path = $file_util->get_absolute_path( __DIR__, 'css/subscribe.min.css' );
        $url = $url_util->convert_path_to_url( $path );

        wp_enqueue_style( $this->slug . '-styles', $url, null, 'TODO' );

    }

    public function register_scripts() {

        $file_util = WP_File_Util::get_instance();
        $url_util = WP_Url_Util::get_instance();

        $path = $file_util->get_absolute_path( __DIR__, 'js/subscribe.min.js' );
        $url = $url_util->convert_path_to_url( $path );

        wp_enqueue_script( $this->slug . '-script', $url, array('jquery'), 'TODO', true );

    }

    private function get_widget_title( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance[ 'title' ] );

        if ( ! empty( $title ) ) {

            return $args[ 'before_title' ] . $title . $args[ 'after_title' ];

        }

        return '';

    }

}