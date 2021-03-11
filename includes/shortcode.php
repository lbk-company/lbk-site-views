<?php
// Die if accessed directly
if ( !defined('ABSPATH') ) die();

add_shortcode( 'lbk_total_views', 'lbk_total_views' );
add_shortcode( 'lbk_today_views', 'lbk_today_views' );

if ( !function_exists('lbk_total_views') ) {
    function lbk_total_views() {
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
            <span class="count-view"><?php echo $count; ?></span>
            <?php } ?>
        </div>
        
        <?php return ob_get_clean();
    }
}

if ( !function_exists('lbk_today_views') ) {
    function lbk_today_views() {
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
            <span class="count-view"><?php echo $count; ?></span>
            <?php } ?>
        </div>
        
        <?php return ob_get_clean();
    }
}