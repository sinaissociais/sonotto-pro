<?php
   function carrega_estilos_tema() {
       wp_enqueue_style( 'sonotto', get_template_directory_uri() . '/css/sonotto.css' );
       wp_enqueue_style( 'sonotto-pro', get_stylesheet_directory_uri() . '/css/sonotto-pro.css', array( 'sonotto' ) );
   }

   /* Carregar js na pasta /js/burger.js */

    function carrega_scripts_tema() {
         wp_enqueue_script( 'burger', get_stylesheet_directory_uri() . '/js/burger-pro.js', array( 'jquery' ), '1.0.0', true );
    }
    add_action( 'wp_enqueue_scripts', 'carrega_scripts_tema' );

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

    // Registrar Tipo de Usuário como "MEI"
   function add_role_parceiro_mei() {
        add_role(
            'parceiro_mei',
            __( 'MEI' ),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => false,
                'delete_posts' => false, // Use false to explicitly deny
            )
        );
    }
    add_action( 'init', 'add_role_parceiro_mei' );

    /* Script para deletar um User Role do Administrador */

        /* function delete_role_parceiro_distribuicao() {
            remove_role( 'parceiro_distribuicao' );
        }

        add_action( 'init', 'delete_role_parceiro_distribuicao' ); */



    // Registrar menu distribuidor

        function distribuicao_registrar_menu() {
            register_nav_menu( 'distribuidor', __( 'Menu Distribuidor', 'sonotto-pro' ) );
        }

        add_action( 'init', 'distribuicao_registrar_menu' );

    // Registrar menu Mobile

        function distribuicao_registrar_menu_mobile() {
            register_nav_menu( 'menu_mobile', __( 'Menu Mobile', 'sonotto-pro' ) );
        }

        add_action( 'init', 'distribuicao_registrar_menu_mobile' );

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
            echo '<div class="distribuicao_mensagem_login"><p>Entre com sua <strong>conta de distribuidor</strong> para ver os preços e realizar seus pedidos</p> ';
            /* formulário de login */
            echo '<div class="distribuicao_form_login">';
            echo '<form action="'. get_home_url().'/wp-login.php" method="post">';
            echo '<input type="text" name="log" placeholder="Usuário" required>';
            echo '<input type="password" name="pwd" placeholder="Senha" required>';
            echo '<input type="submit" class="botao-login-produto" value="Entrar">';
            echo '<input type="hidden" name="redirect_to" value="'. get_permalink() . '">';
            echo '</form>';
            echo '';
            echo '</div>';

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

     /* Cria um "Custom Field" no WooCommerce Product para exibir preço para parceiro_distribuidor */

        function distribuicao_criar_custom_field_preco_parceiro_distribuidor() {
            woocommerce_wp_text_input(
                array(
                    'id'          => 'preco_parceiro_distribuidor',
                    'label'       => __( 'Preço para Parceiro Distribuidor', 'woocommerce' ),
                    'placeholder' => '',
                    'desc_tip'    => 'true',
                    'description' => __( 'Insira o preço para o Parceiro Distribuidor', 'woocommerce' ),
                    /* exibir centavos conforme moeda brasileira */
                    'custom_attributes' => array(
                        'step' 	=> 'any',
                        'min'	=> '0'
                    )               
                )
            );
        }

        add_action( 'woocommerce_product_options_pricing', 'distribuicao_criar_custom_field_preco_parceiro_distribuidor' );

        function distribuicao_salvar_custom_field_preco_parceiro_distribuidor( $post_id ) {
            $preco_parceiro_distribuidor = $_POST['preco_parceiro_distribuidor'];
            update_post_meta( $post_id, 'preco_parceiro_distribuidor', esc_attr( $preco_parceiro_distribuidor ) );
        }

        add_action( 'woocommerce_process_product_meta', 'distribuicao_salvar_custom_field_preco_parceiro_distribuidor' );

    // Teste
    //

    // Hooks for simple, grouped, external and variation products
    add_filter('woocommerce_product_get_price', 'ui_custom_price_role', 99, 2 );
    add_filter('woocommerce_product_get_regular_price', 'ui_custom_price_role', 99, 2 );
    add_filter('woocommerce_product_variation_get_regular_price', 'ui_custom_price_role', 99, 2 );
    add_filter('woocommerce_product_variation_get_price', 'ui_custom_price_role', 99, 2 );
    function ui_custom_price_role( $price, $product ) {
        $price = ui_custom_price_handling( $price, $product );  
        return $price;
    }
    
    // Variable (price range)
    add_filter('woocommerce_variation_prices_price', 'ui_custom_variable_price', 99, 3 );
    add_filter('woocommerce_variation_prices_regular_price', 'ui_custom_variable_price', 99, 3 );
    function ui_custom_variable_price( $price, $variation, $product ) {
        $price = ui_custom_price_handling( $price, $product );  
        return $price;
    }
    
    //the magic happens here
    function ui_custom_price_handling($price, $product) {
    // Delete product cached price, remove comment if needed
    //wc_delete_product_transients($variation->get_id());
    
    //get our current user
    $current_user = wp_get_current_user();
    
    //check if the user role is the role we want
    if ( isset( $current_user->roles[0] ) && '' != $current_user->roles[0] && in_array( 'parceiro_distribuidor',  $current_user->roles ) ) {
        
        //load the custom price for our product
        $custom_price = get_post_meta( $product->get_id(), 'preco_parceiro_distribuidor', true );
        
        //if there is a custom price, apply it
        if ( ! empty($custom_price) ) {
            $price = $custom_price;
        }
    }
    
    return $price;

    }

    /* Tornar Post Type "Ajuda" acessível somente para usuários que fizeram login */

    add_action( 'template_redirect', 'redirect_to_login_ajuda' );
    function redirect_to_login_ajuda() {
        if ( is_singular( 'ajuda') && !is_user_logged_in() ) {
            wp_redirect( home_url('/login') );
                exit;
        }
    }

    /* Tornar postagens do blog acessível somente para usuários que fizeram login */

    add_action( 'template_redirect', 'redirect_to_login_blog' );

    function redirect_to_login_blog() {
        if ( is_singular( 'post') && !is_user_logged_in() ) {
            wp_redirect( home_url('/login') );
                exit;
        }
    }

    // Remover a Tag de preços do SEO Google - WooCommerce

    function custom_remove_price_from_google_search( $data ) {
    // Verifica se a página é um produto individual do WooCommerce
        if ( is_singular( 'product' ) ) {
            // Remove a tag de meta que exibe o preço
            unset( $data['offer'] );
        }
        return $data;
    }
    add_filter( 'woocommerce_structured_data_product_offer', 'custom_remove_price_from_google_search' );

    
    // Remove o "price" para usuários não logados no site

    function custom_modify_structured_data( $markup, $product ) {
    // Verifica se o usuário está logado
        if ( is_user_logged_in() ) {
            return $markup; // Mantém os dados inalterados
        } else {
            // Remove a informação de preço do contexto "@context"
            $markup = preg_replace('/,"price":{.*?}}/s', '', $markup);
            return $markup;
        }
    }
    add_filter( 'woocommerce_structured_data_product', 'custom_modify_structured_data', 10, 2 );


   
?>