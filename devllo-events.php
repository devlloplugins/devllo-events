<?php
/*
 *   Plugin Name: Events by Devllo
 *   Plugin URI: https://devlloplugins.com/
 *   Description: This is a simple Event Management plugin for adding and listing and managing your events, show event locations on map, link to online Event locations. It also integrates with FullCalendar to show a calendar with all events.
 *   Author: Devllo Plugins
 *   Version: 1.0.3.2
 *   Author URI: https://devllo.com/
 *   License:    GPL-2.0+
 *   License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 *   Text Domain: devllo-events
 *   Domain Path: /languages
 */

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Current plugin version.
 */
define( 'DEVLLO_EVENTS_VERSION', '1.0.3' );

/**
 * Devllo_Events class
 */


    class Devllo_Events {

        /**
         * The single instance of the class.
         *
         * @var self
         * @since  2.5
         */
        private static $_instance = null;
        public $_session = null;


        /**
         * Devllo_Events Constructor
         */
        public function __construct(){
            register_activation_hook( __FILE__, array( 'Devllo_Events_Activator', 'devllo_events_activate' ));
            register_deactivation_hook( __FILE__, array( 'Devllo_Events_Activator', 'devllo_events_deactivate' ));
            
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
            add_action( 'plugins_loaded', array($this, 'devllo_events_load_plugin_text_domain') );


            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'devllo_events_enqueue_scripts' ) );
            add_filter( 'script_loader_tag', array( $this, 'mind_defer_scripts' ), 10, 3 );

        }

        /**
         * Define Constants
         */
        public function define_constants(){
            $this->set_define( 'DEVLLO_EVENTS_PATH', plugin_dir_path( __FILE__ ) );
            $this->set_define( 'DEVLLO_EVENTS_URI', plugin_dir_url( __FILE__ ) );
            $this->set_define( 'DEVLLO_EVENTS_VERSION', '1.0.3' );
            $this->set_define( 'DEVLLO_EVENTS_ADMIN_URI', DEVLLO_EVENTS_URI . 'admin/' );
            $this->set_define( 'DEVLLO_EVENTS_INC', DEVLLO_EVENTS_PATH . 'includes/' );
            $this->set_define( 'DEVLLO_EVENTS_INC_URI', DEVLLO_EVENTS_URI . 'includes/' );
            $this->set_define( 'DEVLLO_EVENTS_ASSETS_URI', DEVLLO_EVENTS_URI . 'assets/' );
            $this->set_define( 'DEVLLO_EVENTS_TEMPLATES', DEVLLO_EVENTS_PATH . 'templates/' );     
        }

   
        // Enqueue scripts and styles
        
        function devllo_events_enqueue_scripts() {   
            wp_enqueue_style( 'devllo-events-frontend', DEVLLO_EVENTS_INC_URI. 'assets/css/style.css');	
        }
    
        // Defer Scripts
        function mind_defer_scripts( $tag, $handle, $src ) {
            $defer = array( 
    
            'map_api_script','map_auto_complete_script', 'map_api_script2', 'auto_complete'
            );
            if ( in_array( $handle, $defer ) ) {
            return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
            }     
            return $tag;
        } 

        public function admin_enqueue_scripts() {

            wp_enqueue_style( 'devllo-events-admin-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/style.css');	

            wp_enqueue_style( 'jquery-ui-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/jquery-ui.css');	

            wp_enqueue_style( 'jquery-time-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/jquery.timepicker.min.css');	
            global $pagenow;

            if ((( $pagenow == 'post-new.php' ) || ( $pagenow == 'post.php' )) && (get_post_type() == 'devllo_event')) {

                wp_register_script('jquery2', DEVLLO_EVENTS_INC_URI. 'assets/js/jquery-1.12.4.js'); 

                wp_register_script('jquery_ui', DEVLLO_EVENTS_INC_URI. 'assets/js/jquery-ui.js'); 

                wp_register_script('jquery_timpe_picker', DEVLLO_EVENTS_ADMIN_URI. 'assets/js/jquery.timepicker.min.js'); 

                wp_enqueue_script( 'devllo_events_admin', DEVLLO_EVENTS_INC_URI. 'assets/js/devllo-events-admin.js', array(), false, true );

                wp_enqueue_script( 'auto_complete', DEVLLO_EVENTS_INC_URI. 'assets/js/auto-complete.js', array(), false, true );

                wp_enqueue_script( 'map_api_script2', 'https://maps.googleapis.com/maps/api/js?key='. get_option('devllo-map-api-key') .'&libraries=places&callback=initAutocomplete', array(), false, true );
            }

        }

        // set_define
        public function set_define( $name = '', $value = '' ) {
            if ( $name && ! defined( $name ) ) {
                define( $name, $value );
            }
        }

        // _include
        public function _include( $file = null ) {
            if ( is_array( $file ) ) {
                foreach ( $file as $key => $f ) {
                    if ( file_exists( DEVLLO_EVENTS_PATH . $f ) ) {
                        require_once DEVLLO_EVENTS_PATH . $f;
                    }
                }
            } else {
                if ( file_exists( DEVLLO_EVENTS_PATH . $file ) ) {
                    require_once DEVLLO_EVENTS_PATH . $file;
                } elseif ( file_exists( $file ) ) {
                    require_once $file;
                }
            }
        }

        // Load Text Domain
        /* public function text_domain() {
            // Get mo file
            $text_domain = 'devllo-events';
            $locale      = apply_filters( 'plugin_locale', get_locale(), $text_domain );
            $mo_file     = $text_domain . '-' . $locale . '.mo';
            // Check mo file global
            $mo_global = WP_LANG_DIR . '/plugins/' . $mo_file;
            // Load translate file
            if ( file_exists( $mo_global ) ) {
                load_textdomain( $text_domain, $mo_global );
            } else {
                load_textdomain( $text_domain, DEVLLO_EVENTS_PATH . '/languages/' . $mo_file );
            }
        } */

        function devllo_events_load_plugin_text_domain() {
            load_plugin_textdomain( ' devllo-events', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
        }    

        /**
         * Includes
         */
        public function includes(){
            $this->_include( 'includes/class-devllo-events-post-types.php' );
            $this->_include( 'includes/class-devllo-events-session.php' );
            $this->_include( 'includes/devllo-events-functions.php' );   
            $this->_include( 'includes/class-devllo-events-activator.php');   
            $this->_include( 'admin/class-devllo-events-admin-menu.php');
            $this->_include( 'admin/class-devllo-events-posts-admin.php');
            $this->_include( 'admin/class-devllo-events-admin-settings.php');
            $this->_include( 'admin/class-devllo-events-addons-page.php');
            $this->_include( 'templates/calendar-event.php');
            $this->_include( 'templates/template-events.php');

        }

        /**
         * Init Hooks
         */
        public function init_hooks(){
            add_action( 'plugins_loaded', array( $this, 'loaded' ) );
        }

        /**
        * Load components when plugin loaded
        */
		public function loaded() {
			// load text domain
			//$this->text_domain();
			$this->_session = new Devllo_Events_Session();

			do_action( 'devllo_events_init', $this );
		}
    
        /**
		 * get instance class
		 * @return devllo_events
		 */
		public static function instance() {
			if ( ! empty( self::$_instance ) ) {
				return self::$_instance;
			}

			return self::$_instance = new self();
		}
    }
    

    if ( ! function_exists( 'devllo_events' ) ) {
		function devllo_events() {
			return devllo_events::instance();
		}
	}
	devllo_events();

$GLOBALS['devllo_events'] = devllo_events();
