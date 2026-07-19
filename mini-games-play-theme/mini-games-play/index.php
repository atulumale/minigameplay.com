<?php
/**
 * The default template: blog posts index.
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
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} else {
				esc_html_e( 'Latest Posts', 'minigamesplay' );
			}
			?>
		</h2>
	</div>

	<div class="game-grid">

		<?php if ( have_posts() ) : ?>

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<div class="game-card">
					<div class="thumb">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'mgp-game-thumb' ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( MGP_THEME_URI . '/images/placeholder-game.jpg' ); ?>" alt="<?php the_title_attribute(); ?>">
							<?php endif; ?>
						</a>
					</div>
					<div class="game-info">
						<h3><a class="game-cat-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( get_the_date() ); ?></p>
						<p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
						<a href="<?php the_permalink(); ?>"><button type="button"><?php esc_html_e( 'Read More', 'minigamesplay' ); ?></button></a>
					</div>
				</div>
			<?php endwhile; ?>

		<?php else : ?>

			<p class="no-games-found"><?php esc_html_e( 'Nothing found.', 'minigamesplay' ); ?></p>

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
