<?php
   function carrega_estilos_tema() {
       wp_enqueue_style( 'sonotto', get_template_directory_uri() . '/css/sonotto.css' );
       wp_enqueue_style( 'sonotto-pro', get_stylesheet_directory_uri() . '/css/sonotto-pro.css', array( 'sonotto' ) );
   }

   add_action( 'wp_enqueue_scripts', 'carrega_estilos_tema', PHP_INT_MAX);

  /* Desativar barra de Administrador */
   add_filter( 'show_admin_bar', '__return_false' );

?>