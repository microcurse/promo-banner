<?php
/**
 *  Plugin Name:    Easy Promo Banner
 *  Plugin URI:     https://github.com/microcurse/promo-banner
 *  Description:    This simple WordPress plugin will display a promo banner at the top of the page or below the main navigation
 *  Version:        0.1
 *  Author:         Marc Reyes-Maninang
 *  License:        MIT License
 *  License URI:    https://www.gnu.org/licenses/gpl-2.0.html
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Easy_Promo_Banner {
    public function __construct() {
        //Hook into the admin menu
        add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
    }

    public function create_plugin_settings_page() {
        //Add the menu item and page
        $page_title = 'Easy Promo Banner';
        $menu_title = 'Easy Promo Banner';
        $capability = 'manage_options';
        $slug       = 'easy_promo_banner';
        $callback   = array( $this, 'plugin_settings_page_content' );
        $icon       = 'dashicons-admin-plugins';
        $position   = 100;

        add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }

    public function plugin_settings_page_content() {
        echo 'Hello world!';
    }
}

new Easy_Promo_Banner();
?>