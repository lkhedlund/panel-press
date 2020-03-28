<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://iskotaa.com
 * @since      1.0.0
 *
 * @package    Panel_Press
 * @subpackage Panel_Press/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Panel_Press
 * @subpackage Panel_Press/admin
 * @author     Lars <lkhedlund@gmail.com>
 */
class Panel_Press_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/panel-press-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/panel-press-admin.js', array( 'jquery' ), $this->version, false );

    }

    /**
	 * Creates a new taxonomy.
	 *
	 * @since    1.0.0
     * @uses register_taxonomy()
	 */

    public static function register_collection_taxonomy() {
        register_taxonomy(
            'pp-collection',
            'pp-comic',
            array(
                'label' => __( 'Collection' ),
                'rewrite' => array( 'slug' => 'collection' ),
                'hierarchical' => true,
                'public' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'show_in_rest'  => true,
            )
        );
    }

    /**
	 * Creates a new custom post type.
	 *
	 * @since    1.0.0
     * @uses register_post_type()
	 */
    public static function register_comic_post_type() {
        $name = 'pp-comic';

        $labels = array(
            'name'               => _x( 'Comics', 'post type general name' ),
            'singular_name'      => _x( 'Comic', 'post type singular name' ),
            'add_new'            => _x( 'Add New', $name ),
            'add_new_item'       => __( 'Add New Comic' ),
            'edit_item'          => __( 'Edit Comic' ),
            'new_item'           => __( 'New Comic' ),
            'all_items'          => __( 'All Comics' ),
            'view_item'          => __( 'View Comic' ),
            'search_items'       => __( 'Search Comics' ),
            'not_found'          => __( 'No Comics found' ),
            'not_found_in_trash' => __( 'No Comics found in the Trash' ),
            'parent_item_colon'  => '',
            'menu_name'          => 'Comics'
        );

        $supports = array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'revisions' );
        $taxonomies = array( 'pp-collection', 'post_tag');

        $args = array(
            'labels'        => $labels,
            'description'   => 'Comic post type.',
            'public'        => true,
            'menu_position' => 6,
            'supports'      => $supports,
            'taxonomies'    => $taxonomies,
            'rewrite'       => array( 'slug' => 'comic' ),
            'menu_icon'     => 'dashicons-index-card',
            'has_archive'   => true,
            'show_in_rest'  => true,
        );

        register_post_type( $name, $args );
	}
	
	/**
	 * Order comic posts in main archive.
	 *
	 * @since    1.0.0
     * @uses is_post_type_archive(), is_tax()
	 */
	public static function pre_get_comics( $query ) {
		if ( $query->is_main_query() && !is_admin() ) {
			if ( $query->is_tax('pp-collection') ) {
				$query->set('order', 'ASC'); 
			}       
		}
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
}
