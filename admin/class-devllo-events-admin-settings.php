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
	  
      

	}
	



    public function init_settings() {
	  register_setting( 'devllo-events-options', 'devllo-map-api-key' );
	  register_setting(	'devllo-events-options', 'devllo-events-organiser-checkbox');	  
	  register_setting( 'devllo-events-pages', 'devllo-events-page' );
	  register_setting( 'devllo-events-pages', 'devllo-calendar-page' );
	  register_setting( 'devllo-events-pages', 'devllo-events-template-radio' );
    }

    
    public static function devllo_events_settings_page(){
      $adminpagetitle = get_admin_page_title();
	  ?>
        <h1><?php echo esc_attr($adminpagetitle); ?></h1>

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

        <h2 class="nav-tab-wrapper">
				<a href="?page=devllo-events-settings&tab=devllo_events_options&post_type=devllo_event" class="nav-tab <?php echo $active_tab == 'devllo_events_options' ? 'nav-tab-active' : ''; ?>"><?php _e('Options', 'devllo-events'); ?></a>
				<a href="?page=devllo-events-settings&tab=devllo_events_pages&post_type=devllo_event" class="nav-tab <?php echo $active_tab == 'devllo_events_pages' ? 'nav-tab-active' : ''; ?>"><?php _e('Pages', 'devllo-events'); ?></a>
				</h2>
        
          <form method="post" action="options.php">
<?php

       
        if( $active_tab == 'devllo_events_options' ) {
          settings_fields( 'devllo-events-options' );
          do_settings_sections( 'devllo-events-options' );
           ?>

			<h2><?php _e('Options', 'devllo-events'); ?></h2>
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
			<th style="text-align: left;">Events</th>
			<td></td>
			<td>
			<?php   
			wp_dropdown_pages( array( 
				'name' => 'devllo-events-page', 
				'show_option_none' => __( '— Select —' ), 
				'option_none_value' => '0', 
				'selected' => get_option('devllo-events-page'),
				));
			?>
			</td>
			</tr>

			<tr>
			<th style="text-align: left;">Calendar</th>
			<td></td>
			<td>
			<?php   
			wp_dropdown_pages( array( 
				'name' => 'devllo-calendar-page', 
				'show_option_none' => __( '— Select —' ), 
				'option_none_value' => '0', 
				'selected' => get_option('devllo-calendar-page'),
				));
			?>
			</td>
			</tr>
		
			<tr>
			<th style="text-align: left;">
			<h3>Events Page Template</h3></th>
			<td></td>
			<td></td>
			</tr>
			<tr>

			<th style="text-align: left;">Choose a template for the Events Page</th>
			<td></td>
			<td></td>
			</tr>
			<tr>
			<td><input type="radio" name="devllo-events-template-radio" value="1" <?php checked(1, get_option('devllo-events-template-radio'), true); ?>>Calendar Template</td>
        	<td><input type="radio" name="devllo-events-template-radio" value="2" <?php checked(2, get_option('devllo-events-template-radio'), true); ?>>Blog Template</td>
			<td></td>
			</tr>
			</table>
            <?php
        }
     			submit_button();
            ?>
             </form>
      <?php
    }

}
Devllo_Events_Admin_Settings::instance();
