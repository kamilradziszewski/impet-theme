<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();





/*******************************************************************************
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'impet_bialystok_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function impet_bialystok_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

    // Required plugins
    array(
			'name'               => 'Timber',
			'slug'               => 'timber-library',
			'required'           => true,
			'force_activation'   => true,
    ),

    array(
			'name'               => 'CMB2',
			'slug'               => 'cmb2',
			'required'           => true,
			'force_activation'   => true,
    ),

    // Recommended plugins
    array(
			'name'               => 'All-in-One WP Migration',
			'slug'               => 'all-in-one-wp-migration',
    ),

	);

	$config = array(
		'id'           => 'impet-bialystok',       // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}





/*******************************************************************************
 * Register PRODUCTS Custom Post Type
 */
function products_post_type() {

  $labels = array(
    'name'                  => _x(  'Products',
                                    'Post Type General Name',
                                    'impet-bialystok' ),
    'singular_name'         => _x(  'Product',
                                    'Post Type Singular Name',
                                    'impet-bialystok' ),
    'menu_name'             => __( 'Products', 'impet-bialystok' ),
    'name_admin_bar'        => __( 'Product', 'impet-bialystok' ),
    'archives'              => __( 'Product Archives', 'impet-bialystok' ),
    'attributes'            => __( 'Product Attributes', 'impet-bialystok' ),
    'parent_item_colon'     => __( 'Parent Product:', 'impet-bialystok' ),
    'all_items'             => __( 'All Products', 'impet-bialystok' ),
    'add_new_item'          => __( 'Add New Product', 'impet-bialystok' ),
    'add_new'               => __( 'Add New', 'impet-bialystok' ),
    'new_item'              => __( 'New Product', 'impet-bialystok' ),
    'edit_item'             => __( 'Edit Product', 'impet-bialystok' ),
    'update_item'           => __( 'Update Product', 'impet-bialystok' ),
    'view_item'             => __( 'View Product', 'impet-bialystok' ),
    'view_items'            => __( 'View Products', 'impet-bialystok' ),
    'search_items'          => __( 'Search Product', 'impet-bialystok' ),
    'not_found'             => __( 'Not found', 'impet-bialystok' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'impet-bialystok' ),
    'featured_image'        => __( 'Featured Image', 'impet-bialystok' ),
    'set_featured_image'    => __( 'Set featured image', 'impet-bialystok' ),
    'remove_featured_image' => __( 'Remove featured image', 'impet-bialystok' ),
    'use_featured_image'    => __( 'Use as featured image', 'impet-bialystok' ),
    'insert_into_item'      => __( 'Insert into Product', 'impet-bialystok' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Product', 'impet-bialystok' ),
    'items_list'            => __( 'Products list', 'impet-bialystok' ),
    'items_list_navigation' => __( 'Products list navigation', 'impet-bialystok' ),
    'filter_items_list'     => __( 'Filter Products list', 'impet-bialystok' ),
  );

  $args = array(
    'label'                 => __( 'Products', 'impet-bialystok' ),
    'description'           => __( 'Post Type Description', 'impet-bialystok' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'page-attributes' ),
    'public'                => true,
    'menu_position'         => 20,
    'menu_icon'                => 'dashicons-chart-line',
  );
  register_post_type( 'products', $args );

}
add_action( 'init', 'products_post_type', 0 );
