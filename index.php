<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package WordPress
 * @subpackage Default_Theme
 * @since Default Theme 1.0
 */

get_header(); ?>

<main id="primary" class="site-main container mt-5">

    <?php if ( have_posts() ) : ?>

        <header class="mb-4">
            <h1 class="page-title"><?php esc_html_e( 'Latest Posts', 'default-theme' ); ?></h1>
        </header>

        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', get_post_format() );
        endwhile;

        the_posts_pagination(
            array(
                'prev_text' => __( '&laquo; Previous', 'default-theme' ),
                'next_text' => __( 'Next &raquo;', 'default-theme' ),
            )
        );

    else :
        get_template_part( 'template-parts/content', 'none' );
    endif;
    ?>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>