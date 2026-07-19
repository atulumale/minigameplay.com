<?php
/**
 * Generic page template (About, Privacy Policy, Contact, etc.).
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<section class="games">

		<div class="section-header">
			<h2><?php the_title(); ?></h2>
		</div>

		<div class="game-info" style="max-width:900px;">
			<?php the_content(); ?>
		</div>

	</section>

	<?php
endwhile;

get_footer();
