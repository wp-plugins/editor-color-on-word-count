<?php /*
Plugin Name: Editor Color On Word Count
Plugin URI: http://wpoptimus.com/editor-color-on-word-count
Description: This plugin will change the Post/Page editor color based on Word Count
Version: 1.0
Author: wpoptimus
Author URI: http://wpoptimus.com/
Wordpress version supported: 3.5 and above
*/
/*  Copyright 2010-2014  wpoptimus  (email : tedeshpa@gmail.com)
*/
//defined global variables and constants here

global $ecwc_options,$default_ecwc_options;
$ecwc_options = get_option('ecwc_options');
$default_ecwc_options = array('colors'=>array( 
											array(
												'bg'=>'inherit',
												'count'=>'0'
											),
											array(
												'bg'=>'#ffe1dd',
												'count'=>'150'
											),
											array(
												'bg'=>'#fffac4',
												'count'=>'300'
											),
											array(
												'bg'=>'#def1dc',
												'count'=>'450'
											),
											array(
												'bg'=>'#ddf1ff',
												'count'=>'600'
											),
									)
			            );
define('ECWC_VER','1.0',false);//Current Version of Editor Color on Word Count Plugin
if ( ! defined( 'ECWC_PLUGIN_BASENAME' ) )
	define( 'ECWC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
// Create Text Domain For Translations
load_plugin_textdomain('ecwc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

function install_ecwc_plugin() {
	global $ecwc_options,$default_ecwc_options;
		$ecwc_options_curr=$ecwc_options;
	   				 
		if(!$ecwc_options_curr) {
		 $ecwc_options_curr = array();
		}
		foreach($default_ecwc_options as $key=>$value) {
			if(!isset($ecwc_options_curr[$key])) {
				$ecwc_options_curr[$key] = $value;
			}
			else{
				if(is_array($ecwc_options_curr[$key])){
					foreach($ecwc_options_curr[$key] as $key1=>$value1){
						if(!isset($ecwc_options_curr[$key][$key1])) {
							$ecwc_options_curr[$key][$key1]=$value1;
						}
					}
				}
			}
		}
	   delete_option('ecwc_options');	  
	   update_option('ecwc_options',$ecwc_options_curr);
}
register_activation_hook( __FILE__, 'install_ecwc_plugin' );

function ecwc_url( $path = '' ) {
	return plugins_url( $path, __FILE__ );
}

require_once (dirname (__FILE__) . '/settings/index.php');
require_once (dirname (__FILE__) . '/core/index.php');
require_once (dirname (__FILE__) . '/includes/index.php');
?>
