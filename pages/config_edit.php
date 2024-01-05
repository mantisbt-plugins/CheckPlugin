<?php
// authenticate
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
// Read results
$f_download_location	= gpc_get_string( 'download_location' );
$f_download_update		= gpc_get_int( 'download_update' );
$f_recipient			= gpc_get_string( 'recipient' );

// update results
plugin_config_set( 'download_location', $f_download_location );
plugin_config_set( 'download_update', $f_download_update );
plugin_config_set( 'recipient', $f_recipient );
// redirect
print_header_redirect( "manage_plugin_page.php" );