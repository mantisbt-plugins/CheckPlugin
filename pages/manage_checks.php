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

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( lang_get( 'manage_plugin_link' ) );

layout_page_begin( 'manage_overview_page.php' );

print_manage_menu( 'manage_checks.php' );

$pluginpath = config_get( 'plugin_path' ) ;
require_once( $pluginpath.'CheckPlugin'. DIRECTORY_SEPARATOR . 'CheckPlugin_api.php' );  

$t_plugins = plugin_find_all();
uasort( $t_plugins,
	function ( $p_p1, $p_p2 ) {
		return strcasecmp( $p_p1->name, $p_p2->name );
	}
);

if( 0 < count( $t_plugins) ) {
	?>
	<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>
	<div class="form-container">
	<div class="widget-box widget-color-blue2">
	<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
	<i class="ace-icon fa fa-cubes"></i>
	<?php echo lang_get('plugins_available') ?>
	</h4>
	</div>
	<div class="widget-body">
	<div class="widget-main no-padding">
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed table-hover">
	<colgroup>
		<col style="width:20%" />
		<col style="width:30%" />
		<col style="width:10%" />
		<col style="width:40%" />
	</colgroup>
	<thead>
	<!-- Info -->
	<tr>
	<th><?php echo lang_get( 'plugin' ) ?></th>
	<th><?php echo lang_get( 'plugin_desc' ) ?></th>
	<th><?php echo lang_get( 'plugin_status' ) ?></th>
	<th><?php echo lang_get( 'plugin_updates' ) ?></th>
	</tr>
	</thead>
	<tbody>
<?php
	foreach( $t_plugins as $t_basename => $t_plugin ) {
		if( plugin_is_registered( $t_basename ) ) { 
			$t_status = "Installed";
		} else {
			$t_status = "Available";
		}
	$t_description = string_display_line_links( $t_plugin->description );
	$t_author = $t_plugin->author;
	$t_contact = $t_plugin->contact;
	$t_page = $t_plugin->page;
	$t_url = $t_plugin->url;
	$t_name = string_display_line( $t_basename.' '.$t_plugin->version );

	if( !is_blank( $t_author ) ) {
		if( is_array( $t_author ) ) {
			$t_author = implode( $t_author, ', ' );
		}
		if( !is_blank( $t_contact ) ) {
			$t_author = '<br />' . sprintf( lang_get( 'plugin_author' ),
				'<a href="mailto:' . string_attribute( $t_contact ) . '">' . string_display_line( $t_author ) . '</a>' );
		} else {
			$t_author = '<br />' . string_display_line( sprintf( lang_get( 'plugin_author' ), $t_author ) );
		}
	}

	if( !is_blank( $t_url ) ) {
		$t_url = '<br />' . lang_get( 'plugin_url' ) . lang_get( 'word_separator' ) . '<a href="' . $t_url . '">' . $t_url . '</a>';
	}
	
	// Read the current version.txt
	$t_updatetxt="";

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
				$t_updatetxt = lang_get('new_version').$newversion.lang_get('download')."<a href=$loc target='_blank'>$loc</a>";
			} else {
				$t_updatetxt = lang_get('no_update');
			}
		} else {
			$t_updatetxt = lang_get('no_remote_file').$dev;
		}
	} else {
		$t_updatetxt = lang_get('no_local_file').$cur_version;
	}

	echo '<tr>';
	echo '<td class="small center">',$t_name,'<input type="hidden" name="change_',$t_basename,'" value="1"/></td>';
	echo '<td class="small">',$t_description,$t_author,$t_url,'</td>';
	echo '<td class="small">',$t_status,'</td>';
	echo '<td class="small">',$t_updatetxt,'</td>';
	echo '<td class="center">';
	echo '</td></tr>';
	}
}

?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
<?php
layout_page_end();
 