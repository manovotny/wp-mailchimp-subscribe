<?php
/**
 * @package WP_MailChimp_Subscribe
 */

class WP_MailChimp_Subscribe_Widget extends WP_Widget {

    /* Properties
    ---------------------------------------------------------------------------------- */

    /* File Util
    ---------------------------------------------- */

    /**
     * Instance of the WP File Util class.
     *
     * @var WP_File_Util
     */
    private $file_util;

    /* Slug
    ---------------------------------------------- */

    /**
     * Slug to reference class.
     *
     * @var string
     */
    protected $slug = 'wp-mailchimp-subscribe-widget';

    /* Url Util
    ---------------------------------------------- */

    /**
     * Instance of the WP Url Util class.
     *
     * @var WP_Url_Util
     */
    private $url_util;

    /* Version
    ---------------------------------------------- */

    /**
     * Version, used for cache-busting of style and script file references.
     *
     * @var string
     */
    private $version;

    /* Constructor
    ---------------------------------------------------------------------------------- */

    /**
     * Initializes class.
     */
    public function __construct() {

        $this->file_util = WP_File_Util::get_instance();
        $this->url_util = WP_Url_Util::get_instance();
        $this->version = WP_MailChimp_Subscribe::get_instance()->get_version();

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

        $view_path = $this->file_util->get_absolute_path( __DIR__, '../../admin/views/subscribe.php' );

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


        $view_path = $this->file_util->get_absolute_path( __DIR__, '../../views/subscribe.php' );

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

        $path = $this->file_util->get_absolute_path( __DIR__, '../../admin/css/subscribe.min.css' );
        $url = $this->url_util->convert_path_to_url( $path );

        wp_enqueue_style( $this->slug . '-admin-styles', $url, null, $this->version );

    }

    /* Widget
    ---------------------------------------------- */

    /**
     * Registers widget scripts.
     */
    public function register_widget_scripts() {

        $path = $this->file_util->get_absolute_path( __DIR__, '../../js/subscribe.min.js' );
        $url = $this->url_util->convert_path_to_url( $path );

        wp_enqueue_script( $this->slug . '-script', $url, array( 'jquery' ), $this->version, true );

    }

    /**
     * Registers widget styles.
     */
    public function register_widget_styles() {

        $path = $this->file_util->get_absolute_path( __DIR__, '../../css/subscribe.min.css' );
        $url = $this->url_util->convert_path_to_url( $path );

        wp_enqueue_style( $this->slug . '-styles', $url, null, $this->version );

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