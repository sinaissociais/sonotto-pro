<?php

/*
Template Name: Página Restrita
*/

?>

<?php get_header();?>
    <!-- se o usuário não estiver logado -->
    <?php if( !is_user_logged_in() ): ?>
        <section class="ajuda-section">
            <div class="container padding-75">
                <div class="login-pagina-container">
                    <div class="ajuda-coluna-direita">
                        <p>
                            Este conteúdo é registrito para usuários logados. Entre com seu e-mail e senha.
                        </p>
                        <div class="revenda-coluna-login">
                            <h3>Entrar</h3>
                            <form action="<?php echo get_home_url(); ?>/wp-login.php" method="post">
                                <input type="text" name="log" placeholder="Usuário" required>
                                <input type="password" name="pwd" placeholder="Senha" required>
                                <input type="submit" value="Entrar">
                                <!-- ao clicar no submit redirecionar para a página atual -->
                                <input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>">
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
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- se estiver logado -->
    <?php if( is_user_logged_in() ): ?>
        <?php if( have_posts() ): while( have_posts() ): the_post();?>

            <section class="pagina-servico">
                <div class="container container-page padding-75">
                    <div>
                        <?php the_content();?>
                    </div>
                </div>
                <div class="pagina-servico-bg"></div>
            </section>

        <?php endwhile; else: endif;?>
    <?php endif; ?>            

<?php get_footer();?>