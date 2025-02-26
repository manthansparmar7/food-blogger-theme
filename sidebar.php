<?php
/**
 * The sidebar containing the main widget area
 *
 *
 */
?>

<div class="sidebar p-4 bg-light rounded sticky-sidebar">
    <h4 class="mb-3"><?php esc_html_e( 'Recipe Categories', 'your-text-domain' ); ?></h4>
    <ul class="list-group">
        <?php
        $categories = get_terms(
            array(
                'taxonomy'   => 'recipe_category',
                'hide_empty' => true,
            )
        );

        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
            foreach ( $categories as $category ) :
                ?>
                <li class="list-group-item">
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                        <?php echo esc_html( $category->name ); ?>
                    </a>
                </li>
                <?php
            endforeach;
        else :
            ?>
            <li class="list-group-item"><?php esc_html_e( 'No categories available.', 'your-text-domain' ); ?></li>
        <?php endif; ?>
    </ul>
</div>

