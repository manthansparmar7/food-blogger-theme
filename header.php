<?php
/**
 * The Header template for the theme.
 *
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'recipe-delight' ); ?></a>

<header class="bg-light py-3">
    <div class="container text-center">
        <?php if (has_custom_logo()) : ?>
            <div class="site-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php the_custom_logo(); ?>
                </a>
            </div>
        <?php else : ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-dark text-decoration-none">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
        <?php endif; ?>
    </div>
</header>