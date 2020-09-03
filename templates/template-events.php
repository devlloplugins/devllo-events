<?php

class Devllo_Events_Template_Display {
    public function __construct(){   
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_shortcode('devllo-events', array($this, 'display_calendar'));


    }

    function enqueue_scripts() {   

      wp_register_script( 'fullcalendar_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.js' );
      wp_enqueue_script( 'fullcalendar_js');

      wp_register_script( 'fullcalendar_min_js', DEVLLO_EVENTS_INC_URI. 'assets/js/main.min.js' );
      wp_enqueue_script( 'fullcalendar_min_js');  

      wp_enqueue_style( 'calendar_css', DEVLLO_EVENTS_INC_URI. 'assets/css/main.css');	

      wp_enqueue_style( 'font_css', DEVLLO_EVENTS_INC_URI. 'assets/css/all.css');	

      wp_enqueue_style( 'full_calendar_bootstrap', DEVLLO_EVENTS_INC_URI. 'assets/css/bootstrap.css');	

    }

    function display_calendar($content = null){
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
 <?php if (get_option('devllo-events-template-radio') == 1){?>
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

<?php
 } elseif (get_option('devllo-events-template-radio') == 2 ){

// Load Blog styled Events Template
?>
<div class="blog-home2 py-5">
  <div class="container">
    <!-- Row  -->
    <div class="row justify-content-center">
      <!-- Column -->
      <div class="col-md-8 text-center">
        <h3 class="my-3">Upcoming Events</h3>
        <h6 class="subtitle font-weight-normal">You can relay on our amazing features list and also our customer services will be great experience for you without doubt</h6>
      </div>
      <!-- Column -->
      <!-- Column -->
    </div>
    <div class="row mt-4">
      <!-- Column -->
      <div class="col-md-4 on-hover">
        <div class="card border-0 mb-4">
          <a href="#"><img class="card-img-top" src="https://www.wrappixel.com/demos/ui-kit/wrapkit/assets/images/blog/blog-home/img3.jpg" alt="wrappixel kit"></a>
          <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">Oct<span class="d-block">23</span></div>
          <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">You should have eagle’s eye on new trends and techonogies</a></h5>
          <p class="mt-3">Business Park, Opp. Corns Sam Restaurant, New Yoark, US</p>
          <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
        </div>
      </div>
      <!-- Column -->
      <div class="col-md-4 on-hover">
        <div class="card border-0 mb-4">
          <a href="#"><img class="card-img-top" src="https://www.wrappixel.com/demos/ui-kit/wrapkit/assets/images/blog/blog-home/img2.jpg" alt="wrappixel kit"></a>
          <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">Oct<span class="d-block">23</span></div>
          <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">New Seminar on Newest Food Recipe from World’s Best</a></h5>
          <p class="mt-3">Business Park, Opp. Corns Sam Restaurant, New Yoark, US</p>
          <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
        </div>
      </div>
      <!-- Column -->
      <div class="col-md-4 on-hover">
        <div class="card border-0 mb-4">
          <a href="#"><img class="card-img-top" src="https://www.wrappixel.com/demos/ui-kit/wrapkit/assets/images/blog/blog-home/img1.jpg" alt="wrappixel kit"></a>
          <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute">Oct<span class="d-block">23</span></div>
          <h5 class="font-weight-medium mt-3"><a href="#" class="text-decoration-none link">Learn from small things to create something bigger.</a></h5>
          <p class="mt-3">Business Park, Opp. Corns Sam Restaurant, New Yoark, US</p>
          <a href="#" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

 }

$content = ob_get_contents();
ob_end_clean();

return $content;
}
  }
}
new Devllo_Events_Template_Display();
