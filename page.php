<?php
/**
 * The template for displaying all static pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
    get_header();
?>

<?php while( have_posts() ): ?>
    <?php the_post(); ?>
    <div class="content-container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <div class="container">
            <div class="actual-content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
<?php endwhile; ?> 
<?php get_footer(); ?>