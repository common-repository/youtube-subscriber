<?php
/**
 * The shortcode function.
 *
 * @param $atts
 */
function youtube_subscriber_shortcode( $atts ) {
	extract( shortcode_atts( array(
		"nickname"    => '',
		"channelname"     => '',
		"channelid"     => '',
		"layout"      => '',
		"subscribers" => '',
	), $atts ) );
	//Out YouTube subscribing form
	ob_start();
	if ( ! empty( $nickname ) ) : ?>
		<iframe id="fr"
		        height="78"
		        style="overflow: hidden; border: 0pt none;"
		        src="http://www.youtube.com/subscribe_widget?p=<?php echo $nickname; ?>" scrolling="no"
		        frameborder="0"></iframe>
		<?php $out = ob_get_contents();
	elseif ( ! empty( $channelname ) ) : ?>
		<script src="https://apis.google.com/js/platform.js"></script>
		<div class="g-ytsubscribe"
		     data-channel="<?php echo $channelname; ?>"
		     data-layout="<?php echo $layout; ?>"
		     data-count="<?php echo $subscribers; ?>"></div>
		<?php
		$out = ob_get_contents();
	elseif ( ! empty( $channelid ) ) : ?>
		<script src="https://apis.google.com/js/platform.js"></script>

		<div class="g-ytsubscribe"
		     data-channelid="<?php echo $channelid; ?>"
		     data-layout="<?php echo $layout; ?>"
		     data-count="<?php echo $subscribers; ?>"></div>
		<?php
		$out = ob_get_contents();
	endif;
	ob_end_clean();

	return $out;
}

add_shortcode( 'youtube-subscriber', 'youtube_subscriber_shortcode' );

/**
 * Function add row to visual editor and register button.
 */
function youtube_subscriber_button() {
	$cap = apply_filters( 'ys_youtube_button_capabilities', 'edit_posts' );
	if ( current_user_can( $cap ) ) {
		add_filter( 'mce_external_plugins', 'youtube_subscriber_plugin' );
		add_filter( 'mce_buttons', 'youtube_subscriber_register_button' );
	}
}

add_action( 'init', 'youtube_subscriber_button' );

/**
 * Function return plugin params.
 *
 * @param $plugin_array
 *
 * @return mixed
 */
function youtube_subscriber_plugin( $plugin_array ) {
	$plugin_array['youtube_subscriber'] = plugins_url( 'js/newbuttons.js', __FILE__ );

	return $plugin_array;
}

/**
 * Function register button to visual editor.
 *
 * @param $buttons
 *
 * @return mixed
 */
function youtube_subscriber_register_button( $buttons ) {
	array_push( $buttons, "youtube_subscriber" );

	return $buttons;
}
