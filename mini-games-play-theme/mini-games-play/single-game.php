<?php
/**
 * Single game template: embeds the playable game and lists related games.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$embed_url = get_post_meta( get_the_ID(), '_game_embed_url', true );
	$category  = mgp_get_primary_category_name( get_the_ID() );
	$terms     = get_the_terms( get_the_ID(), 'game_category' );
	?>

	<section class="games">

		<div class="section-header">
			<h2><?php the_title(); ?></h2>
			<?php if ( $category ) : ?>
				<span class="badge"><?php echo esc_html( $category ); ?></span>
			<?php endif; ?>
		</div>

		<?php if ( $embed_url ) : ?>
			<div class="game-play-frame" style="width:100%;aspect-ratio:16/9;border-radius:16px;overflow:hidden;background:#000;">
				<iframe
					src="<?php echo esc_url( $embed_url ); ?>"
					title="<?php the_title_attribute(); ?>"
					style="width:100%;height:100%;border:0;"
					allow="fullscreen; gamepad"
					allowfullscreen>
				</iframe>
			</div>
		<?php elseif ( has_post_thumbnail() ) : ?>
			<div class="thumb">
				<?php the_post_thumbnail( 'mgp-game-thumb' ); ?>
			</div>
			<p class="no-games-found"><?php esc_html_e( 'This game does not have a playable embed URL set yet.', 'minigamesplay' ); ?></p>
		<?php endif; ?>

		<div class="game-info" style="margin-top:24px;">
			<?php mgp_render_game_meta( get_the_ID() ); ?>
			<?php the_content(); ?>
		</div>

	</section>

	<?php
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
		$related = new WP_Query(
			array(
				'post_type'      => 'game',
				'posts_per_page' => 4,
				'post__not_in'   => array( get_the_ID() ),
				'tax_query'      => array(
					array(
						'taxonomy' => 'game_category',
						'field'    => 'slug',
						'terms'    => $terms[0]->slug,
					),
				),
			)
		);
		if ( $related->have_posts() ) :
			?>
			<section class="games">
				<div class="section-header">
					<h2><?php esc_html_e( 'You Might Also Like', 'minigamesplay' ); ?></h2>
				</div>
				<div class="game-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/game-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
			<?php
		endif;
	endif;

endwhile;

get_footer();
