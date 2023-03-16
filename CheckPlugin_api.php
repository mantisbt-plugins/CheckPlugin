<?php
function string_between_two_strings($str, $starting_word, $ending_word) { 
	$subtring_start = strpos($str, $starting_word); 
	//Adding the starting index of the starting word to  
	//its length would give its ending index 
	$subtring_start += strlen($starting_word);   
	//Length of our required sub string 
	$size = strpos($str, $ending_word, $subtring_start) - $subtring_start;   
	// Return the substring from the index substring_start of length size  
	return substr($str, $subtring_start, $size);   
} 

function email_plugin_update( $mail, $body ) {
	$t_email = $mail;
	$t_message = $body ;
	$t_subject = "Plugin Updates";
	if( !is_blank( $t_email ) ) {
		email_store( $t_email, $t_subject, $t_message );
		if( OFF == config_get( 'email_send_using_cronjob' ) ) {
			email_send_all();
		}
	}
}