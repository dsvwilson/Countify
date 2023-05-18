<?php

/*
* Plugin Name: Countify
* Plugin URI: https://countify.com/
* Description: A simple plugin that displays word data about blog posts.
* Version: 1.0
* Author: Victor Wilson
* Author URI: https://dsvwilson.com/
* License: GPLv3
* License URL: https://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: countify
*  
*/

if ( ! defined( 'ABSPATH' ) ) {
    die; // SECURITY - kill the operation if accessed directly
}

class Word_Count {
    function __construct() {
        add_action( 'admin_menu', array( $this, 'settings_setup' ) );
        add_action( 'admin_init', array( $this, 'settings') );
    }

    function settings() {
        add_settings_section( 'countify_settings_location', null, null, 'countify-settings' ); /* Adding a settings section into which we will place our settings fields identified by the slug "countify_settings_location" */
        add_settings_field( 'countify_first', 'Display Location', array($this, 'loc_HTML'), 'countify-settings', 'countify_settings_location' ); /* first setting field identified by the slug "countify_first" and displayed in "countify_settings_location" */ 
        register_setting( 'wordcount', 'countify_first', array( 'type' => 'string', 'description' => '', 'sanitize_callback' => 'sanitize_text_field', 'default' => '0' ) ); /* our call to register the setting  */
    }

    function loc_HTML() {
        ?>
            <select name="countify_first">
                <option value="0">Start of post</option>
                <option value="1">End of post</option>
            </select>
        <?php
    }

    function settings_setup() {
        add_options_page( 'Countify Settings', 'Countify Settings', 'upload_files', 'countify-settings', array( $this, 'settings_markup' ), 7 );
    }

    function settings_markup() {
        ?>
            <div class="wrap">
                <h1>Countify Settings</h1>
                <form action="options.php" method="POST"></form>
                <?php
                    settings_fields( 'wordcount' );
                    do_settings_sections( 'countify-settings' );
                    submit_button();
                ?>
            </div>
        <?php
    }
}

$Word_Count = new Word_Count();

