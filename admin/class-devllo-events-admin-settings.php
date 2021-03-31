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

class Devllo_Events_Admin_Settings{

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
	  register_setting( 'devllo-events-options', 'devllo-map-api-key' );
	  register_setting(	'devllo-events-options', 'devllo-events-organiser-checkbox');
	  register_setting(	'devllo-events-options', 'devllo-events-comments-checkbox');	  	  
	  register_setting( 'devllo-events-pages', 'devllo-events-page' );
	  register_setting( 'devllo-events-pages', 'devllo-calendar-page' );
	  register_setting( 'devllo-events-pages', 'devllo-events-template-radio' );
    }

	function enqueue_scripts() {   

        $my_current_screen = get_current_screen();

        if ( isset( $my_current_screen->base ) && 'devllo_event_page_devllo-events-settings' === $my_current_screen->base ) {
            wp_enqueue_style( 'dashboard-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/dashboard.css');
			
			wp_enqueue_style( 'devllo-events-admin-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/style.css');	

        }       
  
      }

    
    public static function devllo_events_settings_page(){
	  $adminpagetitle = get_admin_page_title();
	  
	  ?>
		<div style="width: 100%;">
		</div>
        <?php
		$active_tab = "devllo_events_options";
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

					<h1 class="h3 mb-3"><?php _e('Settings', 'devllo-events'); ?></h1>

					<div class="row">
						<div class="col-md-3 col-xl-3">

							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0"></h5>
								</div>

								<div class="list-group list-group-flush" role="tablist">
									<a class="list-group-item list-group-item-action <?php echo $active_tab == 'devllo_events_options' ? 'nav-tab-active' : ''; ?>" data-bs-toggle="list" href="?page=devllo-events-settings&tab=devllo_events_options&post_type=devllo_event" role="tab">
									<?php _e('General', 'devllo-events'); ?></a>

									<a class="list-group-item list-group-item-action <?php echo $active_tab == 'devllo_events_pages' ? 'nav-tab-active' : ''; ?>" data-bs-toggle="list" href="?page=devllo-events-settings&tab=devllo_events_pages&post_type=devllo_event" role="tab">
									<?php _e('Pages', 'devllo-events'); ?></a>

								</div>
							</div>
						</div>

						<div class="col-md-9 col-xl-9">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="account" role="tabpanel">

			
								<div class="card" style="max-width: none;">
										<div class="card-header">

											<h5 class="card-title mb-0"></h5>
										</div>
										<div class="card-body">
										<form method="post" action="options.php">
<?php

       
        if( $active_tab == 'devllo_events_options' ) {
          settings_fields( 'devllo-events-options' );
          do_settings_sections( 'devllo-events-options' );
           ?>

			<h2><?php _e('General Settings', 'devllo-events'); ?></h2>
			<?php
            if (!get_option('devllo-map-api-key')){ ?>
                <div class="error notice">
				<?php
				$gmapapiurl = 'https://developers.google.com/maps/documentation/javascript/get-api-key';
                echo 'Please Add Your Google Map API Key. <a href="'.esc_url($gmapapiurl).'">Click Here to get a key</a></div>';
            }
            ?>
		<table class="table">
            <tr>
			<th style="text-align: left;"><?php _e('Google Map API Key', 'devllo-events'); ?></th>
			</tr>

			<tr>
			<?php $devlloapikey = get_option('devllo-map-api-key');?>
            <td><input name="devllo-map-api-key" type="text" class="regular-text" value="<?php if (isset($devlloapikey)) { echo esc_attr($devlloapikey); }?>"></td>
			</tr>

			<tr>
			<th style="text-align: left;"><?php _e('Organisers', 'devllo-events'); ?></th></tr>

			<tr>
			<td><?php _e('Show Event Organiser on Events (Event Post Author defaults as Event Organiser)', 'devllo-events'); ?></td></tr>
		  	
			<tr>
		  	<td>
		  	<input type="checkbox" name="devllo-events-organiser-checkbox" value="1" <?php checked(1, get_option('devllo-events-organiser-checkbox'), true); ?> /> 
			</td>
			</tr>
			<tr>
			<th style="text-align: left;"><?php _e('Comments', 'devllo-events'); ?></th></tr>
			<tr>
			<td><?php _e('Enable Comments on Event Pages?', 'devllo-events'); ?></td></tr>
			<tr>
		  	<td>
		  	<input type="checkbox" name="devllo-events-comments-checkbox" value="1" <?php checked(1, get_option('devllo-events-comments-checkbox'), true); ?> /> 
			</td>
			</tr>
            </table>
           
          <?php

		} 
		// Event Pages Settings Page
		elseif ( $active_tab == 'devllo_events_pages' ) {
          settings_fields( 'devllo-events-pages' );
          do_settings_sections( 'devllo-events-pages' );
           ?>
			<h2><?php _e('Pages', 'devllo-events'); ?></h2>
			<table class="table">
			<?php
			 function devllo_post_exists_by_slug( $post_slug ) {
				$loop_posts = new WP_Query( array( 'post_type' => 'page', 'post_status' => 'any', 'name' => $post_slug, 'posts_per_page' => 1, 'fields' => 'ids' ) );
				return ( $loop_posts->have_posts() ? $loop_posts->posts[0] : false );
			} ?>
			<tr>
			<th style="text-align: left;"><?php _e('Events', 'devllo-events'); ?></th>
			<td>
			<em><?php _e('This page should include the shortcode', 'devllo-events');?> [devllo-events]</em>
			<?php   
			wp_dropdown_pages( array( 
				'name' => 'devllo-events-page', 
				'show_option_none' => __( '— Select —' ), 
				'option_none_value' => '0', 
				'selected' => get_option('devllo-events-page'),
				));
			?>
			</td>
			<td><a target="_blank" href="<?php echo esc_url( get_permalink(get_option('devllo-events-page')) ); ?>" class="button button-secondary"><?php _e('View Page', 'devllo-events'); ?></a></td>
			</tr>

			<tr>
			<th style="text-align: left;"><?php _e('Calendar', 'devllo-events'); ?></th>
			<td>
			<em><?php _e('This page should include the shortcode', 'devllo-events');?> [devllo-calendar]</em>
			<?php   
			wp_dropdown_pages( array( 
				'name' => 'devllo-calendar-page', 
				'show_option_none' => __( '— Select —' ), 
				'option_none_value' => '0', 
				'selected' => get_option('devllo-calendar-page'),
				));
			?>
			</td>
			<td><a target="_blank" href="<?php echo esc_url( get_permalink(get_option('devllo-calendar-page')) ); ?>" class="button button-secondary"><?php _e('View Page', 'devllo-events'); ?></a></td>
			</tr>
		
			<tr>
			<th colspan=3 style="text-align: left;">
			<h3><?php _e('Events Page Template', 'devllo-events'); ?></h3></th>
			<td></td>
			<td></td>
			</tr>
			<tr>

			<th colspan=3 style="text-align: left;"><?php _e('Choose a template for the Events Page', 'devllo-events'); ?></th>
			<td></td>
			<td></td>
			</tr>
			<tr>
			<td colspan=3><input type="radio" name="devllo-events-template-radio" value="1" <?php checked(1, get_option('devllo-events-template-radio'), true); ?>><br/><?php _e('Calendar Type Template', 'devllo-events'); ?><br/>
        	<input type="radio" name="devllo-events-template-radio" value="2" <?php checked(2, get_option('devllo-events-template-radio'), true); ?>><br/><?php _e('Blog Grid Template', 'devllo-events'); ?></td>
			<td></td>
			</tr>
			</table>
            <?php
        }
     			submit_button();
            ?>
             </form>										
										</div>
								</div>
								</div>
			
							</div>
						</div>
					</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a href="https://devlloplugins.com/" class="text-muted"><strong>Devllo Plugins</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://devlloplugins.com/support/">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://devlloplugins.com/documentations/events-by-devllo-documentation/">Help Center</a>
								</li>
                                <!--
								<li class="list-inline-item">
									<a class="text-muted" href="#">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="#">Terms</a>
								</li>
                                    -->
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
   <?php
    }

}
Devllo_Events_Admin_Settings::instance();
