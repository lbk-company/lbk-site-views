<?php
// Die if accessed directly
if ( !defined('ABSPATH') ) die();

add_shortcode( 'lbk_total_views', 'total_view' );
add_shortcode( 'lbk_today_views', 'today_view' );

function total_view() {
    global $wpdb;
    $tablename = $wpdb->prefix."countview";

    $sql = "SELECT SUM(count_view) as count_view FROM $tablename";
    $rs = $wpdb->get_results(
        $wpdb->prepare($sql)
    );
    $views = $rs[0]->count_view;
    $view = array();
    
    for ($i = 0; $i<strlen($views); $i++) {
        $view[$i] = $views[$i];
    }
    ob_start();
    ?>
    <div class="lbk">
        <?php foreach ($view as $count) { ?>
        <span class="count-view"><?= $count ?></span>
        <?php } ?>
    </div>
    
    <?php return ob_get_clean();
}

function today_view() {
    global $wpdb;
    $tablename = $wpdb->prefix."countview";
    $date = current_time('Y-m-d');

    $sql = "SELECT SUM(count_view) as count_view FROM $tablename WHERE thoi_gian = '$date'";
    $rs = $wpdb->get_results(
        $wpdb->prepare($sql)
    );
    $views = $rs[0]->count_view;
    $view = array();
    
    for ($i = 0; $i<strlen($views); $i++) {
        $view[$i] = $views[$i];
    }
    ob_start();
    ?>
    <div class="lbk">
        <?php foreach ($view as $count) { ?>
        <span class="count-view"><?= $count ?></span>
        <?php } ?>
    </div>
    
    <?php return ob_get_clean();
}