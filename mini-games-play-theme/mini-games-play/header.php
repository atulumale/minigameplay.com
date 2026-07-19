<?php
/**
 * The header for the theme: sidebar + top navbar.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="overlay"></div>

<!-- ================= Sidebar ================= -->

<aside class="sidebar">

	<div class="logo">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<i class="fa-solid fa-gamepad"></i>
		<?php endif; ?>
		<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;text-decoration:none;"><?php bloginfo( 'name' ); ?></a></span>
	</div>

	<?php mgp_sidebar_menu(); ?>

</aside>

<!-- ================= MAIN ================= -->

<div class="main">

	<header class="navbar">

		<div class="left-nav">
			<button class="menu-btn" aria-label="<?php esc_attr_e( 'Toggle menu', 'minigamesplay' ); ?>">
				<i class="fa-solid fa-bars"></i>
			</button>
			<h2><?php bloginfo( 'name' ); ?></h2>
		</div>

		<div class="search-box">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" name="s" placeholder="<?php esc_attr_e( 'Search Games...', 'minigamesplay' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<input type="hidden" name="post_type" value="game">
				<button type="submit">
					<i class="fa-solid fa-magnifying-glass"></i>
				</button>
			</form>
		</div>

		<div class="right-nav">
			<button aria-label="<?php esc_attr_e( 'Favorites', 'minigamesplay' ); ?>"><i class="fa-regular fa-heart"></i></button>
			<button class="notif-bell" aria-label="<?php esc_attr_e( 'Notifications', 'minigamesplay' ); ?>"><i class="fa-regular fa-bell"></i></button>
			<div class="profile"><?php echo esc_html( is_user_logged_in() ? mb_substr( wp_get_current_user()->display_name, 0, 1 ) : 'A' ); ?></div>
		</div>

	</header>
