<?php
/* Plugin Name: Countdown Ticker
Author URI: http://ronan-oleary.com/
Description: Simple countdown ticker plugin
Version: 1.0
Author: Ronan O'Leary
Author URI: http://ronan-oleary.com/
License: GPL
*/


function ticker_activation() {

    // Add your db tables or whatever, here
    
}

register_activation_hook(__FILE__, 'ticker_activation');

function ticker_deactivation() {

    
}

register_deactivation_hook(__FILE__, 'ticker_deactivation');


function ticker_scripts() {
    
    // Enqueue script and localise, so as to pass vars in from control panel
    //wp_enqueue_script( 'countdown', plugin_dir_url( __FILE__ ) . 'js/jquery.countdown.min.js', array(), true );
	wp_enqueue_script( 'ticker', plugin_dir_url( __FILE__ ) . 'js/ticker.js', array(), false, true );
    $settings = (array) get_option( 'ticker_settings' );
	wp_localize_script('ticker', 'ticker_vars', array(
            'title' => $settings['title'],
            'leadtext' => $settings['leadtext'],
            'date' => $settings['date'],
            'time' => $settings['time']
        )
    );	
}


add_action( 'init', 'ticker_scripts' );


function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=ticker">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );


/*-------------------------------------------------------------------------------------------*/
/* Add Options Panel */
/*-------------------------------------------------------------------------------------------*/

// Calls set up menu function

add_action('admin_menu', 'ticker_setup_menu');
 
function ticker_setup_menu(){
    // location ( Name, Title, Capabilities, Slug, Callback to create form)
    add_options_page( 'Ticker', 'Countdown Ticker Settings', 'manage_options', 'ticker', 'ticker_init' );
    //add_submenu_page( 'edit.php?post_type=social-vote', 'Social Vote Options', 'ticker', 'manage_options', 'social-vote');
}

/* Register Settings */
add_action( 'admin_init', 'ticker_settings' );
 

function ticker_settings() {
    
    //register our settings
    register_setting( 'ticker-settings-group', 'ticker_settings' );

    // Add a Section (logical grouping of fields)
    add_settings_section( 'section-one', 'Populate Ticker', 'section_one_callback', 'ticker' );
    
        // Add actual fields
        // (name, label, callback (to create field), menu slug, section to be added to)
        add_settings_field( 'title', 'Title', 'title_callback', 'ticker', 'section-one' );
        add_settings_field( 'leadtext', 'Lead Text', 'lt_callback', 'ticker', 'section-one' );
        add_settings_field( 'date', 'Date Field', 'date_field', 'ticker', 'section-one' );
        add_settings_field( 'time', 'Time Field', 'time_field', 'ticker', 'section-one' );
    
}


/*-------------------------------------------------------------------------------------------*/
/* Callback to output help text below section title */
/*-------------------------------------------------------------------------------------------*/

function section_one_callback() {
    echo 'Add title, leadtext and select date/time until the expiry time.';
}


/*-------------------------------------------------------------------------------------------*/
/* Callbacks to render the plugin form fields for section one */
/*-------------------------------------------------------------------------------------------*/

function title_callback() {
    $settings = (array) get_option( 'ticker_settings' );
    $title = esc_attr( $settings['title'] );
    echo "<input type='text' name='ticker_settings[title]' value='$title' />";
}

function lt_callback() {
    $settings = (array) get_option( 'ticker_settings' );
    $leadtext = esc_attr( $settings['leadtext'] );
    echo "<input type='text' name='ticker_settings[leadtext]' value='$leadtext' />";
}

function date_field() {
    $settings = (array) get_option( 'ticker_settings' );
    $date = esc_attr( $settings['date'] );
    echo "<input type='date' name='ticker_settings[date]' value='$date' />";
}

function time_field() {
    $settings = (array) get_option( 'ticker_settings' );
    $time = esc_attr( $settings['time'] );
    echo "<input type='time' name='ticker_settings[time]' value='$time' />";
}



/*-------------------------------------------------------------------------------------------*/
/* Render Publish Form  */
/*-------------------------------------------------------------------------------------------*/


function ticker_init(){
?>
<div class="wrap">
    <h2>Ticker Options</h2>
    <form method="post" action="options.php">
        <!-- Calls the settings field set up in 'Register Settings' -->
        <?php settings_fields( 'ticker-settings-group' ); ?>
        <!-- Do sections to out the sections bound to the menu slug -->
        <?php do_settings_sections( 'ticker' ); ?>
        <!-- Submit button -->
        <?php submit_button(); ?>
    </form>
</div>

<?php }; 


/*-------------------------------------------------------------------------------------------*/
/* Output Shortcode Type */
/*-------------------------------------------------------------------------------------------*/


function ticker_shortcode( $atts, $content = null ) {
    $settings = (array) get_option( 'ticker_settings' );
       extract( shortcode_atts( array(
          'title' => $settings['title'],
          'leadtext' => $settings['leadtext'],
          'time' => $settings['time'],
          'date' => $settings['date'],
          ), $atts ) );
     
        $output .= '<div class="text-block">';
        $output .= '<h2 class="text-center">' . $title . '</h2>';
        $output .= '<h4 class="text-center">' . $leadtext . '</h4>';
        $output .= '<span class="ticker-plugin"></span>';
        $output .= '</div>';
        
        return $output;
    }

add_shortcode('ticker', 'ticker_shortcode');

?>