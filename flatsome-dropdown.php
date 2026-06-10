<?php
/**
 * Plugin Name: Flatsome Dropdown Plugin
 * Plugin URI:  https://wolinka.com.tr
 * Description: A lightweight plugin that replaces Flatsome's default mega menu with a classic, multi-level dropdown.
 * Version:     1.0.0
 * Author:      Wolinka
 * Text Domain: flatsome-dropdown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'FLATSOME_DROPDOWN_VERSION', '1.0.0' );
define( 'FLATSOME_DROPDOWN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FLATSOME_DROPDOWN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main Class for Flatsome Dropdown
 */
class Flatsome_Dropdown_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Hook into plugins_loaded to safely check active theme and init.
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize plugin
	 */
	public function init() {
		// Check if Flatsome is active
		$theme = wp_get_theme();
		if ( 'Flatsome' !== $theme->name && 'Flatsome' !== $theme->parent_theme ) {
			add_action( 'admin_notices', array( $this, 'flatsome_missing_notice' ) );
			return;
		}

		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include necessary files
	 */
	private function includes() {
		require_once FLATSOME_DROPDOWN_DIR . 'includes/class-flatsome-dropdown-walker.php';
		require_once FLATSOME_DROPDOWN_DIR . 'includes/customizer-options.php';
	}

	/**
	 * Initialize WordPress Hooks
	 */
	private function init_hooks() {
		// Enqueue Scripts and Styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 100 );

		// Filter wp_nav_menu args to inject our custom walker
		add_filter( 'wp_nav_menu_args', array( $this, 'filter_nav_menu_args' ), 999 );
		
		// Render dynamic Customizer CSS
		add_action( 'wp_head', array( $this, 'render_dynamic_css' ), 100 );
	}

	/**
	 * Admin Notice if Flatsome is not active
	 */
	public function flatsome_missing_notice() {
		?>
		<div class="notice notice-error is-dismissible">
			<p><strong>Flatsome Dropdown Plugin:</strong> The Flatsome theme is missing. Please install and activate Flatsome to use this plugin.</p>
		</div>
		<?php
	}

	/**
	 * Enqueue Assets
	 */
	public function enqueue_assets() {
		// Enqueue CSS
		wp_enqueue_style(
			'flatsome-dropdown-css',
			FLATSOME_DROPDOWN_URL . 'assets/css/flatsome-dropdown.css',
			array(), // Load independently
			FLATSOME_DROPDOWN_VERSION
		);

		// Enqueue JS
		wp_enqueue_script(
			'flatsome-dropdown-js',
			FLATSOME_DROPDOWN_URL . 'assets/js/flatsome-dropdown.js',
			array( 'jquery' ),
			FLATSOME_DROPDOWN_VERSION,
			true // Load in footer
		);
	}

	/**
	 * Inject custom Walker into menu args if it's a dropdown location inside Flatsome
	 * Flatsome uses specific wrappers for menu locations.
	 */
	public function filter_nav_menu_args( $args ) {
		// Apply our custom walker to any menu location natively registered by Flatsome
		// Primary, secondary, top_bar, etc. 
		$is_enabled = get_theme_mod( 'flatsome_dropdown_plugin_enabled', true );
		if ( ! $is_enabled ) {
			return $args;
		}

		// DO NOT override Flatsome's native mobile/accordion menu walkers!
		if ( isset( $args['walker'] ) && is_a( $args['walker'], 'FlatsomeNavSidebar' ) ) {
			return $args;
		}
		
		// Also skip if theme location explicitly contains 'mobile' or 'vertical'
		if ( isset( $args['theme_location'] ) && ( strpos( $args['theme_location'], 'mobile' ) !== false || strpos( $args['theme_location'], 'vertical' ) !== false ) ) {
			return $args;
		}

		$args['walker'] = new Flatsome_Dropdown_Walker();

		return $args;
	}

	/**
	 * Sanitize color properly for CSS properties (HEX and RGBA allowed)
	 */
	public function sanitize_color( $color ) {
		if ( empty( $color ) ) {
			return '';
		}

		$color = trim( $color );

		// Return HEX if valid
		$hex = sanitize_hex_color( $color );
		if ( $hex ) {
			return $hex;
		}

		// Check if it's RGBA or RGB
		if ( preg_match( '/^rgba?\(\s*\d+\s*,\s*\d+\s*,\s*\d+\s*(?:,\s*[\d\.]+\s*)?\)$/i', $color ) ) {
			return $color;
		}

		return 'transparent'; // Fallback
	}

	/**
	 * Render dynamic CSS using Flatsome's get_theme_mod variables
	 */
	public function render_dynamic_css() {
		$is_enabled = get_theme_mod( 'flatsome_dropdown_plugin_enabled', true );
		if ( ! $is_enabled ) {
			return;
		}

		// Read Flatsome Native Customizer variables
		$bg_color       = $this->sanitize_color( get_theme_mod( 'dropdown_bg', '#fff' ) );
		$border_color   = $this->sanitize_color( get_theme_mod( 'dropdown_border', '#ddd' ) );
		$border_radius  = get_theme_mod( 'dropdown_radius', '0px' );
		$font_size      = get_theme_mod( 'dropdown_nav_size', '100' );

		// Booleans for Border and Shadow
		$has_border     = get_theme_mod( 'dropdown_border_enabled', 1 );
		$has_shadow     = get_theme_mod( 'dropdown_shadow', 1 );

		// Read Text Design
		$text_color_scheme = get_theme_mod( 'dropdown_text', 'light' );
		$text_style        = get_theme_mod( 'dropdown_text_style', 'simple' );

		// Read our custom Width Setting
		$width = get_theme_mod( 'flatsome_dropdown_plugin_width', 220 );
		
		// Generate CSS (Hardcoded values are safe from injection)
		$li_border  = $has_border ? '1px solid ' . $border_color : 'none';
		$box_shadow = $has_shadow ? '0 4px 10px rgba(0,0,0,0.1)' : 'none';
		
		$link_color     = ( $text_color_scheme === 'dark' ) ? '#fff' : '#333';
		$hover_bg       = ( $text_color_scheme === 'dark' ) ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.03)';
		$link_transform = ( $text_style === 'uppercase' ) ? 'uppercase' : 'none';

		?>
		<style id="flatsome-dropdown-customizer-css">
			/* Flatsome Dropdown Plugin - User Settings */
			.flatsome-classic-dropdown ul.sub-menu {
				background-color: <?php echo esc_attr( $bg_color ); ?>;
				border-radius: <?php echo esc_attr( $border_radius ); ?>;
				font-size: <?php echo absint( $font_size ); ?>%;
				box-shadow: <?php echo esc_attr( $box_shadow ); ?>;
				min-width: <?php echo absint( $width ); ?>px;
			}

			.flatsome-classic-dropdown ul.sub-menu li {
				border-bottom: <?php echo esc_attr( $li_border ); ?>;
			}
			
			.flatsome-classic-dropdown ul.sub-menu li a {
				color: <?php echo esc_attr( $link_color ); ?> !important;
				text-transform: <?php echo esc_attr( $link_transform ); ?> !important;
			}
			
			.flatsome-classic-dropdown ul.sub-menu li a:hover {
				background-color: <?php echo esc_attr( $hover_bg ); ?> !important;
			}
		</style>
		<?php
	}
}

// Init Plugin
new Flatsome_Dropdown_Plugin();
