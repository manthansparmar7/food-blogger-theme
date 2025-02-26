<?php
/**
 * Template for displaying single recipe posts
 */

get_header();

    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>

            <div class="container mt-5">
                <div class="row justify-content-center"> 
                    <!-- Centering the content -->
                    <div class="col-md-10 col-lg-8">
                        <!-- Adjusted column width -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <!-- Recipe Title -->
                            <h1 class="mb-3"><?php the_title(); ?></h1>

                            <!-- Featured Image -->
                            <div class="featured-image mb-4">
                                <img src="<?php echo esc_url(get_recipe_featured_image(get_the_ID(), 'large')); ?>" class="img-fluid rounded" alt="<?php the_title_attribute(); ?>">
                            </div>

                            <!-- Ingredients -->
                            <?php
                            $ingredients = get_post_meta( get_the_ID(), '_recipe_ingredients', true );
                            if ( ! empty( $ingredients ) ) :
                                ?>
                                <div class="mb-4">
                                    <h3><?php esc_html_e( 'Ingredients', 'recipe-delight' ); ?></h3>
                                    <p><?php echo nl2br( esc_html( $ingredients ) ); ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Preparation Steps -->
                            <?php
                            $preparation = get_post_meta( get_the_ID(), '_recipe_preparation', true );
                            if ( ! empty( $preparation ) ) :
                                ?>
                                <div class="mb-4">
                                    <h3><?php esc_html_e( 'Preparation Steps', 'recipe-delight' ); ?></h3>
                                    <p><?php echo nl2br( esc_html( $preparation ) ); ?></p>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>
                </div>
            </div>

            <?php
        endwhile;
    endif;
    
get_footer();
