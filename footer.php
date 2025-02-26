<?php
/**
 * The Footer template for the theme.
 *
 */
?>

<footer class="bg-light py-3 mt-5">
    <div class="container text-center">
        <p class="mb-2">
            <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
                <?php esc_html_e( 'Contact Us', 'recipe-delight' ); ?>
            </a> | 
            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">
                <?php esc_html_e( 'About', 'recipe-delight' ); ?>
            </a>
        </p>
        <p class="text-muted">
            &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php esc_html_e( 'Created by Manthan Parmar', 'recipe-delight' ); ?>. 
            <?php esc_html_e( 'All rights reserved.', 'recipe-delight' ); ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
