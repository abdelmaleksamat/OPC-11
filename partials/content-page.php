<?php 
     //Définition des Arguments pour WP_Query	
    // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
	$args = array(
		'orderby' => 'date',
		'post_type' => 'photo',
		// 'meta_value' => 'mariage',
		'posts_per_page' => 8, // 8 articles,
        'paged' => 1
	);
	// 2. On exécute la WP Query

    $query = new WP_Query($args);

    //Récupération des Taxonomies
    $taxonomies = get_terms( array(
        'taxonomy'   => 'categorie',
        'hide_empty' => false,
    ));

    ?>

<!----   Formulaire de Filtres     ---->
<form class="form-filter">
    <div class="first-col">
        <div class="select">
            <span>
                <?php echo $taxonomies[0]->taxonomy; ?>
            </span>
            <ul class="select-options">    
                <?php foreach ($taxonomies as $taxonomie): ?>
                    <li class="select-li" data-filter='categorie' data-value="<?php echo $taxonomie->slug; ?>"><?php echo $taxonomie->name; ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php   
        $taxonomies = get_terms(array(
            'taxonomy'   => 'format',
            'hide_empty' => false,
        ));
        ?>
        <div class="select">
            <span>
                <?php echo $taxonomies[0]->taxonomy; ?>
            </span>
            <ul class="select-options">    
                <?php foreach ($taxonomies as $taxonomie): ?>
                    <li class="select-li" data-filter='format' data-value="<?php echo $taxonomie->slug; ?>"><?php echo $taxonomie->name; ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

    <div>
        <div class="select">
            <span>Trier par Date</span>
            <ul class="select-options">
                <li class="select-li" data-filter='date'  data-value="recent">Plus Ancienes</li>
                <li class="select-li" data-filter='date' data-value="ancient">Plus Récents</li>
            </ul>
        </div>
    </div>

</form>

<!----   Affichage des Photos   ---->

<div id="posts"class="filter">
    <!-----  contenu dynamique grâce à WP_QUERY à l'intérieur de card-template   --------->
<?
    
     if($query->have_posts()): ?>
        <?php while ($query->have_posts()): $query->the_post(); ?>

        <?php   
        
        // image de chaque post
        $image_url = get_the_post_thumbnail_url();
        // Récupère le texte alternatif de l'image.
        $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true); 

        $post_id = $post->ID;

        ?>
            <!---- metre dans une template     ---->
            <article class="card">
                <img class="post_img" src="<?php echo $image_url ?>" alt="<?php echo $image_alt ?>" data-imgId="<?php echo get_field('Reference') ?>">
                <div class="overlay">
                    <a href="<?php echo get_permalink(); ?>">
                        <img class="eye-icon" alt="button-eye" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_eye.png' ?>">
                    </a>
                    <a href="<?php echo get_permalink(); ?>">
                        <img class="icon-fullscreen" alt="fullscreen" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_fullscreen.png' ?>">
                    </a>
                    <div class="text_overlay">
                        <h3 class="title"><?php echo the_title() ?></h3>
                        <span><?php echo the_terms(get_the_ID(), 'categorie', false); ?></span>
                    </div>
                </div>
            </article>


        <?php endwhile; wp_reset_query();?>
    <?php endif; ?>


</div>

<!-- Bouton pour Charger Plus -->
<div class="more_btn">
    <button id="load_more">Charger plus</button>
</div>