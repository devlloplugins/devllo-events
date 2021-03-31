<?php  

function devllo_add_sidebar (){
	$my_current_screen = get_current_screen();

    ?>
<!-- SideBar Starts Here -->
<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="edit.php?post_type=devllo_event&page=devllo-events-dashboard">
          <span class="align-middle">Events By Devllo <span style="font-size: 10px;">v1.0.4</span></span>
            </a>

				<ul class="sidebar-nav">
					<li class="sidebar-item <?php if ( isset( $my_current_screen->base ) && 'devllo_event_page_devllo-events-dashboard' === $my_current_screen->base ) {
 					echo 'active'; }?>">
						<a class="sidebar-link" href="edit.php?post_type=devllo_event&page=devllo-events-dashboard">
              		<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            		</a>
					</li>

					<li class="sidebar-item <?php if ( isset( $my_current_screen->base ) && 'devllo_event_page_devllo-events-settings' === $my_current_screen->base ) { echo 'active'; }?>">
						<a class="sidebar-link" href="edit.php?post_type=devllo_event&page=devllo-events-settings">
              		<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
            		</a>
					</li>

					<li class="sidebar-header <?php if ( isset( $my_current_screen->base ) && 'devllo_event_page_devllo-events-addons' === $my_current_screen->base ) { echo 'active'; }?>">                        Add-Ons
					</li>

					<li class="sidebar-item">
					<a class="sidebar-link" href="edit.php?page=devllo-events-addons&tab=devllo_events_free_addons&post_type=devllo_event">
              		<i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Free Add-Ons</span>
            		</a>
					</li>

					<li class="sidebar-item">
					<a class="sidebar-link" href="edit.php?page=devllo-events-addons&tab=devllo_events_premium_addons&post_type=devllo_event">
              		<i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">Premium Add-Ons</span>
            		</a>
					</li>
					
					<?php do_action('devllo_events_sidebar_item'); ?>

				</ul>

				<div class="sidebar-cta">
					<div class="sidebar-cta-content">
						<strong class="d-inline-block mb-2">Premium Support</strong>
						<div class="mb-3 text-sm">
							Need help? Subscribe for Premium Support here.
						</div>
						<div class="d-grid">
							<a href="https://devlloplugins.com/support/" target="_blank" class="btn btn-primary">Get Support</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
        <!-- SideBar Ends -->
        <?php } ?>