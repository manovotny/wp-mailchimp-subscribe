<?php
/**
 * @package WP_MailChimp_Subscribe
 */

class WP_MailChimp_Subscribe {

    /* Properties
    ---------------------------------------------------------------------------------- */

    /* Instance
    ---------------------------------------------- */

    /**
     * Instance of the class.
     *
     * @var WP_Recipe
     */
    protected static $instance = null;

    /**
     * Get accessor method for instance property.
     *
     * @return WP_Recipe Instance of the class.
     */
    public static function get_instance() {

        if ( null == self::$instance ) {

            self::$instance = new self;

        }

        return self::$instance;

    }

    /* Localization Handle
    ---------------------------------------------- */

    /**
     * Getter method for localization handle.
     *
     * @return string Localization handle.
     */
    public function get_localization_handle() {

        return str_replace( '-', '_', $this->slug );

    }

    /* Slug
    ---------------------------------------------- */

    /**
     * Slug to reference class.
     *
     * @var string
     */
    protected $slug = 'wp-mailchimp-subscribe';

    /**
     * Getter method for slug.
     *
     * @return string Class slug.
     */
    public function get_slug() {

        return $this->slug;

    }

    /* Version
    ---------------------------------------------- */

    /**
     * Version, used for cache-busting of style and script file references.
     *
     * @var string
     */
    protected $version = '1.1.2';

    /**
     * Getter method for version.
     *
     * @return string Plugin version.
     */
    public function get_version() {

        return $this->version;

    }

    /* Constructor
    ---------------------------------------------------------------------------------- */

    /**
     * Initialize class.
     */
    public function __construct() {

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    }

    /* Methods
    ---------------------------------------------------------------------------------- */

    /**
     * Enqueues scripts.
     */
    public function enqueue_scripts() {

        wp_enqueue_script( 'underscore' );

    }

}
