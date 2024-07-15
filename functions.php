<?php
// Enregistrement des Styles et Scripts
function theme_enqueue_styles()
{
    wp_enqueue_style('child-style' , get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script( 'scripJs', get_stylesheet_directory_uri() . '/js/script.js', array() );
    wp_localize_script('scripJs', 'ajax_admin', array('ajax_url' => admin_url('admin-ajax.php')));

    if( is_single() ){
        wp_enqueue_script( 'singleJs', get_stylesheet_directory_uri() . '/js/single.js', array() );
    }
    
}

// register menus
function register_my_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu' ),
            'primary-menu-mobile' => __( 'Primary Menu Mobile' ),
            'footer-menu' => __( 'Footer Menu' )
        )
    );
}

// add contact_btn 
function contact_btn( $items, $args ) {
	//var_dump($items , $args);
    if($args->theme_location == "primary-menu"){
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94"><span role="button" class="contact_btn_menu">CONTACT</span></li>';
    }
    if($args->theme_location == "primary-menu-mobile"){
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94"><button role="button" class="contact_btn_menu_mobile">CONTACT</button></li>';
    }
    return $items;
}

// enregistre les menus
add_action( 'init', 'register_my_menus' );
// rajouter le button "contact"
add_filter( 'wp_nav_menu_items', 'contact_btn', 10, 2 );

// Fonction de Chargement Plus (Load More)

function charger_plus() { 
    $args = array(
		'orderby' => 'date',
		'post_type' => 'photo',
		'posts_per_page' => 8, // 8 articles,
        'paged' => 2
	);
	// 2. On exécute la WP Query
    // Crée une nouvelle requête WP_Query avec les arguments spécifiés dans $args
    $query = new WP_Query($args);

    // Vérifie si la requête a des posts
    if($query->have_posts()): ?>
    <!-- Démarre une boucle while pour parcourir tous les posts trouvés -->
    <?php while ($query->have_posts()): $query->the_post(); ?>
    
        <?php   
        // Récupère l'URL de la miniature de l'article actuel et la stocke dans $image_url
        $image_url = get_the_post_thumbnail_url();
        // Récupère le texte alternatif de l'image de la miniature
        $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true); 
        // Récupère la méta-donnée 'reference' de l'article actuel
        $post_id = get_post_meta(get_the_ID(), 'reference', true);

        ?>
            <!---- metre dans une template     ---->
             <!----<article class="card"> functions.php-->
             <article class="card">
                <img class="post_img" src="<?php echo $image_url ?>" alt="<?php echo $image_alt ?>" data-imgId="<?php echo get_field('Reference') ?>">
                <div class="overlay">
                    <a href="<?php echo get_permalink(); ?>">
                        <img class="eye-icon" alt="button-eye" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_eye.png' ?>">
                    </a>
                    <a href="JavaScript:void(0)">
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

// Fonction de Filtrage

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


// Charger les Photos Associées
// Charger les Photos Associées
function photos_associe(){
    $categorie = $_POST['categorie']; 
    $reference = $_POST['reference']; 

    $args = array(
        'orderby' => 'date',
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'post__not_in' => array($reference), // exclude la photo  --> ID - reference
        'tax_query'=> [
            [
                'taxonomy'=> 'categorie', 
                'field'=> 'slug',
                'terms' => $categorie 
            ]
        ]
    );

    $query = new WP_Query($args);    
    if($query->have_posts()):
        while ($query->have_posts()): $query->the_post(); 
            $image_url = get_the_post_thumbnail_url();
            $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true); 
            // $post_id = get_post_meta(get_the_ID(), 'reference', true);
            $post_id = get_field('Reference');
        ?>
        <article class="card-suggestions">
            <img class="post_img" src="<?php echo $image_url ?>" alt="<?php echo $image_alt?>" data-imgId="<?php echo $post_id ?>">
            <div class="overlay">
                <a href="<?php echo get_permalink(); ?>">
                    <img class="eye-icon" alt="button-eye" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_eye.png'  ?>">
                </a>
                <a href="javascript:void(0)" class="icon-fullscreen">
                    <img alt="fullscreen" src="<?php echo get_stylesheet_directory_uri() . '/assets/Icon_fullscreen.png'  ?>">
                </a>
                <div class="text_overlay">
                    <h3 class="title"><?php the_title(); ?></h3>
                    <span><?php echo the_terms(get_the_ID(), 'categorie', false); ?></span>
                </div>
            </div>
        </article>
        <?php 
        endwhile;
    endif;
    wp_reset_postdata();
    wp_die();
}


add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');
add_action('wp_enqueue_scripts', 'enqueue_carousel_assets');
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



// Ajouter une nouvelle taille d'image personnalisée
add_action('after_setup_theme', function() {
    add_image_size('custom-size', 563, 844, true); // true pour recadrer l'image aux dimensions exactes
});

// Inclusion de Scripts et Styles du Carrousel

    function enqueue_carousel_assets() {
        wp_enqueue_style('carousel-css', get_stylesheet_directory_uri() . '/style.css');
        wp_enqueue_script('carousel-js', get_stylesheet_directory_uri() . '/js/carousel.js', array(), null, true);
    }
   
   
// Inclusion de Scripts Personnalisés

    function my_theme_enqueue_scripts() {
        wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/scripts.js', array(), null, true);
    }
    
    wp_enqueue_script( 'carrousel.js', get_stylesheet_directory_uri() . '/js/carrousel.js', array() );

    function custom_post_type_photo() {
        $labels = array(
            'name'                  => _x( 'Photos', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'Photo', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'Photos', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'Photo', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Ajouter une photo', 'textdomain' ),
            'add_new_item'          => __( 'Ajouter une nouvelle photo', 'textdomain' ),
            'new_item'              => __( 'Nouvelle photo', 'textdomain' ),
            'edit_item'             => __( 'Modifier la photo', 'textdomain' ),
            'view_item'             => __( 'Voir la photo', 'textdomain' ),
            'all_items'             => __( 'Toutes les photos', 'textdomain' ),
            'search_items'          => __( 'Rechercher des photos', 'textdomain' ),
            'parent_item_colon'     => __( 'Photo parente:', 'textdomain' ),
            'not_found'             => __( 'Aucune photo trouvée.', 'textdomain' ),
            'not_found_in_trash'    => __( 'Aucune photo trouvée dans la corbeille.', 'textdomain' ),
            'featured_image'        => _x( 'Image mise en avant', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'Définir l’image mise en avant', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'Supprimer l’image mise en avant', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'Utiliser comme image mise en avant', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'Archives des photos', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insérer dans la photo', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Téléversé sur cette photo', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filtrer la liste des photos', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'Navigation de la liste des photos', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'Liste des photos', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'photo' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        );
    
        register_post_type( 'photo', $args );
    }
    
    add_action( 'init', 'custom_post_type_photo' );
    