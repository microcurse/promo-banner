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

add_action('admin_menu', 'promo_banner_setup_menu');

function promo_banner_setup_menu() {
    add_menu_page( 'Easy Promo Banner', 'Easy Promo Banner','manage_options', 'easy-promo-banner', 'easy_promo_init');
}

function easy_promo_init() {
    echo "<h1>Hello World!</h1>";
}

?>