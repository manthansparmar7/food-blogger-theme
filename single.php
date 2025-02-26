<?php
/**
 * The template for displaying single posts
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
                <div class="entry-meta">
                    <span class="posted-on"><?php echo esc_html( get_the_date() ); ?></span> |
                    <span class="author"><?php esc_html_e( 'By', 'default-theme' ); ?> <?php the_author_posts_link(); ?></span>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail( 'large' ); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'default-theme' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <footer class="entry-footer">
                <?php the_tags( '<span class="tags-links">' . __( 'Tags: ', 'default-theme' ), ', ', '</span>' ); ?>
            </footer>
        </article>

        <?php
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
        ?>

    <?php endwhile; ?>
</main>

<?php
get_footer();