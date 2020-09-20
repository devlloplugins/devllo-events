<?php

class Devllo_Events_Calendar_Display {

    public function __construct(){  
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_shortcode('devllo-calendar', array($this, 'display_calendar'));

    }

    function enqueue_scripts() {   

      wp_register_script( 'fullcalendar_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.js' );
      wp_enqueue_script( 'fullcalendar_js');

      wp_register_script( 'fullcalendar_min_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.min.js' );
      wp_enqueue_script( 'fullcalendar_min_js'); 
      
      global $post;
      if ( has_shortcode( $post->post_content, 'devllo-calendar' ) ) {
        wp_enqueue_style( 'full_calendar_bootstrap', DEVLLO_EVENTS_INC_URI. 'assets/css/bootstrap.css');

        wp_enqueue_style( 'calendar_css', DEVLLO_EVENTS_INC_URI. 'assets/css/main.css');	

        wp_enqueue_style( 'font_css', DEVLLO_EVENTS_INC_URI. 'assets/css/all.css');	
       }

    }
    
    function display_calendar($content=null){
			if (!is_admin()){
    global $post;
    ob_start();

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
    <script>

document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          events: <?php echo json_encode( $output );?>,
          headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      navLinks: true, // can click day/week names to navigate views
      dayMaxEvents: true, // allow "more" link when too many events


          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

</script> 
<?php 

// Add Before Calendar Hook
do_action("devllo_before_calendar_hook");
?>

<div id='calendar'></div>
<p></p>
<?php 

// Add After Calendar Hook
do_action("devllo_after_calendar_hook");
$content = ob_get_contents();
ob_end_clean();

return $content;
}
	}
}
new Devllo_Events_Calendar_Display();
