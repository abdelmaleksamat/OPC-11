<?php// Définir une action Ajax pour filtrer les images
add_action('wp_ajax_filter_images', 'filter_images_callback');
add_action('wp_ajax_nopriv_filter_images', 'filter_images_callback'); // Pour les utilisateurs non connectés

function filter_images_callback() {
    // Récupérer le paramètre de filtre envoyé par la requête Ajax
    $filter_value = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : '';

    // Utiliser WP_Query pour récupérer les images filtrées en fonction du paramètre de filtre
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => -1, // Récupérer toutes les images
        'tax_query'      => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $filter_value,
            ),
        ),
    );

    $query = new WP_Query($args);

    $images = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $image_url = get_the_post_thumbnail_url();
            $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true);
            $post_id = get_post_meta(get_the_ID(), 'reference', true);

            // Collecter les données de l'image dans un tableau
            $images[] = array(
                'url'      => $image_url,
                'alt'      => $image_alt,
                'id'       => $post_id,
                'title'    => get_the_title(),
                'category' => get_the_terms(get_the_ID(), 'categorie')[0]->name, // Exemple de récupération de la catégorie
            );
        }
    }

    // Renvoyer les données des images au format JSON
    wp_send_json($images);

    // Ne pas oublier de terminer la requête WP_Query
    wp_reset_postdata();

    // Arrêter l'exécution du script
    die();
}
?>