<?php

$context = Timber::get_context();

$args = array(
  'pagename'  => 'o-nas'
);
$context['page'] = Timber::get_posts( $args );

Timber::render( '404.twig', $context );
