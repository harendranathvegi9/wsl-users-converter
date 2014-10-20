<?php
/*
Plugin Name: WSL Users Converter
Plugin URI: http://miled.github.io/wsl-users-converter/
Description: Make WordPress Social Login compatible with a selection of WordPress social plugins like Social Connect, Super socializer and LoginRadius. 
Version: 1.0
Author: Miled
Author URI: https://github.com/miled
License: MIT License
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

function wsl_suc_activate()
{
	if ( ! function_exists ('register_post_status') )
	{
		deactivate_plugins( basename( dirname (__FILE__) ) . '/' . basename ( __FILE__ ) );

		wp_die( __( "This plugin requires WordPress 3.0 or newer. Please update your WordPress installation to activate this plugin.", 'wsl-suc') );
	}

	if ( ! function_exists ('wsl_get_version') || version_compare( wsl_get_version(), "2.2.3", "<" ) )
	{
		deactivate_plugins( basename( dirname (__FILE__) ) . '/' . basename ( __FILE__ ) );

		wp_die( __( 'This plugin requires <a href="http://wordpress.org/plugins/wsl-suc/">WordPress Social Login</a> 2.2.3 or newer. Please install or update WordPress Social Login installation to activate this plugin.', 'wsl-suc') );
	}
}

register_activation_hook( __FILE__, 'wsl_suc_activate' );

// --------------------------------------------------------------------

if( is_admin() )
{
	require_once( dirname(__FILE__) . '/includes/bouncer-add-section.php' );
}
else
{
	require_once( dirname(__FILE__) . '/includes/authentication-fetch-social-plugins.php' );
}

// --------------------------------------------------------------------
