<?php
/*
Plugin Name: YouTube Subscriber
Plugin URI:
Description: Create widget with form or button to subscribe to YouTube channel
Version: 2.0
Author: Web4pro
Author URI: http://www.web4pro.net/
*/

add_action( 'widgets_init', create_function( '', 'register_widget( "YouTube_Subscriber" );' ) ); //Widget registration

include_once( 'shortcodes.php' ); //include shortcodes

//Start widget class
class YouTube_Subscriber extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'YouTube_Subscriber', //Widget identify
			__( 'YouTube Subscriber' ), //Widget name
			array( 'description' => __( 'Create form subscribing to YouTube channel' ) )
		);
	}

	public function form( $instance ) {
		$title         = isset( $instance['title'] ) ? $instance['title'] : __( 'My channel' ); //Title of the widget
		$user_text     = isset( $instance['user_text'] ) ? $instance['user_text'] : ''; //"Subscribe to my channel" text
		$user_nickname = isset( $instance['user_nickname'] ) ? strtolower( $instance['user_nickname'] ) : ''; //Nickname of the YouTube channel owner
		$channelname       = isset( $instance['channelname'] ) ? $instance['channelname'] : ''; //Channel name.
		$channelID       = isset( $instance['channelID'] ) ? $instance['channelID'] : ''; //Channel ID.
		$layout        = isset( $instance['layout'] ) ? $instance['layout'] : 'default';
		$subscribers   = isset( $instance['subscribers'] ) ? $instance['subscribers'] : 'default';

		//Start the widget settings form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'user_text' ); ?>"><?php _e( '"Subscribe to my channel" text' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'user_text' ); ?>"
			       name="<?php echo $this->get_field_name( 'user_text' ); ?>"
			       value="<?php echo esc_attr( $user_text ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'user_nickname' ); ?>"><?php _e( 'Your YouTube nickname' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'user_nickname' ); ?>"
			       name="<?php echo $this->get_field_name( 'user_nickname' ); ?>"
			       value="<?php echo esc_attr( $user_nickname ); ?>">
		</p>
		<p><?php _e( 'OR' ); ?></p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'channelname' ); ?>"><?php _e( 'Enter your channel name' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'channelname' ); ?>"
			       name="<?php echo $this->get_field_name( 'channelname' ); ?>"
			       value="<?php echo esc_attr( $channelname ); ?>">
		</p>
		<p><?php _e( 'OR' ); ?></p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'channelID' ); ?>"><?php _e( 'Enter your channel ID' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'channelID' ); ?>"
			       name="<?php echo $this->get_field_name( 'channelID' ); ?>"
			       value="<?php echo esc_attr( $channelID ); ?>">
		</p>
		<table>
			<tr>
				<td class="first">
					<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Layout' ); ?></label>
				</td>
				<td class="second">
					<select class="widefat" type="text"
					        id="<?php echo $this->get_field_id( 'layout' ); ?>"
					        name="<?php echo $this->get_field_name( 'layout' ); ?>">
						<option
							value="<?php _e( 'default' ); ?>" <?php selected( $layout, 'default' ); ?>><?php _e( 'default' ); ?></option>
						<option
							value="<?php _e( 'full' ); ?>" <?php  selected( $layout, 'full' ); ?>><?php _e( 'full' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="first">
					<label
						for="<?php echo $this->get_field_id( 'subscribers' ); ?>"><?php _e( 'Number of subscribers' ); ?></label>
				</td>
				<td class="second">
					<select class="widefat" type="text"
					        id="<?php echo $this->get_field_id( 'subscribers' ); ?>"
					        name="<?php echo $this->get_field_name( 'subscribers' ); ?>">
						<option
							value="<?php _e( 'default' ); ?>" <?php selected( $subscribers, 'default' ); ?>><?php _e( 'default (show)' ); ?></option>
						<option
							value="<?php _e( 'hidden' ); ?>" <?php echo selected( $subscribers, 'hidden'); ?>><?php _e( 'hide' ); ?></option>
					</select>
				</td>
			</tr>
		</table>
	<?php
	}

	public function update( $new_instance, $old_instance ) //Save widget settings
	{
		$instance                  = $old_instance;
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['user_nickname'] = ( ! empty( $new_instance['user_nickname'] ) ) ? strip_tags( $new_instance['user_nickname'] ) : '';
		$instance['user_text']     = ( ! empty( $new_instance['user_text'] ) ) ? strip_tags( $new_instance['user_text'] ) : '';
		$instance['channelname']       = ( ! empty( $new_instance['channelname'] ) ) ? $new_instance['channelname'] : '';
		$instance['channelID']       = ( ! empty( $new_instance['channelID'] ) ) ? $new_instance['channelID'] : '';
		$instance['layout']        = ( ! empty( $new_instance['layout'] ) ) ? $new_instance['layout'] : 'default';
		$instance['subscribers']   = ( ! empty( $new_instance['subscribers'] ) ) ? $new_instance['subscribers'] : 'default';

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args ); //Theme arguments for widgets

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget; //Before widget tags
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; //Output title with the before-after tags
		}
		if ( ! empty( $instance['user_text'] ) && $instance['title'] != '' ) { //If user enter "Subscribe to my channel" text - output it
			echo '<div class="user_title"><p>' . $instance['user_text'] . '</p></div>';
		}
		if ( ! empty( $instance['user_nickname'] ) ) {
			//Out YouTube subscribing form
			?>
			<iframe id="fr"
			        height="78"
			        style="overflow: hidden; height: 100px; width: 200px; border: 0pt none;"
			        src="http://www.youtube.com/subscribe_widget?p=<?php echo $instance['user_nickname']; ?>"
			        scrolling="no"
			        frameborder="0"></iframe>
		<?php
		} elseif ( ! empty( $instance['channelname'] ) ) {
			//Out YouTube subscribing button
			?>
			<script src="https://apis.google.com/js/platform.js"></script>
			<div class="g-ytsubscribe"
			     data-channel="<?php echo $ch = $instance['channelname'] ?>"
			     data-layout="<?php echo $lay = $instance['layout'] ?>"
			     data-count="<?php echo $sub = $instance['subscribers'] ?>"></div>
		<?php
		}
		elseif ( ! empty( $instance['channelID'] ) ) {
			//Out YouTube subscribing button
			?>
			<script src="https://apis.google.com/js/platform.js"></script>
			<div class="g-ytsubscribe"
			     data-channelid="<?php echo $ch = $instance['channelID'] ?>"
			     data-layout="<?php echo $lay = $instance['layout'] ?>"
			     data-count="<?php echo $sub = $instance['subscribers'] ?>"></div>
		<?php
		}
		echo $after_widget; //After widget tags
	}
}
