<?php

/*
Template Name: Página de Ajuda - Restrita
*/

?>

<?php get_header();?>
    <?php if( !is_user_logged_in() ): ?>
        <?php get_template_part('includes/components/section','login');?>
    <?php endif; ?>

    <!-- se estiver logado -->
    <?php if( is_user_logged_in() ): ?>
        <section class="ajuda-section">
            <div class="container padding-75">
                <div class="ajuda-titulos">
                        <h2>Ajuda & Suporte</h2>
                        <p>Encontre artigos e passo a passo de instalação de pisos e revestimentos de madeira natural.</p>
                </div>
                <div class="ajuda-colunas">
                    <div>
                        <div class="post-blocos">
                            <?php get_template_part('includes/components/arquivo','ajuda');?>
                        </div>
                    
                        <div class="arquivo-loadmore">
                            <button class="botao-redondo loadmore">Ver mais artigos...</button>
                        </div>
                        <!-- Load more post by ajax on click of button -->
                        <script>
                            jQuery(document).ready(function($) {
                                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                                var page = 2;
                                $('.loadmore').click(function() {
                                    var data = {
                                        'action': 'load_ajuda_by_ajax',
                                        'page': page,
                                        'security': '<?php echo wp_create_nonce("load_more_ajuda"); ?>'
                                    };
                                    /*  smooth revel new .professores-grid */
                                    $.ajax({
                                        url: ajaxurl,
                                        data: data,
                                        type: 'POST',
                                        beforeSend: function(xhr) {
                                            $('.loadmore').text('Carregando...');
                                        },
                                        success: function(data) {
                                            if (data != '') {
                                                $('.post-blocos').append(data);
                                                page++;
                                                $('.loadmore').text('Carregar mais artigos...');
                                            } else {
                                                $('.loadmore').text('Todos os artigos foram carregados!');
                                            }
                                        }
                                    });
                    
                    
                                });
                            });
                        </script>
                    </div>
                    <div>
                        <!-- Searchform para pesquisa no post type Ajuda -->
                        <?php get_template_part('includes/components/searchform','ajuda');?>
                        
                        <!-- Widget #Ajuda -->
                        <?php if ( is_active_sidebar( 'ajuda' ) ) : ?>
                                <?php dynamic_sidebar( 'ajuda' ); ?>               
                        <?php endif; ?>

                        <!-- Exibir lista de Categorias do post_type 'ajuda' -->
                        <?php $terms = get_terms( array(
                            'taxonomy' => 'assunto',
                            'hide_empty' => false,
                        ) ); ?>
                        <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                            <div class="widget widget_categories">
                                <h3 class="widget-title">Assuntos</h3>
                                <ul class="wp-block-categories-list wp-block-categories">
                                    <?php foreach ( $terms as $term ) { ?>
                                        <li class="cat-item cat-item-1">
                                            <a href="<?php echo get_term_link( $term ); ?>">
                                                <?php echo $term->name; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>            
            </div>
        </section>
    <?php endif; ?>
<?php get_footer();?>