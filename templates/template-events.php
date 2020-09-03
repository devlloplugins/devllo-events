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
      global $wp_locale;

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
        <h3 class="my-3">Events</h3>
        <h6 class="subtitle font-weight-normal"><?php do_action('devllo_events_blog_template_subtitle'); ?></h6>
      </div>
      <!-- Column -->
      <!-- Column -->
    </div>
      <!-- Column -->
      <div class="row">
      <?php foreach( $posts as $post ) { 
         $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
         $start_month = $wp_locale->get_month(get_post_meta( $post->ID, '_start_month', true ));
         $start_month_abbr = $wp_locale->get_month_abbrev($start_month);
         $start_day = get_post_meta( $post->ID, '_start_day', true );

        ?>
      <div class="col-md-4 on-hover">
        <div class="card border-0 mb-4">
          <a href="<?php echo $url; ?>"><img class="card-img-top" src="<?php echo $featured_img_url; ?>" alt="<?php echo $post->post_title; ?>"></a>
          <div class="date-pos bg-info-gradiant p-2 d-inline-block text-center rounded text-white position-absolute"><?php echo $start_month_abbr; ?><span class="d-block"><?php echo $start_day;?></span></div>
          <h5 class="font-weight-medium mt-3"><a href="<?php echo $url; ?>" class="text-decoration-none link"><?php echo $post->post_title; ?></a></h5>
          <p class="mt-3"><?php echo wp_strip_all_tags( get_the_excerpt(), true ); ?></p>
          <a href="<?php echo $url; ?>" class="text-decoration-none linking text-themecolor mt-2">Learn More</a>
        </div>
      </div>
      <?php } ?>
      <!-- Column --> 
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
