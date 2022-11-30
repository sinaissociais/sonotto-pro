<?php
   
   add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles_child', PHP_INT_MAX);

   function theme_enqueue_styles_child() {
       wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
       wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/css/sonotto-pro.css', array( 'parent-style' ) );
   }

?>