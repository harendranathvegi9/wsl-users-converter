<?php
/*!
* WSL Users Converter
*
* http://miled.github.io/wsl-users-converter/ | https://github.com/miled/wsl-users-converter
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

add_filter( 'wsl_hook_process_login_alter_user_id', 'wsl_suc_user_converter_fetch_social_plugins', 10, 3 );

/**
* User converters entry point
*/
function wsl_suc_user_converter_fetch_social_plugins( $user_id, $provider, $hybridauth_user_profile )
{
	if( $user_id )
	{
		return $user_id;
	}

	$identifier = $hybridauth_user_profile->identifier;

	$plugins_enabled = (array) get_option( 'wsl_suc_users_converter_plugins_enabled' );

	if( ! $plugins_enabled )
	{
		return $user_id;
	}

	if( ! $user_id && in_array( "sc", $plugins_enabled ) )
	{
		$user_id = wsl_suc_user_converter_fetch_social_connect( $provider, $hybridauth_user_profile->identifier );
	}

	if( ! $user_id && in_array( "thechamp", $plugins_enabled ) )
	{
		$user_id = wsl_suc_user_converter_fetch_thechamp( $provider, $hybridauth_user_profile->identifier );
	}

	if( ! $user_id && in_array( "fbauto", $plugins_enabled ) )
	{
		$user_id = wsl_suc_user_converter_fetch_fbauto( $provider, $hybridauth_user_profile->identifier );
	}

	if( ! $user_id && in_array( "loginradius", $plugins_enabled ) )
	{
		$user_id = wsl_suc_user_converter_fetch_loginradius( $provider, $hybridauth_user_profile->identifier );
	}

	if( ! $user_id && in_array( "janrain", $plugins_enabled ) )
	{
		$user_id = wsl_suc_user_converter_fetch_janrain( $provider, $hybridauth_user_profile->identifier );
	}

	return $user_id;
}

// --------------------------------------------------------------------

/**
* Social Connect
*
* SC store its users id in usermeta
*
* https://wordpress.org/plugins/social-connect/
*/
function wsl_suc_user_converter_fetch_social_connect( $provider, $identifier )
{
	if( ! class_exists( 'WP_User_Query', false ) )
	{
		return;
	}

	$user_query = new WP_User_Query(array(
		'meta_key'   => 'social_connect_' . strtolower( $provider ) . '_id',
		'meta_value' => $identifier,
	));

	$user_data = $user_query->get_results();

	if( count( $user_data ) == 1 )
	{
		return $user_data[0]->ID;
	}
}

// --------------------------------------------------------------------

/**
* Super Socializer
* 
* The champ sotre its users id in usermeta
*
* https://wordpress.org/plugins/super-socializer/
*/
function wsl_suc_user_converter_fetch_thechamp( $provider, $identifier )
{
	if( ! class_exists( 'WP_User_Query', false ) )
	{
		return;
	}

	$user_query = new WP_User_Query(array(
		'meta_query' => array(
			'relation' => 'AND',
			0 => array(
				'key'     => 'thechamp_social_id',
				'value'   => $identifier, 
			),
			1 => array(
				'key'     => 'thechamp_provider',
				'value'   =>  strtolower( $provider ), 
			)
		)
	));

	$user_data = $user_query->get_results();

	if( count( $user_data ) == 1 )
	{
		return $user_data[0]->ID;
	}
}

// --------------------------------------------------------------------

/**
*
*/
function wsl_suc_user_converter_fetch_fbauto( $provider, $identifier )
{
	if( 'Facebook' != $provider )
	{
		return;
	}

	if( ! class_exists( 'WP_User_Query', false ) )
	{
		return;
	}

	$user_query = new WP_User_Query(array(
		'meta_key'   => 'facebook_uid',
		'meta_value' => $identifier,
	));

	$user_data = $user_query->get_results();

	if( count( $user_data ) == 1 )
	{
		return $user_data[0]->ID;
	}
}

// --------------------------------------------------------------------

/**
*
*/
function wsl_suc_user_converter_fetch_loginradius( $provider, $identifier )
{
	if( ! class_exists( 'WP_User_Query', false ) )
	{
		return;
	}

	$user_query = new WP_User_Query(array(
		'meta_key'   => strtolower( $provider ) . 'Lrid',
		'meta_value' => $identifier,
	));

	$user_data = $user_query->get_results();

	if( count( $user_data ) == 1 )
	{
		return $user_data[0]->ID;
	}
}

// --------------------------------------------------------------------

/**
*
*/
function wsl_suc_user_converter_fetch_janrain( $provider, $identifier )
{
	if( ! class_exists( 'WP_User_Query', false ) )
	{
		return;
	}

	$user_query = new WP_User_Query(array(
		'meta_query' => array(
			'relation' => 'AND',
			0 => array(
				'key'     => 'rpx_identifier',
				'value'   => $identifier, 
			),
			1 => array(
				'key'     => 'rpx_provider',
				'value'   =>  strtolower( $provider ), 
			)
		)
	));

	$user_data = $user_query->get_results();

	if( count( $user_data ) == 1 )
	{
		return $user_data[0]->ID;
	}
}

// --------------------------------------------------------------------
