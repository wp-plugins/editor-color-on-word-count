<?php
// function for adding settings page to wp-admin
function ecwc_settings() {
    // Add a new submenu under Options:
    add_options_page('Editor Colors on Word Count', 'Editor Colors', 9, 'ecwc_settings', 'ecwc_settings_page');
}
// Hook for adding admin menus
if ( is_admin() ){ // admin actions
	add_action('admin_menu', 'ecwc_settings');
	add_action('admin_init', 'register_ecwc_settings' ); 
} 
function ecwc_settings_page(){ 
	global $ecwc_options;
?>
	<h2>Editor Colors on Word Count</h2>
	<form  method="post" action="options.php" id="ecwc_form">
<?php settings_fields('ecwc-group');?>
	<table class="form-table" id="ecwc_color_table" style="width:400px;max-width:100%;">
		<tbody id="ecwc_tbody">
		<tr>
			<th>Upto Word Count</th>
			<th>Background Color</th> 
		</tr>
		<?php $i=0;foreach($ecwc_options['colors'] as $color) { ?>
				<tr id="cn<?php echo $i;?>" class="cntr" style="border-bottom:1px solid #dedede;">
					<td><input type="text" name="ecwc_options[colors][<?php echo $i;?>][count]" value="<?php echo $color['count'];?>" class="small-text cnt" /></td>
					<td><input type="text" style="width:6em;" name="ecwc_options[colors][<?php echo $i;?>][bg]" id="color_value_<?php echo $i;?>" value="<?php echo $color['bg'];?>" />&nbsp; <img id="color_picker_<?php echo $i;?>" src="<?php echo ecwc_url( 'includes/images/color_picker.png' ); ?>" alt="<?php _e('Pick the color of your choice','ecwc'); ?>" /><div class="color-picker-wrap" id="colorbox_<?php echo $i;?>"></div><input type="button" id="n<?php echo $i;?>" class="deleteRow" onclick="ecwc_delete_color_js(this.id);" /></td>
				</tr>
		<?php $i++;} ?>
		</tbody>
	</table>
	<div style="width:400px;max-width:100%;text-align:center;">
		<p><input type="button" class="button" name="add_color" onclick="ecwc_add_color();" value="<?php _e('Add Color','ecwc') ?>" /></p>
		<p><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</div>
	</form>
	
<?php
}
function register_ecwc_settings() { // whitelist options
  register_setting( 'ecwc-group', 'ecwc_options' );
}

function ecwc_admin_scripts() {
	if ( is_admin() ){ // load on Editor Color on Word Count Settings Page only
		if ( isset($_GET['page']) && ('ecwc_settings' == $_GET['page']) ) {
			wp_deregister_script( 'farbtastic' );
			wp_enqueue_script( 'farbtastic', ecwc_url( 'includes/js/farbtastic.js' ),array('jquery'), ECWC_VER, false);
		}
	}
}
add_action( 'admin_init', 'ecwc_admin_scripts' );

function ecwc_admin_head() {
	if ( is_admin() ){ // load on Editor Color on Word Count Settings Page only
		if ( isset($_GET['page']) && ('ecwc_settings' == $_GET['page']) ) {
			global $ecwc_options;
			wp_print_styles( 'farbtastic' );
			?>
			<style type="text/css">.color-picker-wrap {position: absolute;	display: none; background: #fff;border: 3px solid #ccc;	padding: 3px;z-index: 1000;}.deleteRow{margin-left:2em;background-color: transparent !important;background: url(<?php echo ecwc_url('includes/images/del.png');?>) no-repeat top left;border: 0px !important;min-width: 20px;vertical-align: middle;cursor: pointer;}#ecwc_form .error{border: 1px solid #D8000C !important; padding: 5px 0}</style>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					<?php $i=0;foreach($ecwc_options['colors'] as $color){ ?>
						jQuery('#colorbox_<?php echo $i;?>').farbtastic('#color_value_<?php echo $i;?>');
						jQuery('#color_picker_<?php echo $i;?>').click(function () {
						   if (jQuery('#colorbox_<?php echo $i;?>').css('display') == "block") {
							  jQuery('#colorbox_<?php echo $i;?>').fadeOut("slow"); }
						   else {
							  jQuery('#colorbox_<?php echo $i;?>').fadeIn("slow"); }
						});
						var colorpick_<?php echo $i;?> = false;
						jQuery(document).mousedown(function(){
							if (colorpick_<?php echo $i;?> == true) {
								return; }
								jQuery('#colorbox_<?php echo $i;?>').fadeOut("slow");
						});
						jQuery(document).mouseup(function(){
							colorpick_<?php echo $i;?> = false;
						});
					<?php $i++;} ?>
				});
				var ecwcCount=0;
				function ecwc_add_color(){if(ecwcCount==0)ecwcCount=<?php echo count($ecwc_options['colors']);?>;jQuery('<tr id="cn'+ecwcCount+'" class="cntr" style="border-bottom:1px solid #dedede;"><td><input type="text" name="ecwc_options[colors]['+ecwcCount+'][count]" value="" class="small-text cnt" /></td><td><input type="text" style="width:6em;" name="ecwc_options[colors]['+ecwcCount+'][bg]" id="color_value_'+ecwcCount+'" value="#FFFFFF" />&nbsp; <img id="color_picker_'+ecwcCount+'" src="<?php echo ecwc_url( 'includes/images/color_picker.png' ); ?>" alt="<?php _e('Pick the color of your choice','ecwc'); ?>" /><div class="color-picker-wrap" id="colorbox_'+ecwcCount+'"></div><input type="button" id="n'+ecwcCount+'" class="deleteRow" onclick="ecwc_delete_color_js(this.id);" /></td></tr><script type="text/javascript">jQuery("#colorbox_'+ecwcCount+'").farbtastic("#color_value_'+ecwcCount+'");jQuery("#color_picker_'+ecwcCount+'").click(function () {if (jQuery("#colorbox_'+ecwcCount+'").css("display") == "block") { jQuery("#colorbox_'+ecwcCount+'").fadeOut("slow"); } else { jQuery("#colorbox_'+ecwcCount+'").fadeIn("slow"); } });var colorpick_'+ecwcCount+' = false;jQuery(document).mousedown(function(){if (colorpick_'+ecwcCount+' == true) {return; }jQuery("#colorbox_'+ecwcCount+'").fadeOut("slow");});jQuery(document).mouseup(function(){colorpick_'+ecwcCount+' = false;});</scr'+'ipt>').appendTo("#ecwc_tbody");ecwcCount++;}
				function ecwc_delete_color_js(nid){ jQuery('#c'+nid).fadeOut('normal', function() {jQuery(this).remove();}); }
				jQuery(document).ready(function() {
					jQuery('#ecwc_form').submit(function(event) { 
							var trcount=jQuery(this).find('.cntr').length;
							for(var Count=0;Count < trcount;Count++){
								var cnt=jQuery("#cn"+Count+" .cnt").val();
								if(cnt=='' || cnt < 0 || isNaN(cnt)) {
									alert("Word Count should be a number!"); 
									jQuery("#cn"+Count).addClass('error');
									jQuery("html,body").animate({scrollTop:jQuery("#cn"+Count).offset().top-50}, 600);
									return false;
								}	
							}
					});
				});
			</script>
			<?php
		}
	}
}
add_action('admin_head', 'ecwc_admin_head');
?>