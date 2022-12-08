<?php get_header();?>

    <div class="box-titulo blog-titulo">
        <div class="container">
            <span>
                
                <a href="<?php echo esc_url(get_permalink( get_page_by_title( 'Novidades' ) ) ); ?>" class="link-voltar">
                    Novidades Sonotto Pro
                </a>

            <!-- exibir uma única categoria do post -->
            <?php
                $categories = get_the_category();
                $separator = ' + ';
                $output = '';
                if ( ! empty( $categories ) ) {
                    foreach( $categories as $category ) {
                        $output .= '| <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'Ver todos os posts em %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                    }
                    echo trim( $output, $separator );
                }
            ?>
            </span>
        </div>
    </div>
    
    <?php if( have_posts() ): while( have_posts() ): the_post();?>

        <div class="blog-content container padding-75">
            <div>
                <div class="blog-header-titulos">
                    <h1>
                        <?php the_title();?>
                    </h1>

                    <div class="blog-header-meta">
                        <span><?php the_time('j/m/y') ?> - <?php comments_number( '0 Comentários', '1 Comentário', '% Comentários' ); ?> - por: <?php the_author();?></span>
                    </div>

                    <!-- Categoria -->
                    <div class="blog-categorias">
                        <h5>Assuntos</h5>
                        <?php $categories = get_the_category();foreach ($categories as $cat):?>
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" >
                                <?php echo $cat->name;?>
                            </a>
                        <?php endforeach;?>
                    </div>
                    
                </div>

                <!-- Conteúdo -->
                <?php the_content();?>

                <!-- Categoria -->
                <div class="blog-categorias">
                    <h5>Assuntos</h5>
                    <?php $categories = get_the_category();foreach ($categories as $cat):?>
                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" >
                            <?php echo $cat->name;?>
                        </a>
                    <?php endforeach;?>
                </div>
               

                <!-- Comentários -->
                <div class="blog-comentarios">
                    <?php if ( comments_open() || get_comments_number() ) {comments_template();};?>
                </div>
            </div>
            <div>
                <?php get_sidebar(); ?>
            </div>
        </div>

    <?php endwhile; else: endif;?>
    <?php wp_reset_query();?> 

<?php get_footer();?>