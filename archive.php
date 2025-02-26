<?php
/**
 * Template for displaying the recipe archive page
 */

get_header();
?>

<div class="container mt-5">
    <div class="row">
        <!-- Recipe Grid -->
        <div class="col-md-8">
            <h1 class="mb-4">
                <?php
                if ( is_tax( 'recipe_category' ) ) {
                    single_term_title( __( 'Recipe: ', 'recipe-delight' ) );
                } else {
                    esc_html_e( 'Recipes', 'recipe-delight' );
                }
                ?>
            </h1>

            <?php if ( have_posts() ) : ?>
                <div class="row">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url(get_recipe_featured_image(get_the_ID(), 'medium')); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php
                    echo paginate_links(
                        array(
                            'total'     => $wp_query->max_num_pages,
                            'current'   => max( 1, get_query_var( 'paged', 1 ) ),
                            'prev_text' => __( '« Prev', 'recipe-delight' ),
                            'next_text' => __( 'Next »', 'recipe-delight' ),
                        )
                    );
                    ?>
                </div>

            <?php else : ?>
                <p><?php esc_html_e( 'No recipes found.', 'recipe-delight' ); ?></p>
            <?php endif; ?>
        </div>

        <!-- Sidebar with Recipe Categories -->
        <aside class="col-md-4">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<?php
get_footer();
