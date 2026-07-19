<?php
/**
 * Mini Games Play theme functions.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MGP_THEME_VERSION', '1.0.0' );
define( 'MGP_THEME_DIR', get_template_directory() );
define( 'MGP_THEME_URI', get_template_directory_uri() );

/**
 * Theme setup: supports, menus, thumbnails.
 */
function mgp_setup() {

	load_theme_textdomain( 'minigamesplay', MGP_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 60,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	set_post_thumbnail_size( 500, 320, true );
	add_image_size( 'mgp-game-thumb', 500, 320, true );
	add_image_size( 'mgp-hero', 900, 900, false );

	register_nav_menus(
		array(
			'sidebar' => __( 'Sidebar Menu', 'minigamesplay' ),
			'footer-categories' => __( 'Footer: Categories', 'minigamesplay' ),
			'footer-links'       => __( 'Footer: Quick Links', 'minigamesplay' ),
		)
	);
}
add_action( 'after_setup_theme', 'mgp_setup' );

/**
 * Enqueue styles and scripts.
 */
function mgp_enqueue_assets() {

	wp_enqueue_style( 'mgp-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'mgp-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css', array(), '6.7.1' );
	wp_enqueue_style( 'minigamesplay-style', get_stylesheet_uri(), array(), MGP_THEME_VERSION );

	wp_enqueue_script( 'minigamesplay-script', MGP_THEME_URI . '/js/theme.js', array(), MGP_THEME_VERSION, true );

	wp_localize_script(
		'minigamesplay-script',
		'mgpData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'mgp_nonce' ),
		)
	);

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mgp_enqueue_assets' );

/**
 * Register widget areas (used on the sidebar for future extensibility,
 * and a footer area for widgets on top of the menu-driven footer columns).
 */
function mgp_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer Widgets', 'minigamesplay' ),
			'id'            => 'footer-widgets',
			'description'   => __( 'Appears in the footer, next to the Categories and Quick Links columns.', 'minigamesplay' ),
			'before_widget' => '<div class="footer-column %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'mgp_widgets_init' );

/** Custom post type, taxonomies, and meta box. */
require_once MGP_THEME_DIR . '/inc/cpt-game.php';

/** Customizer settings (hero, banner, footer). */
require_once MGP_THEME_DIR . '/inc/customizer.php';

/** Sidebar menu walker (renders Font Awesome icons). */
require_once MGP_THEME_DIR . '/inc/class-mgp-sidebar-walker.php';

/** Template helper functions used across template-parts. */
require_once MGP_THEME_DIR . '/inc/template-helpers.php';

/**
 * Fallback sidebar menu, used when no "Sidebar Menu" is assigned yet in
 * Appearance → Menus, so the theme still looks complete out of the box.
 */
function mgp_sidebar_menu_fallback() {

	$items = array(
		array( 'label' => __( 'Home', 'minigamesplay' ), 'icon' => 'fa-solid fa-house', 'url' => home_url( '/' ) ),
		array( 'label' => __( 'Trending', 'minigamesplay' ), 'icon' => 'fa-solid fa-fire', 'url' => home_url( '/?game_list=trending' ) ),
		array( 'label' => __( 'Popular', 'minigamesplay' ), 'icon' => 'fa-solid fa-star', 'url' => home_url( '/?game_list=popular' ) ),
		array( 'label' => __( 'Recently Played', 'minigamesplay' ), 'icon' => 'fa-solid fa-clock-rotate-left', 'url' => '#' ),
	);

	$categories = get_terms(
		array(
			'taxonomy'   => 'game_category',
			'hide_empty' => false,
		)
	);

	$icon_map = array(
		'action'      => 'fa-solid fa-bolt',
		'puzzle'      => 'fa-solid fa-puzzle-piece',
		'racing'      => 'fa-solid fa-car',
		'sports'      => 'fa-solid fa-futbol',
		'arcade'      => 'fa-solid fa-ghost',
		'multiplayer' => 'fa-solid fa-users',
		'brain-games' => 'fa-solid fa-brain',
	);

	if ( ! is_wp_error( $categories ) ) {
		foreach ( $categories as $category ) {
			$items[] = array(
				'label' => $category->name,
				'icon'  => isset( $icon_map[ $category->slug ] ) ? $icon_map[ $category->slug ] : 'fa-solid fa-gamepad',
				'url'   => get_term_link( $category ),
			);
		}
	}

	echo '<ul class="menu">';
	foreach ( $items as $index => $item ) {
		printf(
			'<li%3$s><a href="%1$s"><i class="%4$s"></i><span>%2$s</span></a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] ),
			( 0 === $index ) ? ' class="active"' : '',
			esc_attr( $item['icon'] )
		);
	}
	echo '</ul>';
}

/**
 * Print the sidebar menu, preferring an assigned "sidebar" nav menu.
 */
function mgp_sidebar_menu() {

	if ( has_nav_menu( 'sidebar' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'sidebar',
				'container'      => false,
				'items_wrap'     => '<ul class="menu">%3$s</ul>',
				'walker'         => new MGP_Sidebar_Walker(),
			)
		);
	} else {
		mgp_sidebar_menu_fallback();
	}
}

/**
 * Excerpt length for game cards / archives.
 */
function mgp_custom_excerpt_length( $length ) {
	return is_post_type_archive( 'game' ) || is_tax( array( 'game_category', 'game_list' ) ) ? 12 : $length;
}
add_filter( 'excerpt_length', 'mgp_custom_excerpt_length' );
