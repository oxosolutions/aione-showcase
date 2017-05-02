<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.sgssandhu.com
 * @since      1.0.0
 *
 * @package    Aione_Showcase
 * @subpackage Aione_Showcase/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Aione_Showcase
 * @subpackage Aione_Showcase/includes
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Showcase {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Aione_Showcase_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'aione-showcase';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
		add_shortcode( 'aione-showcase', array($this, 'aione_showcase_shortcode') );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Aione_Showcase_Loader. Orchestrates the hooks of the plugin.
	 * - Aione_Showcase_i18n. Defines internationalization functionality.
	 * - Aione_Showcase_Admin. Defines all hooks for the admin area.
	 * - Aione_Showcase_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aione-showcase-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aione-showcase-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-aione-showcase-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-aione-showcase-public.php';

		$this->loader = new Aione_Showcase_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Aione_Showcase_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Aione_Showcase_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Aione_Showcase_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Aione_Showcase_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Aione_Showcase_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	public function aione_showcase_shortcode( $atts ) {
		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
		'itemtag'     => $html5 ? 'figure'     : 'dl',
		'icontag'     => $html5 ? 'div'        : 'dt',
		'captiontag'  => $html5 ? 'figcaption' : 'dd',
		'columns'     =>  4,
		'size'        => 'medium',
		'link'        => '',
		'type'        => 'wall',
		'width'       => '100%',
		'height'      => '250px',
		'margin'      => 'yes',
		'padding'     => '15%',
		'outline'     => 'yes',
		'style'       => 'square',
		'animation'   => 'zoom',
		'transition'  => 'fade',
		'direction'   => 'bottom'
		), $attr, 'aione-showcase' );
	
		
		$type = sanitize_html_class( $atts['type'] );
		$width = $atts['width'];
		$height = $atts['height'];
		$margin = $atts['margin'];
		$padding = $atts['padding'];
		if($margin == 'yes'){ 
			$margin_class = 'margin'; $margin = '0.75%';
		}
		if($margin == 'no'){ 
			$margin_class = 'nomargin'; $margin = '0';
		}
		$outline = sanitize_html_class( $atts['outline'] );
		if($outline == 'yes'){ 
			$outline = 'outline';
		} else {
			$outline = '';
		}
		$style = sanitize_html_class( $atts['style'] );
		$animation = sanitize_html_class( $atts['animation'] );
		$transition = sanitize_html_class( $atts['transition'] );
		$direction = sanitize_html_class( $atts['direction'] );
		$itemtag = tag_escape( $atts['itemtag'] );
		$captiontag = tag_escape( $atts['captiontag'] );
		$icontag = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}
		$columns = intval( $atts['columns'] );
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$itemheight = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';
		$selector = "gallery-{$instance}";
		$gallery_style = '';
		
		$size_class = sanitize_html_class( $atts['size'] );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} {$style} {$margin_class} {$outline} animation-{$animation} transition-{$transition}-{$direction}'>";
		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );
		$i = 0;
		
		$args = array(
			'post_type' => 'aione-showcase',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			
		);
		$query = new WP_Query( $args );
		
		$total = $query->post_count;
		$posts = $query->posts;
		
		foreach($posts as $post){
			$i++;
			
			$saved_link = get_post_meta($post->ID,'_aione_showcase_link',true);
			$image_output = wp_get_attachment_link( get_post_thumbnail_id($post->ID), $atts['size'], true, false, false, $attr );
			$image_meta  = wp_get_attachment_metadata( get_post_thumbnail_id($post->ID) );
			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				if ( $image_meta['height'] == $image_meta['width'] ) {
					$orientation = 'square';
				} elseif( $image_meta['height'] > $image_meta['width'] ){
					$orientation = 'portrait';
				} else {
					$orientation = 'landscape';
				}
			}
			$itemtag_class = '';
			if ( $columns > 0 && $i % $columns == 0 ) {
				$itemtag_class = 'last-item';
			}
		
			$output .= "<{$itemtag} id='gallery_item_{$i}' class='gallery-item {$itemtag_class}'>";
			$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
			$image_output
			</{$icontag}>";	
			if ( $captiontag ) {
				$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				<span class='title-m'>" . wptexturize($attachment->post_title) . "</span>
				<span class='excerpt-m'>" . wptexturize($attachment->post_excerpt) . "</span>
				</{$captiontag}>";
			}	
			
			$output .= "<a style='position:absolute;z-index:22;bottom:0;' href='http://".$saved_link."'>".$post->post_title."</a>";
			
			$output .= "</{$itemtag}>";
			
			
			/*echo "<div style='border:1px solid;padding:10px;margin:10px'>";
			echo "Post Title: ".$post->post_title."<br/>";
			echo "Post Content: ".$post->post_content."<br/>";
			echo "Showcase Link: ".$saved_link."<br/>";
			echo "Image: ".$featured_image."<br/>";
			echo "</div>";*/
		}
		return $output;
	}	

}
