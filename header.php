<!DOCTYPE html>
<html  <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fite=no" />


</head>

<!----  body     ----->
<body <?php body_class(); ?>>

<!-- Structure HTML pour l'en-tête--> 
<header id="custom-header">
    <div class="header_container" id="site-navigation">
        <div class="logo">
            <a href="/">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/Nathalie-Mota.png' ?>" alt="Logo">
            </a>
        </div>

        <nav class="nav-links-container" id="primary-menu">
        <?php
          wp_nav_menu(array(
              'theme_location' => 'primary-menu',
              'container' => false,
              'menu_class' => 'primary-menu',
              'fallback_cb' => '__return_false'
          ));
      ?>
            <!-- <div class="menu-menu-du-header-container">
                <ul id="menu-menu-du-header" class="header-menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-17"><a href="/" aria-current="page">Accueil</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16"><a href="/a-propos">À propos</a></li>
                    <li  onclick="closeNav()" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-29">
                        <button class="contact_btn_menu">Contact</button>
                    </li>
                </ul>
            </div> -->
        </nav>

        
        <!-- Menu Burger (affiché uniquement sur les petits écrans) -->
        <div id="myNav" class="overlay">
            <div class="overlay-header">
                <a href="/">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/Nathalie-Mota.png' ?>" alt="Logo" class="overlay-logo">
                </a>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            </div>
            <div class="overlay-content">
            <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu-mobile',
                        'container' => false,
                        'menu_class' => 'primary-menu',
                        'fallback_cb' => '__return_false'
                    ));
                ?>
                <!-- <li>
                    <a onclick="closeNav()" href="/">Accueil hard</a>

                </li>
                <li>

                    <a onclick="closeNav()" href="/a-propos">À propos</a>
                </li>
                <li  onclick="closeNav()" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-29">
                    <button onclick="closeNav()" class="contact_btn_menu_mobile">Contact</button>
                </li> -->
            </div>
        </div>
    <span class="burger" onclick="openNav()">&#9776;</span>

    </div>
        <!-- <div class="menu">
            <ul id="menu-menu-du-header" class="header-menu">
                    <li onclick="closeNav()" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-7 current_page_item menu-item-17"><a href="/" aria-current="page">Acctjdfhgxfgnxfgnueil</a></li>
                    <li onclick="closeNav()" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16"><a href="/a-propos">À propos</a></li>
                    <li onclick="closeNav()" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-29">
                        <button class="contact_btn_menu">Contact</button>
                    </li>
            </ul>
        </div> 
    </div>-->
</header>


