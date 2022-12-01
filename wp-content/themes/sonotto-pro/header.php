<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php if ( is_category() ) {
            the_title(); echo " - "; bloginfo('name'); echo " - "; bloginfo('description');            
        } else {
            echo get_the_excerpt('', true);
        }
    ?>">




    <script src="https://kit.fontawesome.com/ca19e3e724.js" crossorigin="anonymous"></script>

    
    <?php wp_head();?>
</head>
<body>    
    <header>
        <?php if ( ! is_user_logged_in() ) { ?>
            <div class="menu-infos">
                <div class="container">
                    <div class="menu-infos-box">
                        <div>
                            <span>Cadastre-se e acesse preços e condições exclusivas  <a href="<?php echo get_home_url(); ?>/cadastro">Cadastrar</a></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="menu-navegacao container flex-box">
            <!-- Logo -->
            <a href="<?php echo get_home_url(); ?>" class="logo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo/logo-sonotto-pro.svg" width="250px" alt="<?php echo get_home_url(); ?>">
            </a>
            <div class="menu-box">

                <div class="menu-funcoes">
                    <div class="menu-pesquisa">
                        <?php get_search_form(); ?> 
                    </div>
                    <?php if ( is_user_logged_in() ) { ?>
                        <div class="menu-icones">
                            <!-- ícone usuário para login -->
                            <a href="<?php echo get_home_url(); ?>/minha-conta" class="menu-login">
                                Minha conta <i class="fa fa-user"></i>
                            </a>
                        </div>
                    <?php } else { ?>
                        <!-- ícone usuário para login -->
                        <a href="<?php echo get_home_url(); ?>/login" class="menu-login">
                            Fazer login <i class="fa fa-user"></i>
                        </a>
                    <?php } ?>
                    
                    <!-- ícone de carrinho que leva ao carrinho woocoommerce -->
                    <!-- se usuário estiver logado -->
                    <?php if ( is_user_logged_in() ) { ?>
                        <div class="menu-icones">
                            <!-- se plugin woocommerce estive ativo então exibir div -->
                            <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                                <a href="<?php echo get_home_url(); ?>/carrinho">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="carrinho-quantidade"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                
                <nav>
                    <!-- Menu -->
                    <ul id="menu-principal-a">
                        <?php
                            wp_nav_menu(
                                array(
                                'theme_location' => 'menu-topo',
                                )
                            );
                        ?>
                    </ul>
                    
                    <!-- Burger Menu -->
                    <a href="javascript:void(0);" class="icon" onclick="burgerMenuAla()">
                        <i class="fa fa-bars"></i>
                    </a>
                </nav>
            </div>
        </div>
    </header>