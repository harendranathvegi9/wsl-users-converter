<?php
/*!
* WSL Users Converter
*
* http://miled.github.io/wsl-users-converter/ | https://github.com/miled/wsl-users-converter
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

function wsl_suc_register_component()
{
	wsl_register_component(
		'wsl_suc-component',
		__('WSL Users Converter', 'wsl_suc'),
		__( 'Make WSL compatible with a selection of WordPress social plugins like Social Connect, Super socializer and LoginRadius.', 'wsl-suc' ),
		'1.0',
		'Miled',
		'https://github.com/miled',
		'http://miled.github.io/wsl-users-converter/'
	);

	register_setting( 'wsl-settings-group-bouncer', 'wsl_suc_users_converter_plugins_enabled' );
}

add_action( 'wsl_register_components', 'wsl_suc_register_component' );

// --------------------------------------------------------------------

function wsl_suc_alter_bouncer_sections( $sections )
{
	array_splice( $sections, 1, 0, array( 'wsl_suc_component_bouncer_setup_users_converter' ) );

	return $sections;
}

add_action( 'wsl_component_bouncer_setup_alter_sections', 'wsl_suc_alter_bouncer_sections', 10, 1 );

// --------------------------------------------------------------------	

function wsl_suc_component_bouncer_setup_users_converter()
{
?>
<div class="stuffbox">
	<h3>
		<label><?php _e("Users Converter", 'wsl-suc') ?></label>
	</h3>
	<div class="inside"> 
		<p> 
			<?php _e("Here you can tell Bouncer if you were or still using another plugin for social authentication. When enabled, Bouncer will take a peek at the selected plugins identification registers to check for the users IDs before he decide to create new users accounts for them or not", 'wsl-suc') ?>.
		</p> 
		<p> 
			<b><?php _e("Notes", 'wsl-suc') ?>:</b>
		</p> 
		<p class="description">
			      1. <?php _e("Each social plugin have his own way of storing their users identifications, and Bouncer may not able to recognize every user", 'wsl-suc') ?>.
			<br />2. <?php _e("Bouncer will access the other plugins identification registers in mode READ-ONLY and it won't change a thing", 'wsl-suc') ?>.
			<br />3. <?php _e("Try to keep this list relevant. With each enabled plugin in the bow below, Bouncer will make an extra effort to query the database", 'wsl-suc') ?>.
		</p>
		<table width="100%" border="0" cellpadding="5" cellspacing="2" style="border-top:1px solid #ccc;">  
		  <tr>
			<td width="200" valign="top" align="right"><p><strong><?php _e("Used social plugins", 'wsl-suc') ?> :</strong></p></td>
			<td> 
				<?php
					$wsl_suc_users_converter_plugins_enabled = (array) get_option( 'wsl_suc_users_converter_plugins_enabled' );
				?>
				<select style="width:100%;height:105px;" name="wsl_suc_users_converter_plugins_enabled[]" multiple>
					<option value="sc"          <?php if( in_array( "sc"         , $wsl_suc_users_converter_plugins_enabled ) ) echo 'selected=""'; ?>>Social Connect</option>
					<option value="thechamp"    <?php if( in_array( "thechamp"   , $wsl_suc_users_converter_plugins_enabled ) ) echo 'selected=""'; ?>>Super socializer</option>
					<option value="fbauto"      <?php if( in_array( "fbauto"     , $wsl_suc_users_converter_plugins_enabled ) ) echo 'selected=""'; ?>>WP-FB-AutoConnect</option>

					<option value="loginradius" <?php if( in_array( "loginradius", $wsl_suc_users_converter_plugins_enabled ) ) echo 'selected=""'; ?>>Social Login by LoginRadius</option>
					<option value="janrain"     <?php if( in_array( "janrain"    , $wsl_suc_users_converter_plugins_enabled ) ) echo 'selected=""'; ?>>Social Login by Janrain</option>
				</select> 
				<small><?php _e("Tip", 'wsl-suc') ?>: <?php _e("Use Command (Mac) / Control (Win) + Left Click to select or unselect multiple fields", 'wsl-suc') ?>.</small>
			</td>
		  </tr>
		</table>
	</div>
</div>
<?php
}

// --------------------------------------------------------------------	
