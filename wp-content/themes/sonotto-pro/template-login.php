<?php

/*
Template Name: Login Distribuidor
*/

?>

<?php get_header();?>
    <section class="ajuda-section">
        <div class="container padding-75">
            <div class="ajuda-titulos">
                    <h2>
                        <?php the_title(); ?>
                    </h2>
                    <?php if( !is_user_logged_in() ): ?>
                        <?php the_content();?>
                    <?php endif; ?>
            </div>
            <div class="login-pagina-container">
                <!-- formulário login wordpress -->
                <?php if( !is_user_logged_in() ): ?>
                    <div class="ajuda-coluna-direita">
                        <div class="revenda-coluna-login">
                            <h3>Entrar</h3>
                            <form action="<?php echo get_home_url(); ?>/wp-login.php" method="post">
                                <input type="text" name="log" placeholder="Usuário" required>
                                <input type="password" name="pwd" placeholder="Senha" required>
                                <input type="submit" value="Entrar">
                            </form>
                        </div>
                        <div class="revenda-coluna-esqueceu">
                            <h3>Esqueceu sua senha?</h3>
                            <p>Insira seu e-mail e enviaremos um link para redefinir sua senha.</p>
                            <form action="<?php echo get_home_url(); ?>/wp-login.php?action=lostpassword" method="post">
                                <input type="email" name="user_login" placeholder="E-mail" required>
                                <input type="submit" value="Enviar">
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- else -->
                <?php if( is_user_logged_in() ): ?>
                    <div class="ajuda-coluna-direita">
                        <div class="ajuda-coluna-direita-box">
                            <h3>Olá, <?php echo wp_get_current_user()->user_login; ?></h3>
                            <p>Você já está logado em nosso sistema!</p>
                            <!-- se o usuário for "revendedor" -->
                            <?php if( in_array( 'parceiro_distribuidor', (array) wp_get_current_user()->roles ) ): ?>
                                <a href="<?php echo get_home_url(); ?>/loja" class="btn btn-azul">Acesse a Loja e faça seu pedido</a>
                            <?php endif; ?>
                            <!-- logout -->
                            <a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="btn btn-azul">Fazer Logout</a>
                        </div>
                    </div>
                <?php endif; ?>
                
            </div>            
        </div>
    </section>
<?php get_footer();?>