<?php
require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'authentication_api.php' );
require_api( 'config_api.php' );
require_api( 'form_api.php' );
require_api( 'helper_api.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'plugin_api.php' );
require_api( 'print_api.php' );
require_api( 'string_api.php' );
require_api( 'utility_api.php' );
require_api( 'email_api.php' );

//auth_reauthenticate();
//access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

error_reporting(-1);
ini_set('display_errors', true);

$pluginpath = config_get( 'plugin_path' ) ;
require_once( $pluginpath.'CheckPlugin'. DIRECTORY_SEPARATOR . 'CheckPlugin_api.php' );  

$t_plugins = plugin_find_all();
uasort( $t_plugins,
	function ( $p_p1, $p_p2 ) {
		return strcasecmp( $p_p1->name, $p_p2->name );
	}
);

if( 0 < count( $t_plugins) ) {
$content = '';
	foreach( $t_plugins as $t_basename => $t_plugin ) {
		if( plugin_is_registered( $t_basename ) ) { 
			$t_status = "Installed";
		} else {
			$t_status = "Available";
		}
		$t_description = string_display_line_links( $t_plugin->description );
		$t_name = string_display_line( $t_basename.' '.$t_plugin->version );

		// Read the current version.txt
		$plugin=$t_plugin->name;
		$cur_version = $pluginpath.$t_basename. DIRECTORY_SEPARATOR . 'version.txt' ;  

		if (file_exists($cur_version)) {

			$data = file_get_contents($cur_version);
			$version	= trim(string_between_two_strings($data, 'Version:', '#')); 
			$dev		= trim(string_between_two_strings($data, 'Devurl:', '#')); 

			// check version.txt from developer
			$handle = @fopen($dev, 'r');
			if($handle){
				$data = file_get_contents($dev);
				$newversion	= trim(string_between_two_strings($data, 'Version:', '#')); 
				$loc		= trim(string_between_two_strings($data, 'Location:', '#')); 

				// Compare versions
				if ( $version < $newversion ){
					$content .= $t_name.' '.$t_description.' '.$t_status.' ';
					$content .= lang_get('new_version').$newversion.lang_get('download')."$loc";
					$content .= "<br>";
					// now let's try to download
					$go_dl = plugin_config_get( 'download_update' );
					if ( $go_dl== ON ) {
						// $loc holds the the file to be downloaded
						// download location is stored in plugin variable
						$dl_loc = plugin_config_get( 'download_location' );
						// now we need to add the filename to the $dl_loc variable
						// let's find the last "/" and return the remainder of the string to be added to the download location
						$pos = strrpos($loc, "/");
						$len = strlen($loc);
						$pos++;
						$filename = substr($loc, $pos);
						// Do I need a check on the last position of $dl_loc being a "/"?
						// if so, need to have acheck built in here
						// for now, no check
						$dl_loc .= $filename;
						// now ready to actually download
					//	$countbytes = file_put_contents($dl_loc, fopen($loc, 'r'));
$countbytes = file_put_contents("/tmp/mytest.zip", fopen($loc, 'r'));
echo $countbytes;
echo '<br>';
$data = file_get_contents("/tmp/mytest.zip");
echo $data;
echo '<br>';


					}
				}
			} 
		}
	}
}

if ( !$content == '' ) {
	$mailto = config_get( 'plugin_CheckPlugin_recipient' );
	// send the email
	$result = email_plugin_update( $mailto, $content );
}
?>