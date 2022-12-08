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

    // Registrar menu distribuidor

        function distribuicao_registrar_menu() {
            register_nav_menu( 'distribuidor', __( 'Menu Distribuidor', 'sonotto-pro' ) );
        }

        add_action( 'init', 'distribuicao_registrar_menu' );

    // Se usuário estiver logado, exibir div no header.php
    function distribuicao_exibir_menu_usuario_logado() {
        if ( is_user_logged_in() ) {
            /* exibir menu 'distribuidor' */
            echo '<div class="menu-distribuidor">';
                echo '<div class="container menu-dist-box">';
                    echo '<div>';
                        echo ''. wp_get_current_user()->user_firstname . ', você é um <strong>distribuidor Sonotto Pro</strong>';
                    echo '</div>';
                    echo '<nav>';
                        wp_nav_menu( array( 'theme_location' => 'distribuidor' ) );
                    echo '</nav>';
                    echo '<a class="menu-dist-logout" href="' . wp_logout_url( get_permalink() ) . '/loja">Fazer Logout</a></div>';
                echo '</div>';
            echo '</div>';
        }
    }
    add_action( 'wp_head', 'distribuicao_exibir_menu_usuario_logado' );

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

    /* Se "_unidade_medida_produto" for "Caixas", então exibe o texto "por caixa" no preço */

    function distribuicao_exibir_preco_por_caixa( $price, $product ) {
        $unidade_medida_produto = get_post_meta( $product->get_id(), '_unidade_medida_produto', true );
        if ( $unidade_medida_produto == 'Caixas' ) {
            $price = $price . ' <i>por caixa</i>';
        }
        return $price;
    }

    add_filter( 'woocommerce_get_price_html', 'distribuicao_exibir_preco_por_caixa', 10, 2 );

    /* Registrar Tipo de Post Slide */

    register_post_type( 'slides',
        array(
            'labels' => array(
                'name'          => __( 'Slides', 'textdomain' ),
                'singular_name' => __( 'Slide', 'textdomain' )
            ),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'public'      => true,
            'has_archive' => false,
            'menu_icon'   => 'dashicons-heart',
        )
    );

    /* No Post Type "slides" criar um Custom Field com o nome de link de página */

        function add_custom_meta_box() {
            add_meta_box(
                'slide_link_slide', // $id
                'Link do Slide', // $title
                'show_custom_meta_box', // $callback
                'slides', // $screen
                'normal', // $context
                'high' // $priority
            );
        }

        add_action( 'add_meta_boxes', 'add_custom_meta_box' );

        function show_custom_meta_box() {
            global $post;
            $meta = get_post_meta( $post->ID, 'link_slide', true ); ?>
            <input type="text" name="link_slide" id="link_slide" value="<?php echo $meta; ?>">
            <?php
        }

        function save_custom_meta( $post_id ) {
            if ( isset( $_POST['link_slide'] ) ) {
                update_post_meta( $post_id, 'link_slide', $_POST['link_slide'] );
            }
        }

        add_action( 'save_post', 'save_custom_meta' );



    /* Carrrega JS do Slide */
    function load_js()
    {
        wp_enqueue_script('jquery');

        /* Call slick library */
        wp_register_script('slick', get_stylesheet_directory_uri() . '/slick/slick.min.js', 'jquery', false, true);
        wp_enqueue_script('slick');

        wp_register_script('slider', get_stylesheet_directory_uri() . '/js/slider.js', 'jquery', false, true);
        wp_enqueue_script('slider');

    }
    add_action('wp_enqueue_scripts', 'load_js');
   
?>