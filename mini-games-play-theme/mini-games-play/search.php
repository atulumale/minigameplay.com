<?php
/**
 * Search results template.
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
		<h2>
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'minigamesplay' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h2>
	</div>

	<div class="game-grid">

		<?php if ( have_posts() ) : ?>

			<?php
			while ( have_posts() ) :
				the_post();
				if ( 'game' === get_post_type() ) {
					get_template_part( 'template-parts/game-card' );
				} else {
					?>
					<div class="game-card">
						<div class="game-info">
							<h3><a class="game-cat-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
							<a href="<?php the_permalink(); ?>"><button type="button"><?php esc_html_e( 'Read More', 'minigamesplay' ); ?></button></a>
						</div>
					</div>
					<?php
				}
			endwhile;
			?>

		<?php else : ?>

			<p class="no-games-found"><?php esc_html_e( 'No results found. Try a different search term.', 'minigamesplay' ); ?></p>

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
