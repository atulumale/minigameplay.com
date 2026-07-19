<?php
/**
 * Template helper functions shared by front-page.php, archive-game.php,
 * taxonomy-game_category.php, and the template-parts.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a WP_Query for a homepage row such as "Trending Games" or
 * "Racing Games".
 *
 * @param string $taxonomy  'game_category' or 'game_list'.
 * @param string $term_slug Term slug to filter by.
 * @param int    $count     Number of games to fetch.
 * @return WP_Query
 */
function mgp_get_games_query( $taxonomy, $term_slug, $count = 6 ) {

	$args = array(
		'post_type'      => 'game',
		'posts_per_page' => $count,
		'tax_query'      => array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
	);

	return new WP_Query( $args );
}

/**
 * Output star rating markup (★★★★★ with the fractional part greyed via CSS
 * class) based on a 0–5 numeric rating stored in post meta.
 *
 * @param float $rating Rating value.
 */
function mgp_render_stars( $rating ) {

	$rating = is_numeric( $rating ) ? (float) $rating : 5;
	$rounded = (int) round( $rating );
	$rounded = max( 0, min( 5, $rounded ) );

	echo '<div class="rating">' . esc_html( str_repeat( '★', $rounded ) . str_repeat( '☆', 5 - $rounded ) ) . '</div>';
}

/**
 * Render the game-meta row (⭐ rating + play count), matching the markup
 * used by cards that show numeric metadata instead of plain star ratings.
 *
 * @param int $post_id Game post ID.
 */
function mgp_render_game_meta( $post_id ) {

	$rating = get_post_meta( $post_id, '_game_rating', true );
	$plays  = get_post_meta( $post_id, '_game_plays', true );

	if ( ! $rating && ! $plays ) {
		return;
	}

	echo '<div class="game-meta">';
	if ( $rating ) {
		echo '<span>⭐ ' . esc_html( $rating ) . '</span>';
	}
	if ( $plays ) {
		echo '<span>' . esc_html( $plays ) . '</span>';
	}
	echo '</div>';
}

/**
 * Render the HOT / NEW / TOP / ONLINE badge on a thumbnail, if set.
 *
 * @param int $post_id Game post ID.
 */
function mgp_render_game_badge( $post_id ) {

	$tag = get_post_meta( $post_id, '_game_tag', true );

	if ( empty( $tag ) ) {
		return;
	}

	$labels = array(
		'hot'    => __( 'HOT', 'minigamesplay' ),
		'new'    => __( 'NEW', 'minigamesplay' ),
		'top'    => __( 'TOP', 'minigamesplay' ),
		'online' => __( 'ONLINE', 'minigamesplay' ),
	);

	if ( ! isset( $labels[ $tag ] ) ) {
		return;
	}

	printf( '<span class="tag %1$s">%2$s</span>', esc_attr( $tag ), esc_html( $labels[ $tag ] ) );
}

/**
 * Get the primary game_category term name for a game (used as the
 * subtitle line under the game title, e.g. "Arcade", "Puzzle").
 *
 * @param int $post_id Game post ID.
 * @return string
 */
function mgp_get_primary_category_name( $post_id ) {

	$terms = get_the_terms( $post_id, 'game_category' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}

	return $terms[0]->name;
}

/**
 * Render one "row" section of games (section header + slider/grid),
 * used repeatedly on the homepage.
 *
 * @param string $title     Section heading, e.g. "Trending Games".
 * @param string $taxonomy  'game_category' or 'game_list'.
 * @param string $term_slug Term slug to query.
 * @param string $view_all  URL for the "View All" link.
 */
function mgp_render_game_section( $title, $taxonomy, $term_slug, $view_all = '' ) {

	$query = mgp_get_games_query( $taxonomy, $term_slug );

	if ( ! $query->have_posts() ) {
		return;
	}

	if ( empty( $view_all ) ) {
		$term     = get_term_by( 'slug', $term_slug, $taxonomy );
		$view_all = $term ? get_term_link( $term ) : '#';
	}
	?>
	<section class="games">

		<div class="section-header">
			<h2><?php echo esc_html( $title ); ?></h2>
			<a href="<?php echo esc_url( $view_all ); ?>"><?php esc_html_e( 'View All', 'minigamesplay' ); ?></a>
		</div>

		<div class="game-grid">
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				get_template_part( 'template-parts/game-card' );
			}
			wp_reset_postdata();
			?>
		</div>

	</section>
	<?php
}
