<?php
// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) exit;

if ( !class_exists( 'lbkCv_Admin' ) ) {
    /**
     * Class lbkCv_Admin
     */
    final class lbkCv_Admin {
        /**
         * Setup plugin for admin use
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function __construct() {
            $this->hooks();
        }

        /**
         * Add the core admin hooks.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private function hooks() {
            add_action( 'admin_init', array( $this, 'registerScripts' ) );
            add_action( 'admin_menu', array( $this, 'menu' ) );
            add_action( 'admin_init', array( $this, 'register_lbk_cv_general_settings') );
            add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 10, 2 );
        }

        /**
         * Register settings.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function register_lbk_cv_general_settings() { 
            // Register all settings for general settings page 
            register_setting( 'lbk_cv_settings', 'cv_style'); 
        }

        /**
         * Register the scripts used in the admin
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function registerScripts() {
            wp_register_script( 'lbk_cv_admin_script', LBK_CV_URL . 'js/admin.js', array( 'jquery', 'wp_color-picker' ), Lbk_Count_View::VERSION, true );
            wp_register_style( 'lbk_cv_admin_style', LBK_CV_URL . 'css/admin.css', array( 'wp-color-picker' ), Lbk_Count_View::VERSION );
        }

        /**
         * Callback to add plugin as a submenu page of the Options page.
         * 
         * This also adds the action to enqueue the scripts to be loaded on plugin's admin page only.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function menu() {
            $page = add_submenu_page( 
                'options-general.php',
                esc_html__( 'LBK Count View', 'lbk-cv' ),
                esc_html__( 'LBK Count View', 'lbk-cv' ),
                'manage_options',
                'lbk-count-view',
                array( $this, 'page' )
            );

            add_action( 'admin_print_styles-' . $page, array( $this, 'enqueueScripts' ) );
        }

        /**
         * Enqueue the scripts.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function enqueueScripts() {
            wp_enqueue_script( 'lbk_cv_admin_script' );
            wp_enqueue_style( 'lbk_cv_admin_style' );
        }

        /**
         * Callback used to render the admin options page.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function page() {
            include LBK_CV_PATH . 'includes/admin-options-page.php';
        }

        /**
         * Add a link to the settings page
         * 
         * @access public
         * @since 1.0
         * @static
         */
        public function add_settings_link( $links, $file ) {
            if (
                strrpos( $file, '/count-view.php' ) === ( strlen( $file ) - 15 ) &&
                current_user_can( 'manage_options' )
            ) {
                $settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=lbk-count-view' ), __( 'Settings', 'lbk-cv' ) );
                $links = (array) $links;
                $links['lbksvc_settings_link'] = $settings_link;
            }

            return $links;
        }
    }
    new lbkCv_Admin();
}