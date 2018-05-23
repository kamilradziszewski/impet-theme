<?php

$context = Timber::get_context();

$args = array(
  'post_type' => 'page',
  'orderby'   => array(
    'menu_order' => 'ASC'
  )
);

$context['pages'] = Timber::get_posts( $args );

$context['products']['polish'] = Timber::get_posts(
  array(
    'post_type'  => 'products',
    'meta_key'   => '_impet_products_origin',
    'meta_value' => 'polski',
    'orderby'    => array(
      'menu_order' => 'ASC'
    )
  )
);

$context['products']['imported'] = Timber::get_posts(
  array(
    'post_type'  => 'products',
    'meta_key'   => '_impet_products_origin',
    'meta_value' => 'importowany',
    'orderby'    => array(
      'menu_order' => 'ASC'
    )
  )
);

Timber::render( array( 'front-page.twig' ), $context );
