<?php
$image_url = "";

// préparer la demande pour obtenir une seule image commandée au hasard
$args = array(
    'orderby' => 'rand', // random
    'post_type' => 'photo',
    'posts_per_page' => 1, // 1 une seule image par requete
);

$query = new WP_Query($args);    
    if($query->have_posts()): ?>
            <?php while ($query->have_posts()): $query->the_post(); ?>

            <?php   
            
            $image_url = get_the_post_thumbnail_url();
            endwhile; wp_reset_query();
            endif; 
?>


<div class="header-content">
    <img class="header-img" src="<?php echo esc_url($image_url); ?>" alt="Nathalie" />
    <div class="photographe-event">
        <h1>PHOTOGRAPHE EVENT</h1>
    </div>
</div>