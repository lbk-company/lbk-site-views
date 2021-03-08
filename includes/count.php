<?php
// Die if accessed directly
if ( !defined('ABSPATH') ) die();

function count_view() {
    if ( $_COOKIE['lbk_viewed'] != 'viewed') {
        setcookie('lbk_viewed', 'viewed', time() + (5*60),'/');
        global $wpdb;
        $tablename = $wpdb->prefix."countview";
        $date = current_time('Y-m-d');
        
        $sql = "SELECT SUM(count_view) as count_view FROM $tablename WHERE thoi_gian = '$date'";
        $rs = $wpdb->get_results(
            $wpdb->prepare($sql)
        );
        if ( $rs[0]->count_view == NULL ) {
            $count = 1;
            $query = "INSERT INTO $tablename(thoi_gian, count_view) VALUES ('$date',$count)";
            $wpdb->query($wpdb->prepare($query));
        }
        else {
            $count = $rs[0]->count_view;
            $count++;
            $query = "UPDATE $tablename SET count_view=$count WHERE thoi_gian='$date'";
            $wpdb->query($wpdb->prepare($query));
        }
    }
}
add_action( 'wp_footer', 'count_view' );