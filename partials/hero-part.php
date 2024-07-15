<?php
$image_url = "";

// préparer la demande pour obtenir une seule image commandée au hasard
$args = array(
    'orderby' => 'rand', // random
    'post_type' => 'photo',
    'posts_per_page' => 1, // 1 une seule image par requete
);

// Crée une nouvelle requête WP_Query avec les arguments spécifiés dans $args
$query = new WP_Query($args);    

// Vérifie si la requête a des posts
if($query->have_posts()): ?>

  <!-- Démarre une boucle while pour parcourir tous les posts trouvés-->
    <?php while ($query->have_posts()): $query->the_post(); ?>

        <!-- Récupère l'URL de la miniature de l'article actuel et la stocke dans $image_url -->
        <?php   
        $image_url = get_the_post_thumbnail_url();
        endwhile; // Fin de la boucle while

        // Réinitialise la requête globale de WordPress
        wp_reset_query();
    endif; // Fin de la vérification des posts
?>

<!-- Crée une section de contenu d'en-tête -->
<div class="header-content">
    <!-- Affiche l'image de l'en-tête avec l'URL de la miniature récupérée -->
    <img class="header-img" src="<?php echo esc_url($image_url); ?>" alt="Nathalie" />

    <!-- Crée une section de texte pour le titre "PHOTOGRAPHE EVENT" -->
    <div class="photographe-event">
        <h1>PHOTOGRAPHE EVENT</h1>
    </div>
</div>
