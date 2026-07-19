<?php
/**
 * Taxonomy archive for game_list terms (Trending / Popular / New),
 * used to build the "View All" pages linked from the homepage rows.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$term = get_queried_object();
?>

<section class="games">

	<div class="section-header">
		<h2><?php echo esc_html( $term->name ); ?></h2>
	</div>

	<?php if ( ! empty( $term->description ) ) : ?>
		<p><?php echo wp_kses_post( $term->description ); ?></p>
	<?php endif; ?>

	<div class="game-grid">

		<?php if ( have_posts() ) : ?>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/game-card' );
			endwhile;
			?>

		<?php else : ?>

			<p class="no-games-found"><?php esc_html_e( 'No games in this category yet.', 'minigamesplay' ); ?></p>

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
