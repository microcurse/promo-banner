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
        add_settings_section( 'our_first_section', ' ', array( $this, 'section_callback' ), 'promo_fields' );
        
        // Uncomment below to add more sections. Be sure to update the callbacks if you add more than 3 sections
    
        // add_settings_section( 'our_second_section', 'My Second Section Title', array( $this, 'section_callback' ), 'promo_fields');
        // add_settings_section( 'our_third_section', 'My Third Section Title', array( $this, 'section_callback' ), 'promo_fields');
        
    }

    public function section_callback( $args ) {
        switch( $args['id'] ){
            case 'our_first_section':
                echo '<p style="max-width:450px;">Enter text for promo banner here. You can choose which pages to show this promo banner on by inputting the Page ID below. You can also add a URL to where the "Learn More" link points to when clicked.</p>';
                break;

            // case 'our_second_section':
            //     echo 'This is the second description here!';
            //     break;
            // case 'our_third_section':
            //     echo 'This is the third description here!';
            //     break;
        }
    }

    public function setup_fields() {
        $fields = array (
            array(
                'uid'          => 'our_first_field',
                'label'        => 'Promo Banner Title',
                'section'      => 'our_first_section',
                'type'         => 'text',
                'options'      => 'false',
                'placeholder'  => 'Title goes here',
                'helper'       => 'Does this text help?',
                'supplemental' => 'This text will appear in the banner.',
                'default'      => ' '
            ),
            array(
                'uid'          => 'our_second_field',
                'label'        => 'Promo text',
                'section'      => 'our_first_section',
                'type'         => 'textarea',
                'options'      => 'false',
                'placeholder'  => 'Text for banner goes here',
                'helper'       => 'Useless side text',
                'supplemental' => 'This text will appear to the right of the banner title',
                'default'      => ' '
            ),
            array(
                'uid'          => 'our_third_field',
                'label'        => 'Awesome Select',
                'section'      => 'our_first_section',
                'type'         => 'select',
                'options'      => array(
                    'yes'   => 'Chee hee!',
                    'no'    => 'Hell naw!',
                    'maybe' => 'Perhaps..'
                ),
                'placeholder'  => 'Text goes here',
                'helper'       => 'Does this text help?',
                'supplemental' => 'This text will appear in the banner.',
                'default'      => 'maybe'
            )
        );
        foreach( $fields as $field) {
            add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'promo_fields', $field['section'], $field);
            register_setting( 'promo_fields', $field['uid'] );
        }
    }

    public function field_callback( $args ) {
        $value = get_option( $args['uid'] ); //Get the current value, if there is one
        if( ! $value ) { //If no value exists
            $value = $args['default']; //Set to our default
        }

        //Check which type of field we want
        switch( $args['type'] ){
            case 'text': //If it is a text field
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $args['uid'], $args['type'], $args['placeholder'], $value );
                break;
            case 'textarea': //If it is a textarea
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" cols="50" rows="5">%3$s</textarea>', $args['uid'], $args['placeholder'], $value );
                break;
            case 'select': //If it is a select dropdown
                if( ! empty ( $args['options'] ) && is_array( $args['options'] ) ){
                    $options_markup = '';
                    foreach( $args['options'] as $key => $label){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value, $key, false ), $label );
                    }
                    printf( '<select name="%1$s" id="%1$s">%2$s</select>', $args['uid'], $options_markup );
                }
                break;
        }

        //If there is help text
        if ( $helper = $args['helper'] ){
            printf( '<span class="helper"> %s</span>', $helper); //Show it
        }

        //If there is supplemental text
        if ( $supplemental = $args['supplemental'] ){
            printf( '<p class="description">%s</p>', $supplemental ); //Show it
        }
    }
}

new Easy_Promo_Banner();
?>