<?php
/**
 * The footer for the theme: featured banner, newsletter, footer columns.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	<!-- ================= Featured Banner ================= -->

	<section class="featured-banner">

		<div class="featured-content">

			<span class="badge"><?php echo esc_html( get_theme_mod( 'mgp_banner_badge', __( 'FEATURED GAME', 'minigamesplay' ) ) ); ?></span>

			<h2><?php echo esc_html( get_theme_mod( 'mgp_banner_heading', __( 'Play the Best HTML5 Games for Free', 'minigamesplay' ) ) ); ?></h2>

			<p><?php echo esc_html( get_theme_mod( 'mgp_banner_text', __( 'Enjoy thousands of free online games without downloading. Action, Puzzle, Racing, Sports, Arcade and many more.', 'minigamesplay' ) ) ); ?></p>

			<a href="<?php echo esc_url( get_theme_mod( 'mgp_banner_btn_url', '#' ) ); ?>" class="primary-btn">
				<?php echo esc_html( get_theme_mod( 'mgp_banner_btn_text', __( 'Start Playing', 'minigamesplay' ) ) ); ?>
			</a>

		</div>

	</section>

	<!-- ================= Newsletter ================= -->

	<section class="newsletter">

		<h2><?php esc_html_e( 'Stay Updated', 'minigamesplay' ); ?></h2>

		<p><?php esc_html_e( 'Get notified whenever new games are added.', 'minigamesplay' ); ?></p>

		<form class="newsletter-box" method="post" action="#">
			<input type="email" name="mgp_newsletter_email" placeholder="<?php esc_attr_e( 'Enter your email', 'minigamesplay' ); ?>" required>
			<button type="submit"><?php esc_html_e( 'Subscribe', 'minigamesplay' ); ?></button>
		</form>

	</section>

	<!-- ================= Footer ================= -->

	<footer>

		<div class="footer-container">

			<div class="footer-column">
				<h3><?php bloginfo( 'name' ); ?></h3>
				<p><?php echo esc_html( get_theme_mod( 'mgp_footer_about', __( 'Play thousands of free online HTML5 games directly in your browser. No Download. No Installation. Just Play.', 'minigamesplay' ) ) ); ?></p>
			</div>

			<div class="footer-column">
				<h3><?php esc_html_e( 'Categories', 'minigamesplay' ); ?></h3>
				<?php if ( has_nav_menu( 'footer-categories' ) ) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-categories',
							'container'      => false,
							'items_wrap'     => '<ul>%3$s</ul>',
						)
					);
					?>
				<?php else : ?>
					<ul>
						<?php
						$footer_categories = get_terms(
							array(
								'taxonomy'   => 'game_category',
								'hide_empty' => false,
								'number'     => 6,
							)
						);
						if ( ! is_wp_error( $footer_categories ) ) {
							foreach ( $footer_categories as $category ) {
								printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( get_term_link( $category ) ), esc_html( $category->name ) );
							}
						}
						?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="footer-column">
				<h3><?php esc_html_e( 'Quick Links', 'minigamesplay' ); ?></h3>
				<?php if ( has_nav_menu( 'footer-links' ) ) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-links',
							'container'      => false,
							'items_wrap'     => '<ul>%3$s</ul>',
						)
					);
					?>
				<?php else : ?>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'minigamesplay' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'minigamesplay' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/terms' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'minigamesplay' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'minigamesplay' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/support' ) ); ?>"><?php esc_html_e( 'Support', 'minigamesplay' ); ?></a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div class="footer-column">
				<h3><?php esc_html_e( 'Follow Us', 'minigamesplay' ); ?></h3>
				<div class="social-icons">
					<?php
					$socials = array(
						'facebook'  => 'fab fa-facebook-f',
						'instagram' => 'fab fa-instagram',
						'x-twitter' => 'fab fa-x-twitter',
						'youtube'   => 'fab fa-youtube',
						'discord'   => 'fab fa-discord',
					);
					foreach ( $socials as $network => $icon ) {
						$url = get_theme_mod( 'mgp_social_' . $network, '#' );
						printf( '<a href="%1$s"><i class="%2$s"></i></a>', esc_url( $url ), esc_attr( $icon ) );
					}
					?>
				</div>
			</div>

			<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
			<?php endif; ?>

		</div>

		<div class="copyright">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All Rights Reserved.', 'minigamesplay' ); ?>
		</div>

	</footer>

</div><!-- .main -->

<?php wp_footer(); ?>

</body>
</html>
