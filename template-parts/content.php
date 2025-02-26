<?php
/**
 * Template part for displaying posts
 *
 * @package WordPress
 * @subpackage Default_Theme
 * @since Default Theme 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <header class="entry-header">
        <?php if ( is_singular() ) : ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php else : ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
        <?php endif; ?>

        <div class="entry-meta">
            <span class="posted-on"><?php echo esc_html( get_the_date() ); ?></span> | 
            <span class="author"><?php esc_html_e( 'By', 'default-theme' ); ?> <?php the_author_posts_link(); ?></span>
        </div>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'large' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if ( is_singular() ) {
            the_content();
        } else {
            the_excerpt();
        }
        ?>
    </div>

    <footer class="entry-footer">
        <?php the_tags( '<span class="tags-links">' . __( 'Tags: ', 'default-theme' ), ', ', '</span>' ); ?>
    </footer>

</article>