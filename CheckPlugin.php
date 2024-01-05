<?php
class CheckPluginPlugin extends MantisPlugin {

	function register() {
		$this->name        	= lang_get( 'plugin_name' );
		$this->description 	= lang_get( 'plugin_desc' );
		$this->version     	= '1.04';
		$this->requires    	= array('MantisCore'       => '2.0.0',);
		$this->author      	= 'Cas Nuy';
		$this->contact     	= 'Cas-at-nuy.info';
		$this->url		= 'https://github.com/mantisbt-plugins/CheckPlugin';
		$this->page		= 'config';
	}

 	function config() {
		return array(
			'recipient'		=> 'admin@mantis.com',
			'download_update'	=> ON,
			'download_location'	=> '/tmp/' ,
			);
	}

	function init() {
		plugin_event_hook( 'EVENT_MENU_MANAGE',	'check_menu' );
	}

 	function check_menu() {
		return array( '<a href="' . plugin_page( 'manage_checks' ) . '">' . lang_get( 'plugin_manage' ) .  '</a>', );
	}
}
