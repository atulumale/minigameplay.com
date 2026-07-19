<?php
/**
 * Custom walker for the sidebar menu.
 *
 * Renders <i class="fa-solid ..."></i><span>Label</span> inside each <li>,
 * matching the original static markup. Add a Font Awesome class (e.g.
 * "fa-solid fa-house") to a menu item's CSS Classes field in
 * Appearance → Menus to control its icon.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MGP_Sidebar_Walker extends Walker_Nav_Menu {

	/**
	 * @inheritDoc
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$fa_class  = '';
		$li_classes = array();

		foreach ( $classes as $class ) {
			if ( 0 === strpos( $class, 'fa-' ) || 'fa' === $class ) {
				$fa_class .= $class . ' ';
			} else {
				$li_classes[] = $class;
			}
		}

		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$li_classes[] = 'active';
		}

		$fa_class = trim( $fa_class );
		if ( empty( $fa_class ) ) {
			$fa_class = 'fa-solid fa-gamepad';
		}

		$li_class_attr = ! empty( $li_classes ) ? ' class="' . esc_attr( implode( ' ', $li_classes ) ) . '"' : '';

		$output .= '<li' . $li_class_attr . '>';
		$output .= '<a href="' . esc_url( $item->url ) . '">';
		$output .= '<i class="' . esc_attr( $fa_class ) . '"></i>';
		$output .= '<span>' . esc_html( $item->title ) . '</span>';
		$output .= '</a>';
	}

	/**
	 * @inheritDoc
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
