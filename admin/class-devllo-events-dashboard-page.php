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

class Devllo_Events_Dashboard_Page{

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

        if ( isset( $my_current_screen->base ) && 'devllo_event_page_devllo-events-dashboard' === $my_current_screen->base ) {
            wp_enqueue_style( 'dashboard-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/dashboard.css');	


        wp_register_script( 'fullcalendar_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.js' );
        wp_enqueue_script( 'fullcalendar_js');
  
        wp_register_script( 'fullcalendar_min_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.min.js' );
        wp_enqueue_script( 'fullcalendar_min_js');  
              
          wp_enqueue_style( 'calendar_css', DEVLLO_EVENTS_INC_URI. 'assets/css/main.css');	
  
          wp_enqueue_style( 'font_css', DEVLLO_EVENTS_INC_URI. 'assets/css/all.css');	

          wp_enqueue_style( 'devllo-events-admin-css', DEVLLO_EVENTS_ADMIN_URI. 'assets/css/style.css');	

          wp_enqueue_style( 'fonts-ui-css', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');	

        }


         
  
      }

    
    public static function devllo_events_dashboard_page(){
	  $pagetitle = get_admin_page_title();

      global $post;
      global $wp_locale;

      $args = array( 
           'post_type' => 'devllo_event', 
           'post_status' => 'publish', 
           'nopaging' => true 
       ); 
     
     $posts = get_posts( $args );
     
       $output = array();
      foreach( $posts as $post ) {  
        $startdate = get_post_meta( $post->ID, '_start_year', true ). '-' .get_post_meta( $post->ID, '_start_month', true ). '-' .get_post_meta( $post->ID, '_start_day', true ). 'T' .get_post_meta( $post->ID, '_start_hour', true ). ':' .get_post_meta( $post->ID, '_start_minute', true );
        $enddate = get_post_meta( $post->ID, '_end_year', true ). '-' .get_post_meta( $post->ID, '_end_month', true ). '-' .get_post_meta( $post->ID, '_end_day', true ). 'T' .get_post_meta( $post->ID, '_end_hour', true ). ':' .get_post_meta( $post->ID, '_end_minute', true );
        $url = get_permalink( $post->ID ); 
           // Pluck the id and title attributes
       $output[] = array( 'id' => $post->ID, 'title' => $post->post_title, 'start' => $startdate, 'end' => $enddate, 'url' => $url );
       
     } 
	  
	  ?>

        <?php
		$active_tab = "devllo_events_free_dashboard";
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
		 devllo_add_sidebar(); 
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

					<div class="row mb-2 mb-xl-3">
						<div class="col-auto d-none d-sm-block">
							<h3><strong>Events</strong> Dashboard</h3>
						</div>

					<!--	<div class="col-auto ms-auto text-end mt-n1">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
									<li class="breadcrumb-item"><a href="#">AdminKit</a></li>
									<li class="breadcrumb-item"><a href="#">Dashboards</a></li>
									<li class="breadcrumb-item active" aria-current="page">Analytics</li>
								</ol>
							</nav>
						</div>-->
					</div>


					<div class="row">
						<div class="col-12 col-lg-9 col-xxl-9 d-flex">
							<div style="max-width: none;" class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Events</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Event</th>
											<th class="d-none d-xl-table-cell">Start Date</th>
											<th class="d-none d-xl-table-cell">End Date</th>
											<th>Status</th>
											<th class="d-none d-md-table-cell">Organiser</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
                                    global $post;
                                
                                      $args = array( 
                                           'post_type' => 'devllo_event', 
                                           'post_status' => 'publish', 
                                         //  'nopaging' => true,
                                           'numberposts' => 5
                                       ); 
                                     
                                     $posts = get_posts( $args );
                                     
                                       $output = array();

                                       foreach( $posts as $post ) {  
                                        $startdate = get_post_meta( $post->ID, '_start_year', true ). '-' .get_post_meta( $post->ID, '_start_month', true ). '-' .get_post_meta( $post->ID, '_start_day', true );
                                        $enddate = get_post_meta( $post->ID, '_end_year', true ). '-' .get_post_meta( $post->ID, '_end_month', true ). '-' .get_post_meta( $post->ID, '_end_day', true );
                                        $url = get_permalink( $post->ID ); 
                                           // Pluck the id and title attributes
                                       $output[] = array( 'id' => $post->ID, 'title' => $post->post_title, 'start' => $startdate, 'end' => $enddate, 'url' => $url );

                                       $startcheckdate = get_post_meta( $post->ID, '_start_year', true ). '-' .get_post_meta( $post->ID, '_start_month', true ). '-' .get_post_meta( $post->ID, '_start_day', true );
                                       $endcheckdate = get_post_meta( $post->ID, '_end_year', true ). '-' .get_post_meta( $post->ID, '_end_month', true ). '-' .get_post_meta( $post->ID, '_end_day', true );
                                      
                                       $startchecktime = get_post_meta( $post->ID, '_start_hour', true ). ':' .get_post_meta( $post->ID, '_start_minute', true );
                                       $endchecktime = get_post_meta( $post->ID, '_end_hour', true ). ':' .get_post_meta( $post->ID, '_end_minute', true );

                                        if (new DateTime() > new DateTime("$endcheckdate $endchecktime")) {
                                        # current time is greater than 2010-05-15 16:00:00
                                        # in other words, 2010-05-15 16:00:00 has passed
                                        $bgstyle = 'bg-danger';
                                        $event_status = 'Past Event';
                                        }
                                        elseif (new DateTime() < new DateTime("$startcheckdate $startchecktime")) {
                                            # current time is greater than 2010-05-15 16:00:00
                                            # in other words, 2010-05-15 16:00:00 has passed
                                            $bgstyle = 'bg-success';
                                            $event_status = 'Upcoming Event';

                                        }
                                        elseif (new DateTime() > new DateTime("$startcheckdate $startchecktime") &&new DateTime() < new DateTime("$endcheckdate $endchecktime")) {
                                            # current time is greater than 2010-05-15 16:00:00
                                            # in other words, 2010-05-15 16:00:00 has passed
                                            $bgstyle = 'bg-warning';
                                            $event_status = 'Ongoing Event';

                                        }
                                        elseif (new DateTime() == new DateTime("$startcheckdate $startchecktime")) {
                                            # current time is greater than 2010-05-15 16:00:00
                                            # in other words, 2010-05-15 16:00:00 has passed
                                            $bgstyle = 'bg-warning';
                                            $event_status = 'Ongoing Event';
                                        }
                        
                                        if ($post){
                                        $event_post_title = $post->post_title;
                                        $author_id=$post->post_author; 
                                        $organiser = get_the_author_meta( 'display_name' , $author_id ); 

                                        }

                                    ?>
										<tr>
											<td><?php echo $event_post_title; ?></td>
											<td class="d-none d-xl-table-cell"><?php echo $startdate; ?></td>
											<td class="d-none d-xl-table-cell"><?php echo $enddate; ?></td>
											<td><span class="badge <?php echo $bgstyle; ?>"><?php echo $event_status; ?></span></td>
											<td class="d-none d-md-table-cell"><?php echo $organiser; ?></td>
										</tr>
                                        <?php  }?>
									</tbody>
								</table>
							</div>
						</div>
					<!--	<div class="col-12 col-lg-4 col-xxl-3 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Monthly Sales</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div> -->
					</div>

					<div class="row">
			
                    <div class="col-12 col-lg-9 col-xxl-9 d-flex">
                            <div style="max-width: none;" class="card flex-fill">

								<div class="card-header">

									<h5 class="card-title mb-0">Calendar</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="chart">
											<div id="calendar"></div>
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
    <script>

document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          events: <?php echo json_encode( $output );?>,
          headerToolbar: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      navLinks: true, // can click day/week names to navigate views
      dayMaxEvents: false, // allow "more" link when too many events


          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

</script> 

	
<?php
    }

}
Devllo_Events_Dashboard_Page::instance();

?>