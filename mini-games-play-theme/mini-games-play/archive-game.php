<?php
/**
 * Archive template for the "game" custom post type: /games/
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
		<h2><?php post_type_archive_title(); ?></h2>
	</div>

	<div class="game-grid">

		<?php if ( have_posts() ) : ?>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/game-card' );
			endwhile;
			?>

		<?php else : ?>

			<p class="no-games-found"><?php esc_html_e( 'No games found yet. Check back soon!', 'minigamesplay' ); ?></p>

		<?php endif; ?>

	</div>

	<div class="pagination-wrap">
		<?php
		echo wp_kses_post(
			paginate_links(
				array(
					'prev_text' => __( '&laquo; Prev', 'minigamesplay' ),
					'next_text' => __( 'Next &raquo;', 'minigamesplay' ),
				)
			)
		);
		?>
	</div>

</section>

<?php get_footer(); ?>
