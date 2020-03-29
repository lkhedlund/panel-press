<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Panel_Press
 * @subpackage Panel_Press/public
 * @author     Lars <lkhedlund@gmail.com>
 */
class Panel_Press_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Panel_Press_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Panel_Press_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/panel-press-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '/fonts', plugin_dir_url( __FILE__ ) . 'css/panel-press-fonts.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Panel_Press_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Panel_Press_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/panel-press-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Load the comic archive override if template doesn't exist in theme.
	 *
	 * @since    1.0.0
	 */
	public function load_comic_archive_template($template) {
		global $post;

    	$exists_in_theme = locate_template('archive-pp-comic.php', false);

    	if (!$exists_in_theme && $post->post_type == "pp-comic") {
        	return plugin_dir_path( __FILE__ ) . "templates/archive-comic.php";
    	}

    	return $template;
	}

	/**
	 * Load the comic archive override if template doesn't exist in theme.
	 *
	 * @since    1.0.0
	 */
	public function display_collections($args = array()) {
		$defaults = array(
			'taxonomy'      => 'pp-collection',
			'separator'     => ', ',
			'before_terms'  => '<div class="term-list %1$s">',
			'after_terms'   => '</div>',
			'include_link'  => true,
			'limit'         => -1,
		);
	 
		$display = wp_parse_args( $args, $defaults );  
	
		$terms = get_the_terms( get_the_ID(), $display['taxonomy'] );
	
		if ( !empty($terms) && ! is_wp_error( $terms ) ) : 
			$i = 0;
	
			$term_links = array();
	
			foreach ( $terms as $term ) {
				if ($display['limit'] === -1 || $i < $display['limit']) {
					if ($display['include_link']) {
						$term_links[] = sprintf( '<a href="%1$s" class="%3$s">%2$s</a>',
						esc_url( get_term_link( $term->slug, $display['taxonomy'] ) ),
						esc_html( $term->name ),
						esc_html( $display['taxonomy'] . '-' . $term->slug ));
					} else {
						$term_links[] = sprintf( '<span class="%2$s">%1$s</span>',
						esc_html( $term->name ),
						esc_html( $display['taxonomy'] . '-' . $term->slug ));
					}
				}
	
				$i++;
			}
	
			$taxonomy_class = $display['taxonomy'] ."-terms";
	
			echo sprintf($display['before_terms'], $taxonomy_class) . join( $display['separator'], $term_links ) . $display['after_terms'];
		endif;
	}

	/**
	 * Load the comic archive override if template doesn't exist in theme.
	 *
	 * @since    1.0.0
	 */
	public function get_entry_meta() {
		$post_meta = array(
			'author',
			'post-date',
			'category',
			'comments',
			'sticky',
		);

		ob_start();

		if ( !empty( $post_meta ) ) : ?>

			<div class="post-meta-wrapper">
				<ul class="post-meta">
					<?php
					// Author.
					if ( in_array( 'author', $post_meta, true ) ) { ?>
						<li class="post-author meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Post author', 'panel-press' ); ?></span>
								<i class="pp-icon pp-icon-user"></i>
							</span>
							<span class="meta-text">
								<?php
								printf(
									/* translators: %s: Author name */
									__( 'By %s', 'panel-press' ),
									'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>'
								);
								?>
							</span>
						</li>
						<?php

					}

					// Post date.
					if ( in_array( 'post-date', $post_meta, true ) ) { ?>
						<li class="post-date meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Post date', 'panel-press' ); ?></span>
								<i class="pp-icon pp-icon-calendar"></i>
							</span>
							<span class="meta-text">
								<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
							</span>
						</li>
						<?php

					}

					// Category
					if ( in_array( 'category', $post_meta, true ) ) { ?>
						<li class="post-date meta-wrapper">
							<span class="meta-icon">
								<span class="screen-reader-text"><?php _e( 'Post date', 'panel-press' ); ?></span>
								<i class="pp-icon pp-icon-calendar"></i>
							</span>
							<span class="meta-text">
								<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
							</span>
						</li>
						<?php

					}

					// Comments link.
					if ( in_array( 'comments', $post_meta, true ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

						$has_meta = true;
						?>
						<li class="post-comment-link meta-wrapper">
							<span class="meta-icon">
								<i class="pp-icon pp-icon-message-square"></i>
							</span>
							<span class="meta-text">
								<?php comments_popup_link(); ?>
							</span>
						</li>
						<?php

					}

					// Sticky.
					if ( in_array( 'sticky', $post_meta, true ) && is_sticky() ) {

						$has_meta = true;
						?>
						<li class="post-sticky meta-wrapper">
							<span class="meta-icon">
								<i class="pp-icon pp-icon-bookmark"></i>
							</span>
							<span class="meta-text">
								<?php _e( 'Sticky post', 'panel-press' ); ?>
							</span>
						</li>
						<?php

					}
					?>

				</ul><!-- .post-meta -->

			</div><!-- .post-meta-wrapper -->

		<?php
		endif;

		$meta_output = ob_get_clean();

		echo $meta_output;
	}
}
