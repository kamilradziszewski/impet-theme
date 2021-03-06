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
    'parent_item_colon'     => __( 'Parent Product', 'impet-bialystok' ),
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





/*******************************************************************************
 * Remove Admin Menu items
 */
function remove_menu_items() {
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menu_items' );





/*******************************************************************************
 * Returns ID based on SLUG
 */
function get_id_by_slug($page_slug) {
  $page = get_page_by_path($page_slug);
  if ($page) {
    return $page->ID;
  } else {
    return null;
  }
}





/*******************************************************************************
 * Create custom metaboxes with CMB2
 */
add_action( 'cmb2_admin_init', 'cmb2_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_impet_';

	/**
	 * Initiate the metabox for CENNIK page
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'price_list',
		'title'         => __( 'Legal Notice', 'impet-bialystok' ),
    'object_types'  => array( 'page', ),
    'show_on'       => array( 'key' => 'id',
                              'value' => array( get_id_by_slug('cennik') ) ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => false,
	) );

	$cmb->add_field( array(
		'name'       => __( 'Legal Notice Text', 'impet-bialystok' ),
		'desc'       => __( 'Legal notice about prices and offer', 'impet-bialystok' ),
		'id'         => $prefix . 'price_list_legal_notice',
		'type'       => 'textarea_small',
  ) );

  /**
	 * Initiate the metabox for KONTAKT page
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'contact',
		'title'         => __( 'Contact Data', 'impet-bialystok' ),
    'object_types'  => array( 'page', ),
    'show_on'      => array( 'key' => 'id',
                             'value' => array( get_id_by_slug('kontakt') ) ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	) );

	$cmb->add_field( array(
		'name'       => __( 'Address', 'impet-bialystok' ),
		'id'         => $prefix . 'contact_address',
    'type'       => 'text',
    'repeatable'     => true,
  ) );

  $cmb->add_field( array(
		'name'       => __( 'Telephone', 'impet-bialystok' ),
		'id'         => $prefix . 'contact_telephone',
    'type'       => 'text',
    'repeatable'     => true,
  ) );

  $cmb->add_field( array(
		'name'         => __( 'Monday to Friday – OPEN', 'impet-bialystok' ),
    'id'           => $prefix . 'contact_opening_hours_mon_fri_open',
    'type'         => 'text_time',
    'time_format'  => 'H:i',
  ) );

  $cmb->add_field( array(
		'name'         => __( 'Monday to Friday – CLOSE', 'impet-bialystok' ),
    'id'           => $prefix . 'contact_opening_hours_mon_fri_close',
    'type'         => 'text_time',
    'time_format'  => 'H:i',
  ) );

  $cmb->add_field( array(
		'name'         => __( 'Saturday – OPEN', 'impet-bialystok' ),
    'id'           => $prefix . 'contact_opening_hours_sat_open',
    'type'         => 'text_time',
    'time_format'  => 'H:i',
  ) );

  $cmb->add_field( array(
		'name'         => __( 'Saturday – CLOSE', 'impet-bialystok' ),
    'id'           => $prefix . 'contact_opening_hours_sat_close',
    'type'         => 'text_time',
    'time_format'  => 'H:i',
  ) );

  $cmb->add_field( array(
		'name'       => __( 'Email', 'impet-bialystok' ),
		'id'         => $prefix . 'contact_email',
		'type'       => 'text_email',
  ) );

  $cmb->add_field( array(
		'name'       => __( 'Facebook', 'impet-bialystok' ),
		'id'         => $prefix . 'contact_facebook',
		'type'       => 'text_url',
  ) );

  /**
	 * Initiate the metabox for PRODUCTS post type
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'products',
		'title'         => __( 'Product Details', 'impet-bialystok' ),
    'object_types'  => array( 'products', ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
  ) );

  $cmb->add_field( array(
    'name'          => __( 'Price', 'impet-bialystok' ),
    'id'            => $prefix . 'products_price',
    'type'          => 'text_money',
    'before_field'  => 'PLN',
  ) );

  $cmb->add_field( array(
    'name'          => __( 'Product origin', 'impet-bialystok' ),
    'id'            => $prefix . 'products_origin',
    'type'          => 'radio',
    'options'          => array(
      'polish'     => _x( 'Polish', 'Products origin', 'impet-bialystok' ),
      'imported'   => _x( 'Imported', 'Products origin', 'impet-bialystok' ),
    ),
  ) );

  $cmb->add_field( array(
    'name'          => __( 'Extra information', 'impet-bialystok' ),
    'id'            => $prefix . 'products_extra_info',
    'type'          => 'text',
  ) );

}





/*******************************************************************************
 * Add columns for PRODUCTS post type in wp_admin
 */
// Add custom columns
function impet_products_columns($columns) {
  unset( $columns['date'] );
  $columns['menu_order'] = __( 'Order' );
  $columns['products_price'] = __( 'Price [PLN]', 'impet-bialystok' );
  $columns['products_origin'] = __( 'Origin', 'impet-bialystok' );
  $columns['products_extra_info'] = __( 'Extra Info', 'impet-bialystok' );

  return $columns;
}
add_filter( 'manage_products_posts_columns', 'impet_products_columns' );

// Fill custom columns with data
function impet_products_column( $column, $post_id ) {
  switch ( $column ) {
    case 'menu_order':
      echo get_post_field( 'menu_order', $post_id, true );
      break;
    case 'products_price' :
      $price = get_post_meta( $post_id , '_impet_products_price' , true );
      if ( $price )
        echo number_format($price);
      else
        _e( 'Unable to get Products price', 'impet-bialystok' );
      break;
    case 'products_origin' :
      $origin = get_post_meta( $post_id , '_impet_products_origin' , true );
      if ( $origin )
        echo $origin;
      else
        _e( 'Unable to get Products origin', 'impet-bialystok' );
      break;
    case 'products_extra_info' :
      $extra_info = get_post_meta( $post_id,
                                   '_impet_products_extra_info',
                                   true );
      if ( $extra_info )
        echo $extra_info;
      else
        echo '—';
      break;
  }
}
add_action( 'manage_products_posts_custom_column',
            'impet_products_column', 10, 2 );

// Make columns sortable
function impet_products_sortable_columns( $columns ) {
  unset( $columns['title'] );
  $columns['products_price'] = 'price';
  $columns['products_origin'] = 'origin';
  return $columns;
}
add_filter( 'manage_edit-products_sortable_columns',
            'impet_products_sortable_columns');

// Implement ordering by meta data
function impet_sort_meta_columns( $query ) {
	if( ! is_admin() )
    return;

  $orderby = $query->get( 'orderby');

  switch ($orderby) {
    case '':
      $query->set('meta_key','_impet_products_origin');
      $query->set('orderby','meta_value');
      break;
    case 'price':
      $query->set('meta_key','_impet_products_price');
      $query->set('orderby','meta_value_num');
      break;
    case 'origin':
      $query->set('meta_key','_impet_products_origin');
      $query->set('orderby','meta_value');
      break;
  }
}
add_action( 'pre_get_posts', 'impet_sort_meta_columns' );





/*******************************************************************************
 * Enqueue scripts and styles
 */
function impet_bialystok_scripts_and_styles() {
  wp_enqueue_style( 'impet-bialystok-main',
                    get_stylesheet_directory_uri() . '/static/dist/css/main.css' );

  wp_enqueue_script(	'main-js',
                      get_stylesheet_directory_uri() . '/static/dist/js/main.min.js',
                      array(),
                      false,
                      true );
}
add_action( 'wp_enqueue_scripts', 'impet_bialystok_scripts_and_styles' );





/*******************************************************************************
 * Load theme textdomain
 */
function theme_textdomain_setup(){
    load_theme_textdomain('impet-bialystok', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'theme_textdomain_setup');
