<?php
/**
 * The template for displaying all pages
 *
 * @package WordPress
 * @subpackage Default_Theme
 * @since Default Theme 1.0
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'default-theme' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </article>

    <?php endwhile; ?>
</main>

<?php
get_footer();