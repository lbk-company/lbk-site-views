<?php
/**
 * LBK Count View
 * 
 * @package LBK Count View
 * @author Briki - LBK
 * @copyright 2021 LBK
 * @license GPL-2.0-or-later
 * @category plugin
 * @version 1.0.3
 * 
 * @wordpress-plugin
 * Plugin Name:       LBK Count View
 * Plugin URI:        https://lbk.vn/
 * Description:       LBK Count View
 * Version:           1.0.3
 * Requires at least: 1.0.3
 * Requires PHP:      8.0
 * Author:            Briki - LBK
 * Author             URI: https://facebook.com/vuong.briki
 * Text Domain:       lbk-cv
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain path:       /languages/
 * 
 * LBK Count View is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *  
 * LBK Count View is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with LBK Count View. If not, see <http://www.gnu.org/licenses/>.
*/

// Die if accessed directly
if ( !defined( 'ABSPATH' ) ) die( 'Hey, what are you doing here? You are silly human!' );

if ( !class_exists('Lbk_Count_View') ) {
    /**
     * Class Lbk_Count_View
     */
    final class Lbk_Count_View {
        /**
         * Current version
         * 
         * @since 1.0
         * @var string
         */
        const VERSION = '1.0.0';

        /**
         * Store the instance of this class
         * 
         * @access private
         * @since 1.0
         * @static
         * 
         * @var Lbk_Count_View
         */
        private static $instance;

        /**
         * A dummny constructor to prevent the class from being loaded more than once
         * 
         * @access public 
         * @since 1.0
         */
        public function __construct() {
            /** Do nothing here */
        }

        /**
         * funtion instance
         * 
         * @access private
         * @since 1.0
         * @static
         * 
         * @return Lbk_Count_View
         */
        public static function instance() {
            if ( !isset( self::$instance ) && !( self::$instance instanceof Lbk_Count_View ) ) {
                self::$instance = new Lbk_Count_View();

                self::defineConstants();
                self::includes();
                self::createDB();
                self::hooks();
            }

            return self::$instance;
        }

        /**
         * Define the plugin constants.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function defineConstants() {
            define( 'LBK_CV_DIR_NAME', plugin_basename( dirname( __FILE__ ) ) );
            define( 'LBK_CV_BASE_NAME', plugin_basename( __FILE__ ) );
            define( 'LBK_CV_PATH', plugin_dir_path( __FILE__ ) );
            define( 'LBK_CV_URL', plugin_dir_url( __FILE__ ) );
        }

        /**
         * Includes the plugin dependency files.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function includes() {
            if ( is_admin() ) {
                require_once LBK_CV_PATH . 'includes/class.admin.php';
            }

            require_once LBK_CV_PATH . 'includes/shortcode.php';
            require_once LBK_CV_PATH . 'includes/count.php';
        }

        /**
         * Add hooks
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function hooks() {
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueStyle' ) );
        }

        /**
         * Create DB
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private static function createDB() {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();

            $tablename = $wpdb->prefix."countview";
            
            $sql = "CREATE TABLE $tablename (
                id mediumint(11) NOT NULL AUTO_INCREMENT,
                thoi_gian date NOT NULL,
                count_view int NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        /**
         * Register the scripts used in the admin
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public static function enqueueStyle() {
            if ( !get_option('cv_style') ) $style = 'default.css';
            else $style = 'style-' . get_option('cv_style') . '.css';
            wp_register_style( 'lbk_cv_style', LBK_CV_URL . 'css/' . $style, array(), Lbk_Count_View::VERSION );
            wp_enqueue_style('lbk_cv_style');
        }
    }

    /**
     * The main function reponsible for returning the LBK Count View instance to function everywhere.
     * 
     * Use this function like you would a global variable, except without needing to declare the global.
     * 
     * Example: <?php $instance = Lbk_Count_View(); ?>
     * 
     * @access public
     * @since 1.0
     * 
     * @return Lbk_Count_View
     */
    function Lbk_Count_View_Site() {
        return Lbk_Count_View::instance();
    }

    // Start LBK Count View
    add_action( 'plugins_loaded', 'Lbk_Count_View_Site' );
}