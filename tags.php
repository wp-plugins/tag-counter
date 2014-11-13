<?php
/*
Plugin Name: Tag counter
Description: Writes in the slidebar the numbers of tags
Author: Tomek
Author URI: http://wp-learning.net
Plugin URI: http://wp-learning.net
Version: 0.2
*/


add_action( 'widgets_init', 'tags_count' );
load_plugin_textdomain( 'tags', '', dirname( plugin_basename( __FILE__ ) ) . '/lang' );

function tags_count() {
	register_widget( 'WP_Widget_Tags_Count' );
}

class WP_Widget_Tags_Count extends WP_Widget {
	function WP_Widget_Tags_Count() {
		$widget_ops = array( 'classname' => 'widget_featured_entries', 'description' => __('Writes in the slidebar the numbers of tags', 'tags') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'tags-count-widget' );
		$this->WP_Widget( 'tags-count-widget', __('Tag counter', 'tags'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
            echo "<center>" .  __('Numbers of tags:', 'tags') . "<br><br><font size='6'><b>" . wp_count_terms('post_tag') . "</b></font></center>";
			echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('Tag counter', 'tags'));
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}

?>