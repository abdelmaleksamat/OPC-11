<?php
function theme_enqueue_styles()
{
    // wp_enqueue_style('parent-style' , get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style' , get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script( 'scripJs', get_stylesheet_directory_uri() . '/js/script.js', array() );
    wp_localize_script('scripJs', 'ajax_admin', array('ajax_url' => admin_url('admin-ajax.php')));

    if( is_single() ){
        wp_enqueue_script( 'singleJs', get_stylesheet_directory_uri() . '/js/single.js', array() );
    }
    
}
function charger_plus() { 
    $args = array(
		'orderby' => 'date',
		'post_type' => 'photo',
		'posts_per_page' => 8, // 8 articles,
        'paged' => 2
	);
	// 2. On exécute la WP Query

    $query = new WP_Query($args);

    if($query->have_posts()): ?>
        <?php while ($query->have_posts()): $query->the_post(); ?>

        <?php   
        
        // image de chaque post
        $image_url = get_the_post_thumbnail_url();
        // Récupère le texte alternatif de l'image.
        $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true); 

        $post_id = get_post_meta(get_the_ID(), 'reference', true);

        ?>
            <!---- metre dans une template     ---->
             <!----<article class="card">-->
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
        <?php endwhile; 
        wp_reset_query();
        
        wp_die();
        endif; 


 }             

function handle_filter() {

    $categorie = $_POST['categorie'];
    $format = $_POST['format'];
    $date = $_POST['date'];

    // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
	$args = array(
		'orderby' => 'date',
		'post_type' => 'photo',
		'posts_per_page' => -1,
        'tax_query'=> []
	);

    // 1.2  on ajoute de type de filtres (categories, format ou dates)
    if(!empty($categorie)){
        $args['tax_query'][] = [
            'taxonomy'=> 'categorie', 
            'field'=> 'slug',
            'terms' => $categorie 
        ];
    }
    if(!empty($format)){
        $args['tax_query'][] = [
            'taxonomy'=> 'format', 
            'field'=> 'slug',
            'terms' =>  $format 
        ];
    }

    if(!empty($date) && $date == "recent" ){
        $args['order'] = 'ASC';
    }
    if(!empty($date) && $date == "ancient" ){
        $args['order'] = 'DESC';
    }

	// 2. On exécute la WP Query

    $query = new WP_Query($args);

    

    if($query->have_posts()):
        while ($query->have_posts()): $query->the_post(); 
        

        // image de chaue post
        $image_url = get_the_post_thumbnail_url();
        // Récupère le texte alternatif de l'image.
        $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true); 

        $post_id = get_post_meta(get_the_ID(), 'reference', true);
        
        
        
        
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
    <?php    endwhile;
    endif;

    wp_reset_postdata();
    wp_die();
}


// charger les phtos asociée
function photos_associe(){

    $categorie = $_POST['categorie']; 

    $args = array(
            'orderby' => 'date',
            'post_type' => 'photo',
            'posts_per_page' => 2,
            'tax_query'=> []
        );
        $args['tax_query'][] = [
            'taxonomy'=> 'categorie', 
            'field'=> 'slug',
            'terms' => $categorie 
        ];

    $query = new WP_Query($args);    

    if($query->have_posts()):
        while ($query->have_posts()): $query->the_post(); 
        

        // image de chaue post
        $image_url = get_the_post_thumbnail_url();
        // Récupère le texte alternatif de l'image.
        $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true); 

        $post_id = get_post_meta(get_the_ID(), 'reference', true);
        
        
        
        
        ?>


    <!---- metre dans une template     ---->
    <article class="card">
                <img class="post_img" src="<?php echo $image_url ?>" alt="<?php echo $image_alt?>" data-imgId="<?php echo $post_id ?>">
                <div class="overlay" >
                    <a href="<?php echo get_permalink(); ?>">
                        <img class="eye-icon" alt="button-eye" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_eye.png'  ?>" >
                    </a>
                    <a href="<?php echo get_permalink(); ?>">
                        <img class="icon-fullscreen" alt="fullscreen" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_fullscreen.png'  ?>" >
                    </a>
                
                    <div class="text_overlay" >
                    <h3 class="title"> <?php  echo the_title() ?></h3>
                    <span><?php echo the_terms(get_the_ID(), 'categorie', false); ?></span>
                    </div>
                </div>
    </article>

    <?php    endwhile;
    endif;

    wp_reset_postdata();
    wp_die();

}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// trater la action 'filter'
add_action('wp_ajax_filter', 'handle_filter');
add_action('wp_ajax_nopriv_filter', 'handle_filter');

//  CHARGER PLUS
add_action('wp_ajax_charger_plus', 'charger_plus');
add_action('wp_ajax_nopriv_charger_plus', 'charger_plus');

// charger_les_photos_associe
add_action('wp_ajax_charger_les_photos_associe', 'photos_associe');
add_action('wp_ajax_nopriv_charger_les_photos_associe', 'photos_associe');


// Ajout de Fancybox pour afficher la lightbox
function enqueue_fancybox() {
    // Inclure le CSS de Fancybox
    wp_enqueue_style('fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');

    // Inclure le JavaScript de Fancybox
    wp_enqueue_script('fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('jquery'), null, true);

    // Initialiser Fancybox
    wp_add_inline_script('fancybox-js', '
    function initFancybox() {
        jQuery(".fancybox").fancybox({
            buttons : [
                "close"
            ],
            showNavArrows : false,
            arrows : false,
            infobar: false,
            touch: false,
            loop: true,
            clickContent: false,
            baseClass: "fancybox-custom-layout",
            afterShow: function(instance, slide) {
                console.log("Fancybox is working!");
            }
        });
    }

    jQuery(document).ready(function() {
        initFancybox();
    });

    jQuery(document).ajaxComplete(function() {
        initFancybox();
    });
');
}
add_action('wp_enqueue_scripts', 'enqueue_fancybox');


// Ajouter une nouvelle taille d'image personnalisée
add_action('after_setup_theme', function() {
    add_image_size('custom-size', 563, 844, true); // true pour recadrer l'image aux dimensions exactes
});

    function enqueue_carousel_assets() {
        wp_enqueue_style('carousel-css', get_stylesheet_directory_uri() . '/style.css');
        wp_enqueue_script('carousel-js', get_stylesheet_directory_uri() . '/js/carousel.js', array(), null, true);
    }
    add_action('wp_enqueue_scripts', 'enqueue_carousel_assets');
    wp_enqueue_script( 'carrousel.js', get_stylesheet_directory_uri() . '/js/carrousel.js', array() );
   





    function my_theme_enqueue_scripts() {
        wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/scripts.js', array(), null, true);
    }
    add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');
    