<section class="slider">
    <ul class="slide-set">
        <?php $wp_query = new WP_Query(
                array(
                    'post_type' => 'slides',
                    'posts_per_page' => 9
                )); ?>
            <?php if( have_posts() ): while( have_posts() ): the_post();?>
                <li class="slide">
                    <div class="slide-content">
                        <span>Assunto #1</span>
                        <h2><?php the_title();?></h2>
                        <p><?php the_content();?></p>
                        <a href="<?php echo get_post_meta( get_the_ID(), 'link_slide', true ); ?>">
                            <button class="botao-redondo branco">
                                Saber mais
                                <svg width="14" height="12" viewBox="0 0 14 12" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.94148 11.0184C7.75223 11.2195 7.76181 11.536 7.9629 11.7252C8.16399 11.9145 8.48043 11.9049 8.66968 11.7038L13.7808 6.27324C13.962 6.08072 13.962 5.7804 13.7808 5.58788L8.66968 0.157319C8.48042 -0.0437681 8.16399 -0.0533564 7.9629 0.135901C7.76181 0.32516 7.75223 0.641597 7.94148 0.842684L12.4294 5.61111H0.5C0.223858 5.61111 0 5.83497 0 6.11111C0 6.38726 0.223858 6.61111 0.5 6.61111H12.0895L7.94148 11.0184Z"/>
                                </svg>
                            </button>
                        </a>
                    </div>
                    <img src="<?php echo get_the_post_thumbnail_url();?>" width="800" height="400" alt="Slide">
                </li>
            <?php endwhile; else: endif;?>
        <?php wp_reset_query();?>
    </ul>
    <ul class="bullet-set"></ul>
</section>