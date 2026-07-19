<?php
/**
 * Theme Customizer settings — hero content, site logo text, footer text.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add customizer sections, settings, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function mgp_customize_register( $wp_customize ) {

	// ---- Hero section ----
	$wp_customize->add_section(
		'mgp_hero_section',
		array(
			'title'    => __( 'Hero Section', 'minigamesplay' ),
			'priority' => 30,
		)
	);

	$hero_fields = array(
		'mgp_hero_badge'       => __( '🔥 Trending Platform', 'minigamesplay' ),
		'mgp_hero_heading'     => __( 'Play Thousands of Free Online Games', 'minigamesplay' ),
		'mgp_hero_text'        => __( 'Discover amazing Puzzle, Racing, Arcade, Sports and Action games. No downloads. Play instantly. Any device. Anytime.', 'minigamesplay' ),
		'mgp_hero_btn1_text'   => __( 'Play Now', 'minigamesplay' ),
		'mgp_hero_btn1_url'    => '#',
		'mgp_hero_btn2_text'   => __( 'Explore Games', 'minigamesplay' ),
		'mgp_hero_btn2_url'    => '#',
	);

	foreach ( $hero_fields as $setting => $default ) {
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $default,
				'sanitize_callback' => ( false !== strpos( $setting, 'url' ) ) ? 'esc_url_raw' : 'sanitize_text_field',
			)
		);

		$control_type = ( false !== strpos( $setting, 'text' ) && 'mgp_hero_text' === $setting ) ? 'textarea' : 'text';

		$wp_customize->add_control(
			$setting,
			array(
				'label'   => ucwords( str_replace( array( 'mgp_hero_', '_' ), array( '', ' ' ), $setting ) ),
				'section' => 'mgp_hero_section',
				'type'    => $control_type,
			)
		);
	}

	$wp_customize->add_setting(
		'mgp_hero_image',
		array(
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'mgp_hero_image',
			array(
				'label'   => __( 'Hero Image', 'minigamesplay' ),
				'section' => 'mgp_hero_section',
			)
		)
	);

	// ---- Featured banner ----
	$wp_customize->add_section(
		'mgp_banner_section',
		array(
			'title'    => __( 'Featured Banner', 'minigamesplay' ),
			'priority' => 31,
		)
	);

	$banner_fields = array(
		'mgp_banner_badge'   => __( 'FEATURED GAME', 'minigamesplay' ),
		'mgp_banner_heading' => __( 'Play the Best HTML5 Games for Free', 'minigamesplay' ),
		'mgp_banner_text'    => __( 'Enjoy thousands of free online games without downloading. Action, Puzzle, Racing, Sports, Arcade and many more.', 'minigamesplay' ),
		'mgp_banner_btn_text'=> __( 'Start Playing', 'minigamesplay' ),
		'mgp_banner_btn_url' => '#',
	);

	foreach ( $banner_fields as $setting => $default ) {
		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $default,
				'sanitize_callback' => ( false !== strpos( $setting, 'url' ) ) ? 'esc_url_raw' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$setting,
			array(
				'label'   => ucwords( str_replace( array( 'mgp_banner_', '_' ), array( '', ' ' ), $setting ) ),
				'section' => 'mgp_banner_section',
				'type'    => ( 'mgp_banner_text' === $setting ) ? 'textarea' : 'text',
			)
		);
	}

	// ---- Footer ----
	$wp_customize->add_section(
		'mgp_footer_section',
		array(
			'title'    => __( 'Footer', 'minigamesplay' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_setting(
		'mgp_footer_about',
		array(
			'default'           => __( 'Play thousands of free online HTML5 games directly in your browser. No Download. No Installation. Just Play.', 'minigamesplay' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'mgp_footer_about',
		array(
			'label'   => __( 'Footer About Text', 'minigamesplay' ),
			'section' => 'mgp_footer_section',
			'type'    => 'textarea',
		)
	);

	foreach ( array( 'facebook', 'instagram', 'x-twitter', 'youtube', 'discord' ) as $network ) {
		$wp_customize->add_setting(
			'mgp_social_' . $network,
			array(
				'default'           => '#',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'mgp_social_' . $network,
			array(
				'label'   => ucfirst( str_replace( '-', ' ', $network ) ) . ' ' . __( 'URL', 'minigamesplay' ),
				'section' => 'mgp_footer_section',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'mgp_customize_register' );
