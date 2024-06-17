.<!-- Template pour l' affichage d' une seul post et ses détails (ici uniquement pour les photos) -->

<?php get_header(); ?>

        
        <!-- section contact et carrousel miniature -->
        <section class="contact-carrousel">
            
            <div class="contact-btn">
                <h4>Cette photo vous intéresse ?</h4>
                <button id="boutonContact">Contact</button>
            </div> 

            <div class="interaction-photo__navigation">

                <div class="arrows">
                    <?php if (!empty($prevPost)) :                        
                            $prevLink = get_permalink($prevPost); ?>
                            <a id="arrow-left" href="<?= $prevLink; ?>">
                                <img class="arrow-gauche" src="<?= get_template_directory_uri(); ?>/assets/left.png" alt="Flèche pointant vers la gauche" />
                            </a>
                            <?php endif;
                            if (!empty($nextPost)) :
                                $nextLink = get_permalink($nextPost); ?>
                                <a href="<?= $nextLink; ?>">
                                    <img id="arrow-right" class="arrow-droite" src="<?= get_template_directory_uri(); ?>/assets/right.png" alt="Flèche pointant vers la droite" />
                                </a>
                    <?php endif; ?>
                </div>
                
                <div class="div-preview">
                    <div class="preview">
                        <?php if (!empty($prevPost)) :
                                $prevThumbnail = get_field( "photo" , $prevPost->ID );
                                $prevLink = get_permalink($prevPost); ?>
                                <a href="<?= $prevLink; ?>">
                                <img id="previous-image" class="previous-image" src="<?php echo $prevThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image précédente">
                                </a>
                        <?php endif; ?>
                    </div>

                    <div class="preview">
                        <?php if (!empty($nextPost)) :
                                    $nextThumbnail = get_field( "photo" , $nextPost->ID );                  
                                    $nextLink = get_permalink($nextPost);                            
                                    ?>
                                    <a href="<?= $nextLink; ?>">
                                    <img id="next-image" class="next-image" src="<?php echo $nextThumbnail["sizes"]["thumbnail"]; ?>" alt="Prévisualisation image suivante">
                                    </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- section photos apparentées -->
        <section class="suggested-photo-container">       
            <h3>Vous aimerez AUSSI</h3>
        
            <div class="photo-suggestions">
                <!-- récupération des photos de même catégorie avec WP_query -->
                <?php
                // arguments de la requête
                $args = array(
                    'post_type' => 'photo',
                    'posts_per_page' => 2, 
                    'orderby' => 'rand',
                    'post__not_in' => array($post->ID),
                    // affiche uniquement les photos de la même catégorie
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categorie',
                            'field'    => 'slug',
                            'terms'    => $categories ? $categories[0]->slug : [],
                        ),
                    ),

                );

                // création d' une nouvelle instance de WP_Query
                $query = new WP_Query($args);

                // boucle sur les résultats
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <?php get_template_part('templates_part/photo_block'); ?>
                        <?php
                    }
                }
                // réinitialisation de la requête
                wp_reset_postdata();
                ?>
            </div>

            <div class="all-photos-btn">
                <a href="<?php echo home_url(); ?>">
                    <button id="button-photos">Toutes les photos</button>
                </a>
            </div>

        </section>
    </div>


<?php get_footer(); ?>