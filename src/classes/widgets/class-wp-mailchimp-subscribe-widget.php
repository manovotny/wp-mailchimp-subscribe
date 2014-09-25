<?php
/**
 * @package WP_MailChimp_Subscribe
 */

class WP_MailChimp_Subscribe_Widget extends WP_Widget {

    /* Properties
    ---------------------------------------------------------------------------------- */

    /* Slug
    ---------------------------------------------- */

    /**
     * Slug to reference class.
     *
     * @var string
     */
    protected $slug = 'wp-mailchimp-subscribe-widget';

    /* Version
    ---------------------------------------------- */

    /**
     * Version, used for cache-busting of style and script file references.
     *
     * @var string
     */
    private $version;

    /* WP Enqueue Util
    ---------------------------------------------- */

    /**
     * Instance of the WP Enqueue Util class.
     *
     * @var WP_Enqueue_Util
     */
    private $wp_enqueue_util;

    /* Constructor
    ---------------------------------------------------------------------------------- */

    /**
     * Initializes class.
     */
    public function __construct() {

        $this->version = WP_MailChimp_Subscribe::get_instance()->get_version();
        $this->wp_enqueue_util = WP_Enqueue_Util::get_instance();

        parent::__construct(
            $this->slug,
            __( 'MailChimp Subscription', $this->slug ),
            array(
                'classname'  => $this->slug,
                'description' => __( 'A MailChimp subscription widget for WordPress.', $this->slug )
            )
        );

        add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );

    }

    /* Widget
    ---------------------------------------------------------------------------------- */

    /* Admin
    ---------------------------------------------- */

    /**
     * Admin widget display.
     *
     * @param array $instance Instance of the widget.
     * @return void Returns admin display
     */
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

        $view_path = realpath( __DIR__ . '/../../admin/views/subscribe.php' );

        include $view_path;

    }

    /**
     * Saves admin widget options.
     *
     * @param array $new_instance New instance of the widget.
     * @param array $old_instance Old instance of the widget.
     * @return array Updated instance of the widget.
     */
    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance[ 'title' ] = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
        $instance[ 'url' ] = strip_tags( stripslashes( $new_instance[ 'url' ] ) );

        return $instance;

    }

    /* Widget
    ---------------------------------------------- */

    /**
     * Frontend widget display.
     *
     * @param array $args Widget arguments.
     * @param array $instance Instance of the widget.
     * @return void Exists early if widget has been cached.
     */
    public function widget( $args, $instance ) {

        $cache = wp_cache_get( $this->slug, 'widget' );

        if ( !is_array( $cache ) ) {

            $cache = array();

        }

        if ( ! isset ( $args[ 'widget_id' ] ) ) {

            $args[ 'widget_id' ] = $this->id;

        }

        if ( isset ( $cache[ $args[ 'widget_id' ] ] ) ) {

            print $cache[ $args[ 'widget_id' ] ];

            return;

        }

        /*
         * Code above this is necessary, all the time, widget stuff,
         * and should probably be moved to a utility library.
         */

        /* ============================================================ */


        $view_path = realpath( __DIR__ . '/../../site/views/subscribe.php' );

        $title = $this->get_widget_title( $args, $instance );
        $url = stripslashes( strip_tags( $instance[ 'url' ] ) );

        extract( $args, EXTR_SKIP );

        $widget_string = $before_widget;
        $widget_string .= $title;

        ob_start();

        include $view_path;

        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;


        /* ============================================================ */

        /*
         * Code below this is necessary, all the time, widget stuff,
         * and should probably be moved to a utility library.
         */

        $cache[ $args[ 'widget_id' ] ] = $widget_string;

        wp_cache_set( $this->slug, $cache, 'widget' );

        print $widget_string;

    }

    /* Hooks
    ---------------------------------------------------------------------------------- */

    /* Admin
    ---------------------------------------------- */

    /**
     * Registers admin styles.
     */
    public function register_admin_styles() {

        $handle = $this->slug . '-admin-styles';
        $relative_path = __DIR__ . '/../../admin/css/';
        $filename = 'wp-mailchimp-subscribe.min.css';
        $filename_debug = 'wp-mailchimp-subscribe.css';
        $dependencies = array();

        $options = new WP_Enqueue_Options(
            $handle,
            $relative_path,
            $filename,
            $filename_debug,
            $dependencies,
            $this->version
        );

        $this->wp_enqueue_util->enqueue_style( $options );

    }

    /* Widget
    ---------------------------------------------- */

    /**
     * Registers widget scripts.
     */
    public function register_widget_scripts() {

        $wp_mailchimp_subscribe = WP_MailChimp_Subscribe::get_instance();

        $localization_handle = $wp_mailchimp_subscribe->get_localization_handle();
        $domain = $wp_mailchimp_subscribe->get_slug();

        $handle = $this->slug . '-script';
        $relative_path = __DIR__ . '/../../site/js/';
        $filename = 'bundle.min.js';
        $filename_debug = 'bundle.concat.js';
        $dependencies = array( 'jquery' );

        $data = array(
            'options' => array(
                'default_error_message' => __( 'Hrm... Something\'s not working right. Please try again later or let us know something is wrong.', $domain ),
                'default_success_message' => __( 'Almost finished... We need to confirm your email address. To complete the subscription process, please click the link in the email we just sent you.', $domain )
            )
        );

        $options = new WP_Enqueue_Options(
            $handle,
            $relative_path,
            $filename,
            $filename_debug,
            $dependencies,
            $this->version
        );

        $options->set_localization( $localization_handle, $data );

        $this->wp_enqueue_util->enqueue_script( $options );

    }

    /**
     * Registers widget styles.
     */
    public function register_widget_styles() {

        $handle = $this->slug . '-styles';
        $relative_path = __DIR__ . '/../../site/css/';
        $filename = 'wp-mailchimp-subscribe.min.css';
        $filename_debug = 'wp-mailchimp-subscribe.css';
        $dependencies = array();

        $options = new WP_Enqueue_Options(
            $handle,
            $relative_path,
            $filename,
            $filename_debug,
            $dependencies,
            $this->version
        );

        $this->wp_enqueue_util->enqueue_style( $options );

    }

    /* Helpers
    ---------------------------------------------------------------------------------- */

    /**
     * Determines widget title.
     *
     * @param array $args Widget arguments.
     * @param array $instance Instance of the widget.
     * @return string Widget title.
     */
    private function get_widget_title( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance[ 'title' ] );

        if ( ! empty( $title ) ) {

            return $args[ 'before_title' ] . $title . $args[ 'after_title' ];

        }

        return '';

    }

}