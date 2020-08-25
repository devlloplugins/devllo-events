<?php
/*
Template Name: Archive Event
Template Post Type: devllo_event
*/


defined( 'ABSPATH' ) || exit();

wp_enqueue_style( 'calendar_css', DEVLLO_EVENTS_INC_URI. 'assets/css/main.css');	

wp_enqueue_style( 'font_css', DEVLLO_EVENTS_INC_URI. 'assets/css/all.css');	

wp_enqueue_style( 'full_calendar_bootstrap', DEVLLO_EVENTS_INC_URI. 'assets/css/bootstrap.css');	

wp_register_script( 'fullcalendar_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.js' );
wp_enqueue_script( 'fullcalendar_js');

wp_register_script( 'fullcalendar_min_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.min.js' );
wp_enqueue_script( 'fullcalendar_min_js');  


get_header(); 
global $post;

?>

<div id="primary" class="site-content">
    <div id="content" role="main">
    <div class="container">

       <?php
       global $wp_query;
       $posts = $wp_query->posts;
       
       foreach( $posts as $post ) {  
        $startdate = get_post_meta( $post->ID, '_start_year', true ). '-' .get_post_meta( $post->ID, '_start_month', true ). '-' .get_post_meta( $post->ID, '_start_day', true ). 'T' .get_post_meta( $post->ID, '_start_hour', true ). ':' .get_post_meta( $post->ID, '_start_minute', true );
        $enddate = get_post_meta( $post->ID, '_end_year', true ). '-' .get_post_meta( $post->ID, '_end_month', true ). '-' .get_post_meta( $post->ID, '_end_day', true ). 'T' .get_post_meta( $post->ID, '_end_hour', true ). ':' .get_post_meta( $post->ID, '_end_minute', true );
         $url = get_permalink( $post->ID ); 
            // Pluck the id and title attributes
        $output[] = array( 'id' => $post->ID, 'title' => $post->post_title, 'start' => $startdate, 'end' => $enddate, 'url' => $url );
        
      } 
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          events: <?php echo json_encode( $output );?>,
          headerToolbar: {
       // center: 'title',
      },
      navLinks: true, // can click day/week names to navigate views
      dayMaxEvents: true, // allow "more" link when too many events


          initialView: 'listYear'
        });
        calendar.render();
      });

</script>

<div id='calendar'></div>


    </div><!-- #primary -->
  </div>
<style>
    div#primary {
    width: 100%;
}
</style>

</div><!-- .container -->

<?php get_footer(); ?>