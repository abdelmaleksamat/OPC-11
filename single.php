<!-- Template pour l' affichage des post et ses détails -->

<?php get_header(); ?>
<!-- Boucle WordPress -->
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<!-- have_posts() : Vérifie s'il y a des posts à afficher.
the_post() : Initialise le post actuel dans la boucle -->


<section class="main-content-single">
            <div class="post-thumbnail">
                <?php the_post_thumbnail('custom-size', array('class' => 'img-single')); ?>
            </div>

            <div class="single-details">
                <h2><?php echo get_the_title() ?></h2>
                <ul>
                    <li>Référence : <span class="post_reference"><?php echo get_field('Reference') ?></span></li>
                    <li class="post_category">Catégorie : <?php echo the_terms(get_the_ID(), 'categorie', false); ?></li>
                    <li>FORMAT : <?php echo the_terms(get_the_ID(), 'format', false); ?></li>
                    <li>Type : <?php echo get_field('type') ?></li>
                    <li>ANNÉE : <?php the_date('Y'); ?></li>
                </ul>
            </div>
</section>

<section class="contact-carrousel">
            <div class="contact-btn">
                <h4>Cette photo vous intéresse ?</h4>
                <button id="open-modal">Contact</button>
            </div> 

            <div class="interaction-photo__navigation">
                <?php
                $prevPost = get_previous_post();
                $nextPost = get_next_post();
                ?> 

                <div class="prev-next-images">   
                    <?php echo get_the_post_thumbnail( $prevPost, [ 100, 100 ] ); ?>
                    <?php echo get_the_post_thumbnail( $nextPost, [ 100, 100 ] ); ?>
                </div>
                
                
                <div class="navigation-arrows">
                    
                    <?php if (!empty($prevPost)) : $prevLink = get_permalink($prevPost); ?>
                        <a id="arrow-left" href="<?= $prevLink; ?>">
                            <img class="arrow-left" src="<?= get_template_directory_uri(); ?>/assets/left.png" alt="Flèche gauche" />
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($nextPost)) : $nextLink = get_permalink($nextPost); ?>
                        <a id="arrow-right" href="<?= $nextLink; ?>">
                            <img class="arrow-right" src="<?= get_template_directory_uri(); ?>/assets/right.png" alt="Flèche droite" />
                        </a>
                    <?php endif; ?>
                </div>
            </div>
</section>

        
<section class="suggested-photo-container">
            <h3>Vous aimerez AUSSI</h3>
            <div class="photo-suggestions">
                <!-- Récupération des photos de même catégorie avec WP_query -->
            </div>
            <div class="all-photos-btn">
                <!-- Bouton pour afficher toutes les photos -->
                 <a href="/">
                    <button id="button-photos">Toutes les photos</button>
                </a>
            </div>
            </div>
</section>
    </div>
<?php 
endwhile; 
endif;
?>

<?php get_footer(); ?>