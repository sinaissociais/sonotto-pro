<?php
   function carrega_estilos_tema() {
       wp_enqueue_style( 'sonotto', get_template_directory_uri() . '/css/sonotto.css' );
       wp_enqueue_style( 'sonotto-pro', get_stylesheet_directory_uri() . '/css/sonotto-pro.css', array( 'sonotto' ) );
   }

   add_action( 'wp_enqueue_scripts', 'carrega_estilos_tema', PHP_INT_MAX);

  /* Desativar barra de Administrador */
   add_filter( 'show_admin_bar', '__return_false' );


   // Registrar Tipo de Usuário como "Distribuidor"
   function add_role_parceiro_distribuidor() {
        add_role(
            'parceiro_distribuidor',
            __( 'Distribuidor' ),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => false,
                'delete_posts' => false, // Use false to explicitly deny
            )
        );
    }
    add_action( 'init', 'add_role_parceiro_distribuidor' );

    // Se usuário for Distribuidor, exibir div no header.php

    function is_parceiro_distribuidor() {
        if ( current_user_can( 'parceiro_distribuidor' ) ) {
            echo '<div class="distribuidor">' . wp_get_current_user()->user_login . ', você é um distribuidor Sonotto Pro <a href="' . get_home_url() . '/loja">Ir para Loja</a>  | <a href="' . wp_logout_url( get_permalink() ) . '/loja">Fazer Logout</a></div>';
        }
    }
    add_action( 'wp_head', 'is_parceiro_distribuidor' );

    /* WooCommerce - Esconder o preço e opção de compra (woocommerce_get_price_html) - liberar apenas para usuários logados com permissão "parceiro_distribuidor" ou "administrator" */

    function esconder_preco() {
        if ( ! current_user_can( 'parceiro_distribuidor' ) && ! current_user_can( 'administrator' ) ) {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

            /* remover do catálogo */
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

        }
    }
    add_action( 'wp_head', 'esconder_preco' );

    /* Restringir acesso ao Carrinho e Finalização de Compra apenas para usuário "parceiro_distribuidor" ou "administrator" */

    function distribuicao_restringir_carrinho() {
        if ( ! current_user_can( 'parceiro_distribuidor' ) && ! current_user_can( 'administrator' ) ) {
            if ( is_cart() || is_checkout() ) {
                wp_redirect( get_home_url() );
                exit;
            }
        }
    }

    add_action( 'template_redirect', 'distribuicao_restringir_carrinho' );


    /* Se usuário não estiver logado, exibir uma mensagem abaixo da class  "quantidade-titulo" no produto WooCommerce */

    function distribuicao_exibir_mensagem() {
        if ( ! is_user_logged_in() ) {
            echo '<style>.quantidade-titulo {display: none;}</style>';
            echo '<div class="distribuicao_mensagem_login"><p>Entre com sua <strong>conta de distribuidor</strong> para ver os preços e realizar seus pedidos</p><a href="' . get_home_url() . '/login">Fazer Login</a> </div>';
        }
    }

    add_action( 'woocommerce_single_product_summary', 'distribuicao_exibir_mensagem', 21 );

    

   
?>