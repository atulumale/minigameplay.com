<?php
/**
 * "Game" custom post type, taxonomies, and meta box.
 *
 * @package Mini_Games_Play
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the "game" custom post type.
 */
function mgp_register_game_cpt() {

	$labels = array(
		'name'               => __( 'Games', 'minigamesplay' ),
		'singular_name'      => __( 'Game', 'minigamesplay' ),
		'add_new_item'       => __( 'Add New Game', 'minigamesplay' ),
		'edit_item'          => __( 'Edit Game', 'minigamesplay' ),
		'new_item'           => __( 'New Game', 'minigamesplay' ),
		'view_item'          => __( 'View Game', 'minigamesplay' ),
		'search_items'       => __( 'Search Games', 'minigamesplay' ),
		'not_found'          => __( 'No games found', 'minigamesplay' ),
		'not_found_in_trash' => __( 'No games found in Trash', 'minigamesplay' ),
		'all_items'          => __( 'All Games', 'minigamesplay' ),
		'menu_name'          => __( 'Games', 'minigamesplay' ),
	);

	register_post_type(
		'game',
		array(
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => true,
			'menu_icon'     => 'dashicons-video-alt3',
			'rewrite'       => array( 'slug' => 'games' ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'  => true,
			'menu_position' => 5,
		)
	);
}
add_action( 'init', 'mgp_register_game_cpt' );

/**
 * Register taxonomies for games:
 * - game_category: Action, Puzzle, Racing, Sports, Arcade, Brain Games, Multiplayer, etc.
 * - game_list:      Trending, Popular, New (used to build the homepage rows).
 */
function mgp_register_game_taxonomies() {

	register_taxonomy(
		'game_category',
		'game',
		array(
			'labels'            => array(
				'name'          => __( 'Game Categories', 'minigamesplay' ),
				'singular_name' => __( 'Game Category', 'minigamesplay' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'game-category' ),
		)
	);

	register_taxonomy(
		'game_list',
		'game',
		array(
			'labels'            => array(
				'name'          => __( 'Game Lists', 'minigamesplay' ),
				'singular_name' => __( 'Game List', 'minigamesplay' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'game-list' ),
		)
	);
}
add_action( 'init', 'mgp_register_game_taxonomies' );

/**
 * Seed the default taxonomy terms on theme activation so the homepage
 * sections and sidebar menu have something to query right away.
 */
function mgp_seed_default_terms() {

	$categories = array( 'Action', 'Puzzle', 'Racing', 'Sports', 'Arcade', 'Brain Games', 'Multiplayer', 'Shooting', 'Board' );
	foreach ( $categories as $category ) {
		if ( ! term_exists( $category, 'game_category' ) ) {
			wp_insert_term( $category, 'game_category' );
		}
	}

	$lists = array( 'Trending', 'Popular', 'New' );
	foreach ( $lists as $list ) {
		if ( ! term_exists( $list, 'game_list' ) ) {
			wp_insert_term( $list, 'game_list' );
		}
	}
}
add_action( 'after_switch_theme', 'mgp_seed_default_terms' );

/**
 * Meta box: rating, play count, badge tag, and the playable game URL/embed.
 */
function mgp_add_game_meta_box() {
	add_meta_box(
		'mgp_game_details',
		__( 'Game Details', 'minigamesplay' ),
		'mgp_render_game_meta_box',
		'game',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'mgp_add_game_meta_box' );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post Current post object.
 */
function mgp_render_game_meta_box( $post ) {

	wp_nonce_field( 'mgp_save_game_meta', 'mgp_game_meta_nonce' );

	$rating   = get_post_meta( $post->ID, '_game_rating', true );
	$plays    = get_post_meta( $post->ID, '_game_plays', true );
	$tag      = get_post_meta( $post->ID, '_game_tag', true );
	$embed    = get_post_meta( $post->ID, '_game_embed_url', true );
	$featured = get_post_meta( $post->ID, '_game_featured', true );
	?>
	<p>
		<label for="mgp_game_embed_url"><strong><?php esc_html_e( 'Playable game URL (iframe embed)', 'minigamesplay' ); ?></strong></label><br>
		<input type="url" id="mgp_game_embed_url" name="mgp_game_embed_url" class="widefat" value="<?php echo esc_attr( $embed ); ?>" placeholder="https://example.com/games/my-game/index.html">
	</p>
	<p>
		<label for="mgp_game_rating"><strong><?php esc_html_e( 'Rating (0–5)', 'minigamesplay' ); ?></strong></label><br>
		<input type="number" step="0.1" min="0" max="5" id="mgp_game_rating" name="mgp_game_rating" value="<?php echo esc_attr( $rating ); ?>">
	</p>
	<p>
		<label for="mgp_game_plays"><strong><?php esc_html_e( 'Play count (e.g. 120K, 4,203)', 'minigamesplay' ); ?></strong></label><br>
		<input type="text" id="mgp_game_plays" name="mgp_game_plays" value="<?php echo esc_attr( $plays ); ?>">
	</p>
	<p>
		<label for="mgp_game_tag"><strong><?php esc_html_e( 'Badge', 'minigamesplay' ); ?></strong></label><br>
		<select id="mgp_game_tag" name="mgp_game_tag">
			<option value="" <?php selected( $tag, '' ); ?>><?php esc_html_e( 'None', 'minigamesplay' ); ?></option>
			<option value="hot" <?php selected( $tag, 'hot' ); ?>><?php esc_html_e( 'HOT', 'minigamesplay' ); ?></option>
			<option value="new" <?php selected( $tag, 'new' ); ?>><?php esc_html_e( 'NEW', 'minigamesplay' ); ?></option>
			<option value="top" <?php selected( $tag, 'top' ); ?>><?php esc_html_e( 'TOP', 'minigamesplay' ); ?></option>
			<option value="online" <?php selected( $tag, 'online' ); ?>><?php esc_html_e( 'ONLINE', 'minigamesplay' ); ?></option>
		</select>
	</p>
	<p>
		<label>
			<input type="checkbox" name="mgp_game_featured" value="1" <?php checked( $featured, '1' ); ?>>
			<?php esc_html_e( 'Show in the homepage Featured Banner', 'minigamesplay' ); ?>
		</label>
	</p>
	<?php
}

/**
 * Save the meta box fields.
 *
 * @param int $post_id Post ID.
 */
function mgp_save_game_meta( $post_id ) {

	if ( ! isset( $_POST['mgp_game_meta_nonce'] ) || ! wp_verify_nonce( $_POST['mgp_game_meta_nonce'], 'mgp_save_game_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['mgp_game_embed_url'] ) ) {
		update_post_meta( $post_id, '_game_embed_url', esc_url_raw( wp_unslash( $_POST['mgp_game_embed_url'] ) ) );
	}
	if ( isset( $_POST['mgp_game_rating'] ) ) {
		update_post_meta( $post_id, '_game_rating', sanitize_text_field( $_POST['mgp_game_rating'] ) );
	}
	if ( isset( $_POST['mgp_game_plays'] ) ) {
		update_post_meta( $post_id, '_game_plays', sanitize_text_field( $_POST['mgp_game_plays'] ) );
	}
	if ( isset( $_POST['mgp_game_tag'] ) ) {
		update_post_meta( $post_id, '_game_tag', sanitize_key( $_POST['mgp_game_tag'] ) );
	}
	update_post_meta( $post_id, '_game_featured', isset( $_POST['mgp_game_featured'] ) ? '1' : '0' );
}
add_action( 'save_post_game', 'mgp_save_game_meta' );
