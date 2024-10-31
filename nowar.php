<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://no-war-plugin.de
 * @since             1.0.0
 * @package           Nowar
 *
 * @wordpress-plugin
 * Plugin Name:       NO WAR
 * Plugin URI:        https://no-war-plugin.de
 * Description:       The NO WAR plugin shows a small badge on your website. You can change the position, design and color of the close icon in NO WAR Settings in your WordPress Admin Menu.  
 * Version:           1.0.2
 * Author:            nowar
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nowar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NOWAR_VERSION', '1.0.2' );
!defined('NOWAR_PATH') && define('NOWAR_PATH', plugin_dir_path( __FILE__ )); 
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nowar-activator.php
 */
function activate_nowar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nowar-activator.php';
	Nowar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nowar-deactivator.php
 */
function deactivate_nowar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nowar-deactivator.php';
	Nowar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nowar' );
register_deactivation_hook( __FILE__, 'deactivate_nowar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nowar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nowar() {

	$plugin = new Nowar();
	$plugin->run();

}
run_nowar();

function nowar_show_flag() {
    if (is_admin()) {
        return;
    }
    $show = false;
    if (isset($_GET['nowar']) && $_GET['nowar'] == "true") {
        setcookie("nowar", "true");
        $show = true;
    }
    if (!isset($_COOKIE["nowar"]) && !$show) {
        add_action("wp_footer", "nowar_ad_flag");
    }
}

function nowar_ad_flag(){
    $pluginPath = plugins_url() . '/no-war/';
    $num = get_option( 'nowar_setting_design' );
    if ($num == "") {
        $num = 1;
    }
    $nowar_flag = "Flagge".$num.".svg";
	
	$flag_position = get_option( 'nowar_setting_position' );
    if ($flag_position == "") {
        $flag_position = "flagholder-position-1";
    }
    $flag_position = "flagholder-position-".$flag_position;
	
	
    $close_color_fill = get_option( 'nowar_setting_colorcloser' );
    if ($close_color_fill == "") {
        $close_color_fill = "#000000";
    }
	
	$linktarget = get_option( 'nowar_setting_linktarget' );
    if ($linktarget == "1") {
        $linktarget = " target='_blank'";
    }else{
		$linktarget = "";
	}
	
	$nowar_link = get_option( 'nowar_setting_link' );
	$nowar_image_link = "<a href='".$nowar_link."'".$linktarget."><img src=". $pluginPath ."public/img/". $nowar_flag ."></a>";
	if ($nowar_link == "") {
        $nowar_image_link = "<img src=". $pluginPath ."public/img/". $nowar_flag .">";
    }
	
    echo "<div class='nowar-flagHolder ".$flag_position."'>
        <div class='nowar-redirect'>".$nowar_image_link."</div>
		<div onclick='NoWarUpdateStatus()' class='nowar-closerholder' title='Close'>
			<span class='nowar-closer'>
			<svg width='24px' height='24px' viewBox='0 0 24 24' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
				<title>close</title>
				<g id='close' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
					<g id='np_close_546124_000000' transform='translate(3.000000, 3.000000)' fill='". $close_color_fill ."' fill-rule='nonzero'>
						<path d='M9,0 C4.0398,0 0,4.0398 0,9 C0,13.9602 4.0204,18 9,18 C13.9602,18 18,13.9796 18,9 C18,4.0204 13.9602,0 9,0 Z M9,16.4796 C4.8796,16.4796 1.5204,13.1194 1.5204,9 C1.5204,4.8796 4.8798,1.5398 9,1.5398 C13.1202,1.5398 16.4796,4.8796 16.4796,9 C16.4796,13.1204 13.1202,16.4796 9,16.4796 Z M12.2398,5.76 C11.9398,5.46 11.46012,5.46 11.16012,5.76 L8.99992,7.9202 L6.83972,5.76 C6.53972,5.46 6.06004,5.46 5.76004,5.76 C5.46004,6.06 5.46004,6.53968 5.76004,6.83968 L7.92024,8.99988 L5.76004,11.16008 C5.46004,11.46008 5.46004,11.93976 5.76004,12.23976 C6.06004,12.53976 6.53972,12.53976 6.83972,12.23976 L8.99992,10.07956 L11.16012,12.23976 C11.46012,12.53976 11.9398,12.53976 12.2398,12.23976 C12.5398,11.93976 12.5398,11.46008 12.2398,11.16008 L10.0796,8.99988 L12.2398,6.83968 C12.5398,6.53968 12.5398,6.06 12.2398,5.76 Z' id='Shape'></path>
					</g>
				</g>
			</svg>
			</span>
		</div>
    </div>";
}

add_action( 'init', 'nowar_show_flag' );