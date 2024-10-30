<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( class_exists( 'BP_Group_Extension' ) ) : // Recommended, to prevent problems during upgrade or when Groups are disabled

	class LS_BPFB_Links_Tab_Extension extends BP_Group_Extension {
		public $count_links = 0;
		var $visibility     = 'private';
		var $format_notification_function;
		var $enable_edit_item       = false;
		var $enable_create_step     = false;
		var $admin_metabox_context  = 'side'; // The context of your admin metabox. See add_meta_box()
		var $admin_metabox_priority = 'default'; // The priority of your admin metabox. See add_meta_box()

		function __construct() {
			$bp = buddypress();
			if ( $bp->groups->current_group ) {
				if ( bp_has_activities( 'primary_id=' . $bp->groups->current_group->id . '&object=groups&action=activity_update&search_terms=bpfb_link' ) ) {
					global $activities_template;
				}
				$nav_page_name = __( 'Links' );
				$this->name    = ! empty( $nav_page_name ) ? $nav_page_name : __( 'Links', 'bpfb' );
				$this->slug    = 'links';
				/* For internal identification */
				$this->id                = 'group_links';
				$this->count_links       = ! empty( $activities_template->activity_count ) ? $activities_template->activity_count : '0';
				$this->nav_item_name     = $this->name . ' <span>' . $this->count_links . '</span>';
				$this->nav_item_position = 52;
				$this->admin_name        = ! empty( $nav_page_name ) ? $nav_page_name : __( 'Links', 'bpfb' );
				$this->admin_slug        = 'links';
			}
		}

		function display( $group_id = null ) {
			$bp = buddypress();
			?>
			<div class="info-group">
				<h4><?php echo esc_attr( $this->name ); ?></h4>
				<?php if ( bp_group_is_member() ) : ?>
					<div class="generic-button group-button public"><a href="<?php bp_group_permalink(); ?>#whats-new-form" class="generic-button" id="ls_bpfb_add_link"><?php _e( 'Add New', 'buddypress' ); ?></a></div>
				<?php endif; ?>
				<?php
				do_action( 'bp_before_activity_loop' );
				if ( $this->count_links > 0 ) :
					if ( bp_has_activities( 'primary_id=' . $bp->groups->current_group->id . '&object=groups&action=activity_update&search_terms=bpfb_link' ) ) :
						/* Show pagination if JS is not enabled, since the "Load More" link will do nothing */
						?>
						<noscript>
						<div class="pagination">
							<div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
							<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
						</div>
						</noscript>
						<?php if ( empty( $_POST['page'] ) ) : ?>
							<ul class="activity-list item-list bp-list">
								<?php
							endif;
						while ( bp_activities() ) :
							bp_the_activity();
							bp_locate_template( array( 'activity/entry.php' ), true, false );
							endwhile;
						if ( bp_activity_has_more_items() ) :
							?>
								<li class="load-more">
									<a href="#more"><?php _e( 'Load More', 'buddypress' ); ?></a>
								</li>
								<?php
							endif;
						if ( empty( $_POST['page'] ) ) :
							?>
							</ul>
							<?php
						endif;
					endif;
				else :
					?>

					<div id="message" class="info">
						<p><?php _e( 'Sorry, there was no activity found. Please try a different filter.', 'buddypress' ); ?></p>
					</div>

					<?php
				endif;
				do_action( 'bp_after_activity_loop' );
				?>

				<form action="" name="activity-loop-form" id="activity-loop-form" method="post">

					<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>

				</form>
			</div>
			<?php
		}
	}
	endif;
