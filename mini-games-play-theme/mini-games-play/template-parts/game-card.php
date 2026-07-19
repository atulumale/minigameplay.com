<?php
/**
 * Template part: a single game card.
 *
 * Used inside the .game-grid wrapper on the front page, archive-game.php,
 * and taxonomy-game_category.php.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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
		<?php mgp_render_game_badge( get_the_ID() ); ?>
		<button class="favorite" aria-label="<?php esc_attr_e( 'Add to favorites', 'minigamesplay' ); ?>" data-game-id="<?php the_ID(); ?>">♡</button>
	</div>

	<div class="game-info">

		<h3><a class="game-cat-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php
		$category_name = mgp_get_primary_category_name( get_the_ID() );
		if ( $category_name ) :
			?>
			<p><?php echo esc_html( $category_name ); ?></p>
		<?php endif; ?>

		<?php mgp_render_game_meta( get_the_ID() ); ?>

		<a href="<?php the_permalink(); ?>"><button type="button"><?php esc_html_e( 'Play Now', 'minigamesplay' ); ?></button></a>

	</div>

</div>
