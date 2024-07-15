<footer>
<?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu',
                'container' => false,
                'menu_class' => 'primary-menu',
                'fallback_cb' => '__return_false'
            ) );
            ?>
            
    <!-- <ul>
        <li><a href="/mention-legales/">Mentions Legales</a></li>
        <li><a href="/vie-privee/">Vie privée</a></li>
        <li><a href="/">Tout droits reserves</a></li>
    </ul> -->
    <?php get_template_part( 'partials/modal', 'part' ); ?>
    <?php get_template_part( 'partials/lightbox', 'part' ); ?>
</footer>
</body>
</html>