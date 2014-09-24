<?php

WP_MailChimp_Subscribe::get_instance();

add_action( 'widgets_init', create_function( '', 'register_widget( "WP_MailChimp_Subscribe_Widget" );' ) );