<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.sgssandhu.com
 * @since      1.0.0
 *
 * @package    Aione_Showcase
 * @subpackage Aione_Showcase/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aione_Showcase
 * @subpackage Aione_Showcase/admin
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Showcase_Admin {

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
		
		add_action( 'init', array( $this, 'register_showcase_post_type' ) );
		
		add_action( 'admin_menu', array( $this, 'aione_showcase_admin_menu_hook' ) );
		
		// Add meta box to Aione Showcase Post type 
		add_action('add_meta_boxes',  array($this, 'aione_showcase_meta_box'));
		
		// Save meta box values into database.
		add_action('save_post', array($this,'save_aione_showcase_meta_box'));
		
		// Call Function to store value into database.
		add_action('init', array($this, 'aione_showcase_settings_save'));

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
		 * defined in Aione_Showcase_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aione_Showcase_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aione-showcase-admin.css', array(), $this->version, 'all' );

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
		 * defined in Aione_Showcase_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aione_Showcase_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aione-showcase-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	// Register Custom Post Type
	function register_showcase_post_type() {
		$labels = array(
			'name'               => _x( 'Aione Showcase', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Aione Showcase', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Aione Showcase', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Aione Showcase', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Showcase', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Showcase', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Showcase', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Showcase', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Showcase', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Showcase:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No Showcase found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No Showcase found in Trash.', 'your-plugin-textdomain' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'your-plugin-textdomain' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'aione-showcase' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments','revisions' )
		);

		register_post_type( 'aione-showcase', $args );


	} //register_app_pages_post_type
	
	function aione_showcase_admin_menu_hook(){
		$page = 'add_submenu_page';
		// Settings
            $page(
				__('edit.php?post_type=aione-showcase', 'aione-showcase'),
				__('Settings', 'aione-showcase'),
				__('Settings', 'aione-showcase'),
				__('manage_options', 'aione-showcase'),
				__('aione-showcase-settings', 'aione-showcase'),
				array($this,'aione_showcase_settings')
			);
	}
	
	//Function for Content in the metabox for Aione Showcase
	function aione_showcase_meta_box(){
		add_meta_box(
		   'aione_showcase_meta_box',		// $id
		   'Showcase Link',                  					// $title
		   array($this,'aione_showcase_meta_box_content'),		// $callback
		   'aione-showcase',											// $page
		   'normal',                  // $context
		   'high'                     // $priority
	   );
	}
	
	function aione_showcase_meta_box_content(){
		global $post;
		$output = "";
		
		$saved_link = get_post_meta($post->ID,'_aione_showcase_link',true);
		$output .= "<input type='text' name='aione_showcase_link' value='".$saved_link."' size='100'>";
		echo $output;
	}
	
	function save_aione_showcase_meta_box(){
	  global $post;
	  
      // OK, we're authenticated: we need to find and save the data
      $aione_showcase_link = $_POST['aione_showcase_link']; 
		
      // save data in INVISIBLE custom field (note the "_" prefixing the custom fields' name
	   update_post_meta($post->ID, '_aione_showcase_link', $aione_showcase_link); 
	  
    }
	
	function aione_showcase_settings(){
		global $wpdb;
		$aione_showcase_style = get_option('aione_showcase_style');
		?>
		<div class="wrap">
			<h2>Showcase Settings</h2>
			<div class="">
				<form name="" class="" id="" method="post" action="" enctype="multipart/form-data">
				<table class="form-table">
				<tbody>
				<th scope="row"><label for="aione_showcase_style">Style</label></th>
				<td><select name="aione_showcase_style">
				<option value="">--- Select Style ---</option>
				<option value="desktop" <?php if($aione_showcase_style == "desktop"){echo 'selected="selected"';} ?> >Desktop</option>
				<option value="mobile" <?php if($aione_showcase_style == "mobile"){echo 'selected="selected"';} ?>>Mobile</option>
				<option value="fullscreen" <?php if($aione_showcase_style == "fullscreen"){echo 'selected="selected"';} ?>>Fullscreen</option>
				</select></td>
				</tr>
				</tbody></table>
				<p class="submit"><input type="submit" id="submit_button" name="aione_showcase_style_save" class="button button-primary" value="Save Settings"></p>
				</form>
			</div>
		</div>
		<?php
	}
	
	function aione_showcase_settings_save(){
		if(isset($_POST['aione_showcase_style_save'])){
			$aione_showcase_style=$_POST['aione_showcase_style'];
			
			update_option('aione_showcase_style', $aione_showcase_style);
		}
	}
}
