<?php 
function ecwc_enqueue(){
	wp_enqueue_script('ecwcjs', ecwc_url(' includes/js/ecwc.js '), array('jquery'), ECWC_VER, false);
}
add_action( 'admin_enqueue_scripts', 'ecwc_enqueue' );
function ecwc_loader(){
	global $ecwc_options,$default_ecwc_options;
	$colors=(isset($ecwc_options['colors'])?$ecwc_options['colors']:$default_ecwc_options['colors']);
	$script='<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#content_ifr").ready(function(){
			ecwcjs('.json_encode($ecwc_options['colors']).');
		});
	}); 
</script>';
	echo $script;
}
add_action('edit_form_after_editor','ecwc_loader');
?>