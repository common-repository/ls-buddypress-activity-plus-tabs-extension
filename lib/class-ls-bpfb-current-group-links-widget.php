<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Current displayed group links widget
 * @version 2, 6/4/2015 fix for hidden groups
 * v1, 22/4/2014, lenasterg
 */
class LS_BPFB_Current_Group_Links_Widget extends WP_Widget {

	var $format_notification_function;

	function __construct() {

		$nav_page_name = __( 'Group Links', 'bpfb' );
		$this->name    = ! empty( $nav_page_name ) ? $nav_page_name : __( 'Group Links', 'bpfb' );

		parent::__construct(
			'LS_BPFB_Current_Group_Links_Widget',
			'(LS-buddypress-activity-plus-tabs) ' . $nav_page_name, // Name
			array(
				'description' => $nav_page_name . ' ' . __( 'Use it only on a group sidebar', 'ls_bpfb' ),
				'classname'   => 'ls_bpfb_links_widget',
			)
		);
	}

	/**
	 *
	 * @param type $args
	 * @param array $instance
	 * @version 3, 26/1/2023
	 */
	function widget( $args, $instance ) {
		$bp                   = buddypress();
		$instance['group_id'] = bp_get_current_group_id();
		//$activity_links = new BP_activity_plus_links_tab_Extension();

		if ( $instance['group_id'] > 0 ) {
			$group = $bp->groups->current_group;
			// If the group  public, or the user is super_admin or the user is member of group
			if ( ( 'public' === $group->status ) || ( is_super_admin() ) || ( groups_is_user_member( bp_loggedin_user_id(), $instance['group_id'] ) ) ) {
				$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Links' ) : sanitize_text_field( $instance['title'] ) );

				echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];

				do_action( 'ls_bpfb_current_group_links_widget_before_html' );
				do_action( 'bp_before_activity_loop' );
				//if ( $activity_links->countLinks > 0 ) :
				if ( bp_has_activities( 'primary_id=' . $bp->groups->current_group->id . '&object=groups&action=activity_update&search_terms=bpfb_link&max=5' ) ) :
					?>
						<ul>
					<?php
					while ( bp_activities() ) :
						bp_the_activity();
						?>
							<?php
							if ( bp_activity_has_content() ) :
								?>
								<li>
								<?php
								bp_activity_content_body();
								?>
								<hr>
								</li>
							<?php endif; ?>
								<?php do_action( 'bp_activity_entry_content' ); ?>
								<?php
								endwhile;
					?>
						</ul>
						<?php
						echo '<div class="view-all"><a href="' . bp_get_group_permalink( $bp->groups->current_group ) . '/links' . '#object-nav">' . __( 'View all', 'ls_bpfb' ) . '</a></div>';
						//                      echo '<div class="view-all"><a href="' . bp_get_group_permalink( $bp->groups->current_group ) . $activity_links->slug . '#object-nav">' . __( 'View all', 'ls_bpfb' ) . '</a></div>';

						else :
							echo '<div class="widget-error">' . sprintf( __( 'There are no group links to display.', 'ls_bpfb' ), __( 'links' ) ) . '</div></p>';
						endif;
						?>
						<?php
						if ( bp_group_is_member() || ( is_super_admin() ) ) :
							?>
						<div class="generic-button group-button public"><a href="<?php bp_group_permalink(); ?>#whats-new-form" class="generic-button" id="ls_bpfb_add_link_wg"><?php _e( 'Add New', 'buddypress' ); ?></a></div>
							<?php
						endif;
						?>


						<?php
			}
				echo $args['after_widget'];
		}
	}

	function update( $new_instance, $old_instance ) {
		do_action( 'ls_bpfb_current_group_links_widget_update' );

		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		$instance['num_items'] = absint( $new_instance['num_items'] );

		return $instance;
	}

	function form( $instance ) {
		do_action( 'ls_bpfb_current_group_links_widget_form' );
		$instance  = wp_parse_args(
			(array) $instance,
			array(
				'num_items' => 5,
				'title'     => __(
					'Group Links',
					'bpfb'
				),
			)
		);
		$title     = esc_attr( $instance['title'] );
		$num_items = absint( $instance['num_items'] );
		?>

			<p><label><?php _e( 'Title:' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

	<p><label><?php _e( 'Number of items to show:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'num_items' ); ?>" name="<?php echo $this->get_field_name( 'num_items' ); ?>" type="text" value="<?php echo absint( $num_items ); ?>" style="width: 30%" /></p>
		<?php
	}

}
