<?php
/**
 * 404 error page.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="games">

	<div class="section-header">
		<h2><?php esc_html_e( '404 — Game Not Found', 'minigamesplay' ); ?></h2>
	</div>

	<p><?php esc_html_e( 'The page you were looking for could not be found. Try searching for a game instead.', 'minigamesplay' ); ?></p>

	<div class="search-box" style="max-width:400px;">
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" name="s" placeholder="<?php esc_attr_e( 'Search Games...', 'minigamesplay' ); ?>">
			<input type="hidden" name="post_type" value="game">
			<button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
		</form>
	</div>

</section>

<?php get_footer(); ?>
