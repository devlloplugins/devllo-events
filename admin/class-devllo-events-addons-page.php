<?php


/**
 * Devllo Events Admin Settings Page
 *
 * @link       https://devllo.com/
 * @since      1.0.0
 *
 * @package    Devllo_Events
 * @subpackage Devllo_Events/includes
 */


/**
 * Prevent loading file directly
 */

defined( 'ABSPATH' ) || exit;

class Devllo_Events_Addons_Page{

    private static $_instance = null;
    
    public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }

    public function __construct() {
	  add_action( 'admin_init', array( $this, 'init_settings'  ) );
	  add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

    public function init_settings() {
    }

	function enqueue_scripts() {   

        $my_current_screen = get_current_screen();

        if ( isset( $my_current_screen->base ) && 'devllo_event_page_devllo-events-addons' === $my_current_screen->base ) {
            wp_enqueue_style( 'dashboard-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/dashboard.css');	

			wp_enqueue_style( 'devllo-events-admin-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/style.css');	

        }       
  
      }

    
    public static function devllo_events_addons_page(){
	  $pagetitle = get_admin_page_title();
	  
	  ?>

        <?php
		$active_tab = "devllo_events_free_addons";
		$tab = filter_input(
			INPUT_GET, 
			'tab', 
			FILTER_CALLBACK, 
			['options' => 'esc_html']
		);
        if( isset( $tab ) ) {
            $active_tab = $tab;
          } ?>
	<div class="wrapper">


		    <!-- SideBar Starts Here -->
			<?php // Add Sidebar
		 devllo_add_sidebar (); 
		  ?>
        <!-- SideBar Ends -->
		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle d-flex">
          		<img src="<?php echo DEVLLO_EVENTS_URI . 'icon-256x256.png'; ?>">

            	</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
					
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>

								</div>
							</a>
						</li>
					</ul>
				</div>
			</nav>
			<main class="content">
				<div class="container-fluid p-0">


				<section class="jumbotron text-center" style="margin-bottom: 10px;">
				<div class="container">
				<h1 class="jumbotron-heading"><?php echo esc_attr($pagetitle); ?></h1>
				<p class="lead text-muted"><?php _e('Awesome addons to help you add features, integration to your Event Website.', 'devllo-events'); ?></p>
				<p>
				<a href="?page=devllo-events-addons&tab=devllo_events_free_addons&post_type=devllo_event" class="btn btn-primary my-2  <?php echo $active_tab == 'devllo_events_free_addons' ? 'nav-tab-active' : ''; ?>"><?php _e('Free Add-Ons', 'devllo-events'); ?></a>
					<a href="?page=devllo-events-addons&tab=devllo_events_premium_addons&post_type=devllo_event" class="btn btn-secondary my-2  <?php echo $active_tab == 'devllo_events_premium_addons' ? 'nav-tab-active' : ''; ?>"><?php _e('Premium Add-Ons', 'devllo-events'); ?></a>
					</p>
				</div>
				</section>

				  <?php
				if( $active_tab == 'devllo_events_free_addons' ) {
          settings_fields( 'devllo-events-free-addons' );
          do_settings_sections( 'devllo-events-free-addons' );
           ?>

			<h2><?php _e('Free Add-Ons', 'devllo-events'); ?></h2>
		
				<div class="addons-container">
					<div><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="width: 60%; margin: 0 auto; display: block;" src="<?php echo DEVLLO_EVENTS_URI . 'admin/assets/img/PMPro-Devllo-Events.png'; ?>" data-holder-rendered="true">
						<div class="card-body">
                  		<p><?php _e('This adds an integration with PMPro to restrict events to PMPro members.', 'devllo-events'); ?></p>
                  		<div class="d-flex justify-content-between align-items-center">
                    	<div class="btn-group">
						<a href="https://wordpress.org/plugins/devllo-events-pmpro/" class="button btn btn-sm btn-outline-secondary"><?php _e('Download', 'devllo-events'); ?></a>
                    	</div>
						</div>
						</div>
					</div>

				</div>
           
          <?php

		} 
		// Event Pages Settings Page
		elseif ( $active_tab == 'devllo_events_premium_addons' ) {
          settings_fields( 'devllo-events-premium-addons' );
          do_settings_sections( 'devllo-events-premium-addons' );
           ?>
			<h2><?php _e('Premium Add-Ons', 'devllo-events'); ?></h2>
			<div class="addons-container">
					<div><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="width: 60%; margin: 0 auto; display: block;" src="<?php echo DEVLLO_EVENTS_URI . 'admin/assets/img/WC-Devllo-Events.png'; ?>" data-holder-rendered="true">
						<div class="card-body">
                  		<p><?php _e('Purchase Events Tickets with WooCommerce.', 'devllo-events'); ?></p>
                  		<div class="d-flex justify-content-between align-items-center">
                    	<div class="btn-group">
						<a href="https://www.devlloplugins.com/product/woocommerce-integration-for-devllo-events/" class="button btn btn-sm btn-outline-secondary"><?php _e('Download', 'devllo-events'); ?></a>
                    	</div>
						</div>
						</div>
					</div>

				</div>
            <?php
        } ?>


		</div>
		</main>
		</div> <!-- main -->
	</div>


	
	  

        
<?php

     

    }

}
Devllo_Events_Addons_Page::instance();

?>