<?php
/**
 * Customizer Options for Flatsome Dropdown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register customizer settings for Flatsome Dropdown Plugin
 */
function flatsome_dropdown_plugin_customize_register( $wp_customize ) {

	// Add setting for "Use Classic Flatsome Dropdown Plugin"
	$wp_customize->add_setting( 'flatsome_dropdown_plugin_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'flatsome_dropdown_sanitize_checkbox',
		'capability'        => 'edit_theme_options',
	) );

	// Add control to the existing 'dropdown_style' section or similar header layout section
	// Flatsome exposes 'header_dropdown' panel or similar sections. We inject it to 'header_main' or 'header_bottom' where appropriate,
	// Usually Flatsome puts dropdown settings in `header_dropdown` section or within `header` panel. 
	// To be safe, we can add it to 'header_main' section.
	
	$section_id = $wp_customize->get_section( 'dropdown' ) ? 'dropdown' : 'header_main'; // fallbacks
	
	$wp_customize->add_control( 'flatsome_dropdown_plugin_enabled', array(
		'label'       => __( 'Enable Classic Dropdown (Plugin)', 'flatsome-dropdown' ),
		'description' => __( 'Replaces the default Flatsome mega-menu logic with the classic multi-level dropdown from the Flatsome Dropdown Plugin.', 'flatsome-dropdown' ),
		'section'     => 'header_dropdown',
		'type'        => 'checkbox',
		'priority'    => 1,
	) );
	
	// Add setting for "Dropdown Width"
	$wp_customize->add_setting( 'flatsome_dropdown_plugin_width', array(
		'default'           => 220,
		'sanitize_callback' => 'absint',
		'capability'        => 'edit_theme_options',
	) );

	$wp_customize->add_control( 'flatsome_dropdown_plugin_width', array(
		'label'       => __( 'Dropdown Width (px)', 'flatsome-dropdown' ),
		'description' => __( 'Set the minimum width of the dropdown boxes (e.g., 220 or 250).', 'flatsome-dropdown' ),
		'section'     => 'header_dropdown',
		'type'        => 'number',
		'priority'    => 2,
	) );
}
add_action( 'customize_register', 'flatsome_dropdown_plugin_customize_register', 100 );

/**
 * Sanitize checkbox
 */
function flatsome_dropdown_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}
