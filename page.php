<?php
/**
 * Le template pour afficher toutes les pages statiques
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
get_header(); // Inclut le header de la page
?>

<!-- Boucle principale pour afficher le contenu de la page -->
<?php while( have_posts() ): ?>
    <?php the_post(); // Configure les données du post actuel ?>

    <!-- Conteneur principal du contenu -->
    <div class="content-container">
        <!-- Affiche le titre de la page -->
        <h1 class="page-title"><?php the_title(); ?></h1>
        
        <!-- Conteneur pour le contenu réel de la page -->
        <div class="container">
            <div class="actual-content">
                <!-- Affiche le contenu de la page -->
                <?php the_content(); ?>
            </div>
        </div>
    </div>
<?php endwhile; // Fin de la boucle ?>

<?php get_footer(); // Inclut le footer de la page ?>
