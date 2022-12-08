<?php

/*
Template Name: Página Restrita
*/

?>

<?php get_header();?>
    <!-- se o usuário não estiver logado -->
    <?php if( !is_user_logged_in() ): ?>
        <?php get_template_part('includes/components/section','login');?>
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