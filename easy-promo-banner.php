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
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );
    }

    public function create_plugin_settings_page() {
        //Add the menu item and page
        $page_title = 'Easy Promo Banner';
        $menu_title = 'Easy Promo Banner';
        $capability = 'manage_options';
        $slug       = 'promo_fields';
        $callback   = array( $this, 'plugin_settings_page_content' );
        $icon       = 'dashicons-admin-plugins';
        $position   = 100;

        add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }

    public function plugin_settings_page_content() { ?>
        <div class="wrap">
            <h2>Easy Promo Banner Settings</h2>
            <form method="post" action="options.php">
                <?php 
                    settings_fields( 'promo_fields' );
                    do_settings_sections( 'promo_fields' );
                    submit_button();    
                ?>
            </form>
        </div> <?php
    }

    public function setup_sections() {
        add_settings_section( 'our_first_section', 'My First Section Title', array( $this, 'section_callback' ), 'promo_fields' );
        add_settings_section( 'our_second_section', 'My Second Section Title', array( $this, 'section_callback' ), 'promo_fields');
        add_settings_section( 'our_third_section', 'My Third Section Title', array( $this, 'section_callback' ), 'promo_fields');
    }

    public function section_callback( $args ) {
        switch( $args['id'] ){
            case 'our_first_section':
                echo 'This is the first description here!';
                break;
            case 'our_second_section':
                echo 'This is the second description here!';
                break;
            case 'our_third_section':
                echo 'This is the third description here!';
                break;
        }
    }

    public function setup_fields() {
        add_settings_field( 'our_first_field', 'Field Name', array( $this, 'field_callback' ), 'promo_fields', 'our_first_section' );
        register_setting( 'promo_fields', 'our_first_field' );
    }

    public function field_callback( $args ) {
        echo '<input name="our_first_field" id="our_first_field" type="text" value="' . get_option( 'our_first_field' ) . '" />';
    }
}

new Easy_Promo_Banner();
?>