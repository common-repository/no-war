<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://no-war-plugin.de
 * @since      1.0.0
 *
 * @package    Nowar
 * @subpackage Nowar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nowar
 * @subpackage Nowar/admin
 * @author     nowar <noreply@no-war-plugin.de>
 */
class Nowar_Admin {
	
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	*/
	private $option_name = 'nowar_setting'; 
	
	/**
	 * Register the setting parameters
	 *
	 * @since  	1.0.0
	 * @access 	public
	*/
	public function register_nowar_plugin_settings() {
		// Add a General section
		add_settings_section(
			$this->option_name. '_general',
			__( 'General', 'nowar' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);
		// Add a radiobutton field for design
		add_settings_field(
			$this->option_name . '_design',
			__( 'Choose Design', 'nowar' ),
			array( $this, $this->option_name . '_design_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_design' )
		);
		// Add a radiobutton field for position
		add_settings_field(
			$this->option_name . '_position',
			__( 'Choose Position', 'nowar' ),
			array( $this, $this->option_name . '_position_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_position' )
		);
		// Add colorchooser Field
		add_settings_field(
			$this->option_name . '_colorcloser',
			__( 'Choose color for close icon', 'nowar' ),
			array( $this, $this->option_name . '_colorcloser_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_colorcloser' )
		);
		// Add a text field for a link
		add_settings_field(
			$this->option_name . 'link',
			__( 'Link', 'nowar' ),
			array( $this, $this->option_name . '_link_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_link' )
		);
		// Add a radio button field for link target
		add_settings_field(
			$this->option_name . '_linktarget',
			__( 'Open link in new window?', 'nowar' ),
			array( $this, $this->option_name . '_linktarget_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_linktarget' )
		);
		
		// Register the radio button field for desing
		register_setting( $this->plugin_name, $this->option_name . '_design', array( $this, $this->option_name . '_sanitize_design' ) );
		// Register the radio button field for position
		register_setting( $this->plugin_name, $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );
		// Register the colorchooser field
		register_setting( $this->plugin_name, $this->option_name . '_colorcloser', array( $this, $this->option_name . '_sanitize_colorcloser' ) );
		// Register the text link field
		register_setting( $this->plugin_name, $this->option_name . '_link', array( $this, $this->option_name . '_sanitize_link' ) );
		// Register the checkbox field for link target
		register_setting( $this->plugin_name, $this->option_name . '_linktarget', array( $this, $this->option_name . 'integer' ) );
	} 
	
	/**
	 * Render the text for the general section
	 *
	 * @since  	1.0.0
	 * @access 	public
	*/
	public function nowar_setting_general_cb() {
		echo '<p>' . __( 'Settings:', 'nowar' ) . '</p>';
	} 
		
	/**
	 * Render the colorchooser input for this plugin
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function nowar_setting_colorcloser_cb() {
		$val = get_option( $this->option_name . '_colorcloser' );
		?>
		<input type="color" name="<?php echo esc_attr($this->option_name) . '_colorcloser' ?>" id="<?php echo esc_attr($this->option_name) . '_colorcloser'?>" value="<?php echo esc_attr($val) ?>">
		<?php
	} 
	
	/**
	 * Render the radio input field for design radiobuttons option
	 *
	 * @since  1.0.0
	 * @access public
	*/
	public function nowar_setting_design_cb() {
		$val = get_option( $this->option_name . '_design' );
		?>
		<div class="admin-no-war-flags">
			<input type="radio" name="<?php echo esc_attr($this->option_name) . '_design' ?>" id="<?php echo esc_attr($this->option_name) . '_design' ?>" value="1" <?php if(!$val) echo "checked"; checked( $val, '1' ); ?>>
			<?php _e( 'Peace', 'nowar' ) ; ?>
			<br>
			<img src="<?php echo esc_attr(plugin_dir_url( __DIR__ )).'admin/img/Flagge1.svg';?>">
		</div>
		<div class="admin-no-war-flags">
			<input type="radio" name="<?php echo esc_attr($this->option_name) . '_design' ?>" value="2" <?php checked( $val, '2' ); ?>>
			<?php _e( 'STOP WAR', 'nowar' ); ?>
			<br>
			<img src="<?php echo esc_attr(plugin_dir_url( __DIR__ )).'admin/img/Flagge2.svg';?>">
		</div>
		<div class="admin-no-war-flags">
			<input type="radio" name="<?php echo esc_attr($this->option_name) . '_design' ?>" value="3" <?php checked( $val, '3' ); ?>>
			<?php _e( 'Dove', 'nowar' ); ?>
			<br>
			<img src="<?php echo esc_attr(plugin_dir_url( __DIR__ )).'admin/img/Flagge3.svg';?>">
		</div>
		<div class="admin-no-war-flags">
			<input type="radio" name="<?php echo esc_attr($this->option_name) . '_design' ?>" value="4" <?php checked( $val, '4' ); ?>>
			<?php _e( 'Peace Fingers', 'nowar' ); ?>
			<br>
			<img src="<?php echo esc_attr(plugin_dir_url( __DIR__ )).'admin/img/Flagge4.svg';?>">
		</div>	
		<?php
	}
	
	/**
	 * Render the radio input field for position radiobuttons option
	 *
	 * @since  1.0.0
	 * @access public
	*/
	public function nowar_setting_position_cb() {
		$val = get_option( $this->option_name . '_position' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo esc_attr($this->option_name) . '_position' ?>" id="<?php echo esc_attr($this->option_name) . '_position' ?>" value="1" <?php if(!$val) echo "checked"; checked( $val, '1' ); ?>>
					<?php _e( 'Right bottom corner', 'nowar' ) ; ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo esc_attr($this->option_name) . '_position' ?>" value="2" <?php checked( $val, '2' ); ?>>
					<?php _e( 'Middle on the right', 'nowar' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo esc_attr($this->option_name) . '_position' ?>" value="3" <?php checked( $val, '3' ); ?>>
					<?php _e( 'Left bottom corner', 'nowar' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo esc_attr($this->option_name) . '_position' ?>" value="4" <?php checked( $val, '4' ); ?>>
					<?php _e( 'Middle on the left', 'nowar' ); ?>
				</label>
			</fieldset>	
		<?php
	} 
	
	/**
	 * Render the link input text field for this plugin
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function nowar_setting_link_cb() {
		$val = get_option( $this->option_name . '_link' );
		?>
		<input type="text" name="<?php echo esc_attr($this->option_name) . '_link' ?>" id="<?php echo esc_attr($this->option_name) . '_link' ?>" value="<?php echo esc_url($val) ?>"><br><?php echo esc_html(__( 'Here you can insert a link which opens on click on the badge for example to a website of a charity organisation or any other link.', 'nowar' ));?>
		<br>
		<?php echo esc_html(__( 'In the setting below you can choose if you want to open the link in a new or in the same window.', 'nowar' ));?>
		<br>
		<?php echo esc_html(__( 'If you do not have a special link you can insert  https://no-war-plugin.de to support us. The link should begin with https:// or http:// ', 'nowar' ));?>
		<?php
	}
	
	/**
	 * Render the radio input field for boolean option
	 *
	 * @since  1.0.0
	 * @access public
	*/
	public function nowar_setting_linktarget_cb() {
		$val = get_option( $this->option_name . '_linktarget' );
		?>
		<input type="checkbox" name="<?php echo esc_attr($this->option_name) . '_linktarget' ?>" id="<?php echo esc_attr($this->option_name) . '_linktarget' ?>" value="1" <?php checked( $val, '1' ) ?> />
		<?php
	} 
	
	/**
	 * Include the setting page
	 *
	 * @since  1.0.0
	 * @access public
	*/
	function nowar_init(){
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		include NOWAR_PATH . 'admin/partials/nowar-admin-display.php' ;
		
	} 
	public function nowar_plugin_setup_menu(){
		add_menu_page( 'NO WAR Settings', 'NO WAR Settings', 'manage_options', 'nowar', array($this, 'nowar_init'), 'dashicons-megaphone' );
		
	} 
	

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nowar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nowar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nowar-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nowar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nowar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nowar-admin.js', array( 'jquery' ), $this->version, false );

	}

}
