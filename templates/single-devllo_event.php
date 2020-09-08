<?php
/*
Template Name: Single Event
Template Post Type: devllo_event
*/


defined( 'ABSPATH' ) || exit();

wp_register_script( 'map_auto_complete_script', DEVLLO_EVENTS_INC_URI. 'assets/js/map-auto-complete.js' );
wp_enqueue_script( 'map_auto_complete_script');

wp_register_script( 'map_api_script', 'https://maps.googleapis.com/maps/api/js?key='. get_option('devllo-map-api-key') .'&callback=initMap&libraries=&v=weekly' );
wp_enqueue_script( 'map_api_script');


get_header( ); 

global $post;
global $wp_locale;


// Variables needed to load this template
// Address
$map_location = get_post_meta( $post->ID, 'devllo_event_location_key', true );
// Event Online Link
$event_link = get_post_meta( $post->ID, 'devllo_event_event_link_key', true );
$url = get_post_meta( $post->ID, 'devllo_event_url_key', true );

// Event Location Name
$location_name = get_post_meta( $post->ID, 'devllo_event_location_name_key', true );
//Location Latitude
$location_lat = get_post_meta( $post->ID, 'devllo_event_location_lat_key', true );
//Location Longtitude
$location_long = get_post_meta( $post->ID, 'devllo_event_location_long_key', true );
// Event Dates
$metabox_ids = array( 'Event Start Date'=>'_start', 'Event End Date'=>'_end' );

foreach ($metabox_ids as $key => $metabox_id ) {
    $eventdate = '<br><br><div class="date">';
    $month = get_post_meta( $post->ID, $metabox_id . '_month', true );
  //  $month_name = eventposttype_get_the_month_abbr($month);
    $eventdate = '<div> Month ' . get_post_meta( $post->ID, $metabox_id . '_month', true ) . '</div>';
    $eventdate = '<div> Date ' . get_post_meta( $post->ID, $metabox_id . '_day', true ) . '</div>';
    $eventdate .= '<div> Year ' . get_post_meta( $post->ID, $metabox_id . '_year', true ) . '</div>';
    $eventdate .= ' at Time ' . get_post_meta($post->ID, $metabox_id . '_hour', true);
    $eventdate .= ':' . get_post_meta($post->ID, $metabox_id . '_minute', true). '</div>';
}
$startday = get_post_meta( $post->ID, '_start_day', true );
$startmonth = get_post_meta( $post->ID, '_start_month', true );
$startyear =  get_post_meta( $post->ID, '_start_year', true );
$startweekday = date("l", mktime(0, 0, 0, $startmonth, $startday, $startyear));

$endday = get_post_meta( $post->ID, '_end_day', true );
$endmonth = get_post_meta( $post->ID, '_end_month', true );
$endyear =  get_post_meta( $post->ID, '_end_year', true );
$endweekday = date("l", mktime(0, 0, 0, $endmonth, $endday, $endyear));



$startdate = get_post_meta( $post->ID, '_start_year', true ). '-' .get_post_meta( $post->ID, '_start_month', true ). '-' .get_post_meta( $post->ID, '_start_day', true );
$enddate = get_post_meta( $post->ID, '_end_year', true ). '-' .get_post_meta( $post->ID, '_end_month', true ). '-' .get_post_meta( $post->ID, '_end_day', true );

?>
<input type="hidden" value="<?php echo $location_lat;?>" name="lat" id="lat" disabled="true">
<input type="hidden" value="<?php echo $location_long;?>" name="long" id="long" disabled="true">
 

<div id="primary" class="site-content">
    <div id="content" role="main">
    <div class="container">

<?php while ( have_posts() ) : the_post(); 
 /* grab the url for the full size featured image */
 $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
?>
        <?php 
        echo '<div class="event-title event-page-title"><h1 class="event-title">'.  get_the_title().  '</h1>';
        if (get_option( 'devllo-events-organiser-checkbox' ) == 1){
        echo '<div class="event-organiser">' . __('Event Organiser', 'devllo-events') . '<br><span class="organiser-name">'.  get_the_author() . '</span></div></div>';
        }
        get_template_part( 'content', 'page' ); ?>

        <div class="row">
          <div class="col-md-8 blog-main">

            <div class="event-banner-image">
            <img class="img-fluid rounded" src="<?php echo esc_url($featured_img_url); ?>" alt="">
            </div>

            <div><?php do_action('devllo_events_before_main_single_event'); ?></div>
            <div class="event-details">
              <h3><?php _e('Event Details', 'devllo-events') ?></h3>
              <p class="lead"><?php the_content(); ?></p>

              <div class="event-date-time">
                <h3><?php _e('Event Date', 'devllo-events') ?></h3>
                <p><?php _e('Event Start Date:', 'devllo-events') ?>
                  <?php echo $startweekday . ', ' . $wp_locale->get_month($startmonth) . ' ' . get_post_meta( $post->ID, '_start_day', true ). ', ' . get_post_meta($post->ID, '_start_hour', true) . ':' . get_post_meta($post->ID, '_start_minute', true);?>
                  </p> 

                  <p><?php _e('Event End Date:', 'devllo-events') ?>
                  <?php echo $endweekday . ', ' . $wp_locale->get_month($endmonth) . ' ' . get_post_meta( $post->ID, '_end_day', true ). ', ' . get_post_meta($post->ID, '_end_hour', true) . ':' . get_post_meta($post->ID, '_end_minute', true);?>
                  </p> 
              </div>
            </div>

            <div><?php do_action('devllo_events_after_main_single_event'); ?></div>


            <div class="event-comments">
              <div class="card my-4">
              <h3 class="event-comments-title"><span>Comments</span></h3>
              <?php comments_template(); ?>
              </div>
            </div>

            </div> <!-- /col-md-8 blog-main -->

      <div class="col-md-4">
              <div><?php do_action('devllo_events_before_side_single_event'); ?></div>

              <div class="event-location">
                <?php if(!empty($url)){ ?>
                <h3><?php _e('Event Website', 'devllo-events') ?></h3>
                <p><a href="<?php echo esc_url($url); ?>"><?php echo esc_attr($url); ?></a></p>
                <?php } ?>

                <?php if(!empty($event_link)){ ?>
                <h3><?php _e('Event Online Link', 'devllo-events') ?></h3>
                <p><a href="<?php echo esc_url($event_link) ?>"><?php echo esc_attr($event_link); ?></a></p>
                <?php } ?>

                <?php if(!empty($location_name)){ ?>
                <h3><?php _e('Event Location', 'devllo-events') ?></h3>
                <p><?php echo esc_attr($location_name); ?></p>
                <?php } ?>

                <?php if(!empty($map_location)){ ?>
                <p><?php echo esc_attr($map_location); ?></p>
                <div id="map"></div>
                <?php } ?>
              </div>

              <div><?php do_action('devllo_events_after_side_single_event'); ?></div>
      </div>


          
      <?php endwhile; // end of the loop. 
?>

        </div> <!-- /row -->

      </div><!-- #container -->
    </div><!-- #content -->
  </div><!-- #primary -->



<?php get_footer( );
