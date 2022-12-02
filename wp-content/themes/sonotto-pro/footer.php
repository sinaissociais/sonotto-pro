<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>


<footer>

    <!-- Chat -->
    <div class="footer-chat whatsapp-chat-button">
        <div class="footer-chat-text">Fale com a gente</div>
        <a href="https://wa.me/5511945039098?text=Vim%20do%20site%20Sonotto" target="_blank" rel="noreferrer noopener"><img class="footer-chat-icon" src="<?php echo get_theme_file_uri();?>/images/social-whatsapp.svg" alt="Fale com a gente" /></a>
    </div>

    <!-- <div data-tf-popover="kLdhPJYc" data-tf-custom-icon="https://images.typeform.com/images/QDwA9Mpvsb3H" data-tf-button-color="#ffd65c" data-tf-notification-days="7" data-tf-tooltip="Oi 👋&nbsp;&nbsp;Como posso te ajudar?" data-tf-chat data-tf-medium="snippet" style="all:unset;"></div><script src="//embed.typeform.com/next/embed.js"></script> -->

    <!-- Especialistas -->
    <div class="footer-especialistas">
        <div class="container flex-box">
            <div class="footer-especialistas-grid">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/fotos/capacete-azul-sonotto.jpeg"  alt="<?php echo get_home_url(); ?>" class="footer-especialistas-img">
                <div class="footer-especialistas-box">
                    <h3>
                        Um pouco mais <br/>sobre a Sonotto
                    </h3>
                    <p>
                        Nascemos na última década com a vontade e objetivo de sermos uma <strong>referência em pisos e revestimento de madeira natural</strong> no país.
                    </p>
                    <p>
                        Ao longo dos anos e através de um trabalho intenso de profissionalização e desenvolvimento de nossa equipe, demonstramos a cada novo projeto nosso compromisso de longo prazo com a qualidade e o cuidado com a madeira e o meio ambiente. 
                    </p>
                    <a href="<?php echo get_home_url(); ?>/quem-somos">
                        <button class="botao-redondo">
                            Saber mais
                            <svg width="14" height="12" viewBox="0 0 14 12" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.94148 11.0184C7.75223 11.2195 7.76181 11.536 7.9629 11.7252C8.16399 11.9145 8.48043 11.9049 8.66968 11.7038L13.7808 6.27324C13.962 6.08072 13.962 5.7804 13.7808 5.58788L8.66968 0.157319C8.48042 -0.0437681 8.16399 -0.0533564 7.9629 0.135901C7.76181 0.32516 7.75223 0.641597 7.94148 0.842684L12.4294 5.61111H0.5C0.223858 5.61111 0 5.83497 0 6.11111C0 6.38726 0.223858 6.61111 0.5 6.61111H12.0895L7.94148 11.0184Z"/>
                            </svg>
                        </button>
                    </a>
                </div> 
            </div>
        </div>
    </div>
    <div class="container-super flex-box">
        <div class="footer-box-logo">
            <a href="">
                <div class="footer-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo/logo.svg" width="225px" alt="<?php echo get_home_url(); ?>">
                </div>
            </a>
        
            <!-- Widget #footer_1_contato -->
            <?php if ( is_active_sidebar( 'footer_1_contato' ) ) : ?>
                    <div id="footer_1_contato" class="footer_1_contato" role="complementary">
                        <?php dynamic_sidebar( 'footer_1_contato' ); ?>
                    </div>
            <?php endif; ?>

        </div>
        
        <div>
            <!-- Widget #footer_2 -->
            <?php if ( is_active_sidebar( 'footer_2' ) ) : ?>
                    <div id="footer_2" class="footer_2" role="complementary">
                        <?php dynamic_sidebar( 'footer_2' ); ?>
                    </div>
            <?php endif; ?>
        </div>
        <div>
            <!-- Widget #footer_3 -->
            <?php if ( is_active_sidebar( 'footer_3' ) ) : ?>
                    <div id="footer_3" class="footer_3" role="complementary">
                        <?php dynamic_sidebar( 'footer_3' ); ?>
                    </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-box-logo-background"></div>
    <div class="fsc-certificacao">
        <p>Procure por produtos certificados FSC®</p>
        <!-- carregar imagem da pasta imagems -->
        <img src="<?php echo get_template_directory_uri(); ?>/images/logo/fsc-certificado-sonotto.svg" alt="Selo de certificação FSC® da Sonotto">
    </div>

</footer>
<?php wp_footer();?>
</body>
</html>