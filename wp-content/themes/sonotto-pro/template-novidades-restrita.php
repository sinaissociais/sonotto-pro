<?php

/*
Template Name: Página Novidades Restrita
*/

?>

<?php get_header();?>
    <!-- se o usuário não estiver logado -->
    <?php if( !is_user_logged_in() ): ?>
        <?php get_template_part('includes/components/section','login');?>
    <?php endif; ?>
    <!-- se estiver logado -->
    <?php if( is_user_logged_in() ): ?>
        <section class="blog-section">
            <div class="container padding-75">
                <div class="titulos">
                    <div>
                        <h2>Novidades</h2>
                    </div>
                    <div>
                        <p>Fique por dentro das nossas notícias e novidades, estaremos sempre trazendo informações relevantes para você!</p>
                    </div>
                </div>
                <div class="blog-grid">
                    <?php get_template_part('includes/components/arquivo','blog');?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php get_footer();?>