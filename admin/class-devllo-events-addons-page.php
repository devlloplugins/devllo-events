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
	}
	



    public function init_settings() {

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

	<section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading"><?php echo esc_attr($pagetitle); ?></h1>
          <p class="lead text-muted">Awesome addons to help you add features, integration to your Event Website.</p>
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
                  		<p>This adds an integration with PMPro to restrict events to PMPro members.</p>
                  		<div class="d-flex justify-content-between align-items-center">
                    	<div class="btn-group">
						<a href="https://wordpress.org/plugins/devllo-events-pmpro/" class="button btn btn-sm btn-outline-secondary">Download</a>
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
                  		<p>Purchase Events Tickets with WooCommerce.</p>
                  		<div class="d-flex justify-content-between align-items-center">
                    	<div class="btn-group">
						<a href="https://www.devlloplugins.com/product/woocommerce-integration-for-devllo-events/" class="button btn btn-sm btn-outline-secondary">Download</a>
                    	</div>
						</div>
						</div>
					</div>

				</div>
            <?php
        }

    }

}
Devllo_Events_Addons_Page::instance();

?>

<style>
	@media (min-width: 768px){
.jumbotron {
    padding-top: calc(var(--jumbotron-padding-y) * 2);
    padding-bottom: calc(var(--jumbotron-padding-y) * 2);
}
}

.jumbotron {
    padding-top: var(--jumbotron-padding-y);
    padding-bottom: var(--jumbotron-padding-y);
    margin-bottom: 0;
    background-color: #fff;
}

@media (min-width: 576px){
.jumbotron {
    padding: 4rem 2rem;
}}

.jumbotron {
    padding: 2rem 1rem;
    margin-bottom: 2rem;
    background-color: #e9ecef;
    border-radius: .3rem;
}

.jumbotron .container {
    max-width: 40rem;
}

@media (min-width: 1200px){
    .jumbotron .container {
    max-width: 1140px;
}
}

@media (min-width: 992px){
    .jumbotron .container {
    max-width: 960px;
}
}

.jumbotron .container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

.jumbotron-heading {
    font-weight: 300;
}

.jumbotron {
    text-align: center;
}

.text-muted {
    color: ##82b359!important;
}
.lead {
    font-size: 1.25rem;
    font-weight: 300;
}

.jumbotron p:last-child {
    margin-bottom: 0;
}

.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
}
.mb-2, .my-2 {
    margin-bottom: .5rem!important;
}
.mt-2, .my-2 {
    margin-top: .5rem!important;
}
.btn-primary {
    color: #fff;
    background-color: #82b359;
    border-color: #82b359;
}
.jumbotron .btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.jumbotron .btn-secondary {
    color: #fff;
    background-color: #82b359;
    border-color: #82b359;
}

.addons-container {
display: grid;
grid-template-columns: repeat(3, 1fr);
grid-template-rows: 1fr;
grid-column-gap: 30px;
grid-row-gap: 30px;
}

</style>
