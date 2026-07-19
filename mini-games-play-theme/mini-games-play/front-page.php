<?php
/**
 * The front page: hero, category slider, and homepage game rows.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- ================= HERO ================= -->

<section class="hero">

	<div class="hero-left">

		<span class="badge"><?php echo esc_html( get_theme_mod( 'mgp_hero_badge', __( '🔥 Trending Platform', 'minigamesplay' ) ) ); ?></span>

		<h1><?php echo esc_html( get_theme_mod( 'mgp_hero_heading', __( 'Play Thousands of Free Online Games', 'minigamesplay' ) ) ); ?></h1>

		<p><?php echo esc_html( get_theme_mod( 'mgp_hero_text', __( 'Discover amazing Puzzle, Racing, Arcade, Sports and Action games. No downloads. Play instantly. Any device. Anytime.', 'minigamesplay' ) ) ); ?></p>

		<div class="hero-buttons">
			<a href="<?php echo esc_url( get_theme_mod( 'mgp_hero_btn1_url', '#' ) ); ?>" class="primary-btn">
				<?php echo esc_html( get_theme_mod( 'mgp_hero_btn1_text', __( 'Play Now', 'minigamesplay' ) ) ); ?>
			</a>
			<a href="<?php echo esc_url( get_theme_mod( 'mgp_hero_btn2_url', '#' ) ); ?>" class="secondary-btn">
				<?php echo esc_html( get_theme_mod( 'mgp_hero_btn2_text', __( 'Explore Games', 'minigamesplay' ) ) ); ?>
			</a>
		</div>

	</div>

	<div class="hero-right">
		<?php $hero_image = get_theme_mod( 'mgp_hero_image', '' ); ?>
		<?php if ( $hero_image ) : ?>
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'Hero', 'minigamesplay' ); ?>">
		<?php else : ?>
			<img src="<?php echo esc_url( MGP_THEME_URI . '/images/hero.png' ); ?>" alt="<?php esc_attr_e( 'Hero', 'minigamesplay' ); ?>">
		<?php endif; ?>
	</div>

</section>

<!-- ================= Categories ================= -->

<?php
$all_categories = get_terms(
	array(
		'taxonomy'   => 'game_category',
		'hide_empty' => false,
	)
);
?>
<?php if ( ! is_wp_error( $all_categories ) && ! empty( $all_categories ) ) : ?>

	<section class="categories">

		<div class="section-header">
			<h2><?php esc_html_e( 'Popular Categories', 'minigamesplay' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'game' ) ); ?>"><?php esc_html_e( 'View All', 'minigamesplay' ); ?></a>
		</div>

		<div class="category-slider">
			<?php
			$category_icons = array(
				'action'      => 'fa-solid fa-bolt',
				'racing'      => 'fa-solid fa-car',
				'puzzle'      => 'fa-solid fa-puzzle-piece',
				'sports'      => 'fa-solid fa-futbol',
				'brain-games' => 'fa-solid fa-brain',
				'arcade'      => 'fa-solid fa-ghost',
				'shooting'    => 'fa-solid fa-crosshairs',
				'board'       => 'fa-solid fa-chess',
				'multiplayer' => 'fa-solid fa-users',
			);
			foreach ( $all_categories as $category ) :
				$icon = isset( $category_icons[ $category->slug ] ) ? $category_icons[ $category->slug ] : 'fa-solid fa-gamepad';
				?>
				<a class="category-card" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
					<i class="<?php echo esc_attr( $icon ); ?>"></i>
					<p><?php echo esc_html( $category->name ); ?></p>
				</a>
			<?php endforeach; ?>
		</div>

	</section>

<?php endif; ?>

<!-- ================= Homepage Game Rows ================= -->

<?php
mgp_render_game_section( __( 'Trending Games', 'minigamesplay' ), 'game_list', 'trending' );
mgp_render_game_section( __( 'Popular Games', 'minigamesplay' ), 'game_list', 'popular' );
mgp_render_game_section( __( 'New Games', 'minigamesplay' ), 'game_list', 'new' );
mgp_render_game_section( __( 'Action Games', 'minigamesplay' ), 'game_category', 'action' );
mgp_render_game_section( __( 'Puzzle Games', 'minigamesplay' ), 'game_category', 'puzzle' );
mgp_render_game_section( __( 'Racing Games', 'minigamesplay' ), 'game_category', 'racing' );
mgp_render_game_section( __( 'Sports Games', 'minigamesplay' ), 'game_category', 'sports' );
mgp_render_game_section( __( 'Multiplayer Games', 'minigamesplay' ), 'game_category', 'multiplayer' );
?>

<?php get_footer(); ?>
