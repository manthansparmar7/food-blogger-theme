<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */
function recipe_delight_setup() {
	/*
    * Make theme available for translation.
    */
	load_theme_textdomain( 'recipe-delight', get_template_directory() . '/languages' );

	/*
    * Let WordPress manage the document title.
    */
	add_theme_support( 'title-tag' );

	/*
    * Enable support for Post Thumbnails on posts and pages.
    */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'recipe-delight' ),
		)
	);

	/*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	/**
	 * Add support for core custom logo.
	 *
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'recipe_delight_setup' );


/**
 * Register Sidebar to showcase Recipe Categories.
 *
 */
function recipe_delight_register_sidebar() {
    register_sidebar( array(
        'name'          => __( 'Recipe Categories Sidebar', 'recipe-delight' ),
        'id'            => 'recipe-categories-sidebar',
        'description'   => __( 'Sidebar displaying recipe categories', 'recipe-delight' ),
        'before_widget' => '<div class="widget recipe-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'recipe_delight_register_sidebar' );

/**
 * Enqueue scripts and styles.
 */
function recipe_delight_scripts() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' , array(), '5.3.0', 'all' );

    // Enqueue Custom CSS
    wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0', 'all' );

    // Enqueue Custom JS
    wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), null, true );

    // localize ajax url and nonce
    wp_localize_script( 'custom-js', 'ajax_object', array(
        'url' => admin_url( 'admin-ajax.php' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'recipe_delight_scripts' );

/**
 * Register Custom post type Recipes.
 */
function rd_register_recipe_post_type() {
    register_post_type('recipe', 
        array(
            'labels' => array(
                'name' => __('Recipes'),
                'singular_name' => __('Recipe'),
                'add_new' => __('Add New'),
                'add_new_item' => __('Add New Recipe'),
                'edit_item' => __('Edit Recipe'),
                'new_item' => __('New Recipe'),
                'view_item' => __('View Recipe'),
                'search_items' => __('Search Recipes'),
                'not_found' => __('No recipes found'),
                'not_found_in_trash' => __('No recipes found in Trash'),
                'all_items' => __('All Recipes'),
                'menu_name' => __('Recipes'),
                'name_admin_bar' => __('Recipe'),
            ),
            'public' => true,
            'has_archive' => true,
			'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'recipe'), // Slug for the custom post type
			'menu_icon' => 'dashicons-food', // Dashicon for the menu item
        )
    );
}
add_action('init', 'rd_register_recipe_post_type');

/**
 * Register custom taxonomy 'recipe_category' for the 'recipe_delight' post type
 */
function rd_register_recipe_category_taxonomy() {
    register_taxonomy(
        'recipe_category', // Taxonomy name
        'recipe', // Associated custom post type
        array(
            'labels' => array(
                'name' => __('Recipe Categories'),
                'singular_name' => __('Recipe Category'),
                'search_items' => __('Search Recipe Categories'),
                'all_items' => __('All Recipe Categories'),
                'parent_item' => __('Parent Recipe Category'),
                'parent_item_colon' => __('Parent Recipe Category:'),
                'edit_item' => __('Edit Recipe Category'),
                'update_item' => __('Update Recipe Category'),
                'add_new_item' => __('Add New Recipe Category'),
                'new_item_name' => __('New Recipe Category Name'),
                'menu_name' => __('Recipe Categories'),
            ),
            'hierarchical' => true, // This makes the taxonomy hierarchical (like categories in WordPress)
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'recipe-category', // URL slug for the taxonomy
                'with_front' => false,
            ),
            'show_in_rest' => true, // This ensures compatibility with the block editor (Gutenberg)
        )
    );
}
add_action('init', 'rd_register_recipe_category_taxonomy');

/**
 * Register custom meta boxes 'Ingredients List' and 'Preparation Steps'  for
 * the 'recipe' post type
 */
function recipe_delight_add_meta_boxes() {
    add_meta_box(
        'recipe_delight_ingredients',   // ID
        'Ingredients List',           // Title
        'recipe_delight_ingredients_callback',  // Callback function
        'recipe',                       // Post type
        'normal',                       // Context
        'default'                       // Priority
    );
    
    add_meta_box(
        'recipe_delight_preparation',   // ID
        'Preparation Steps',     // Title
        'recipe_delight_preparation_callback', // Callback function
        'recipe',                       // Post type
        'normal',                       // Context
        'default'                       // Priority
    );
}

add_action( 'add_meta_boxes', 'recipe_delight_add_meta_boxes' );

//Call back functions for meta boxes
function recipe_delight_ingredients_callback( $post ) {
    // Get current value for ingredients if already saved
    $ingredients = get_post_meta( $post->ID, '_recipe_ingredients', true );

    // Output HTML and dynamically insert the saved value using PHP
    ?>
    <textarea name="recipe_ingredients" rows="5" style="width:100%;"><?php echo esc_textarea( $ingredients ); ?></textarea>
    <?php
}

function recipe_delight_preparation_callback( $post ) {
    // Get current value for preparation steps if already saved
    $preparation = get_post_meta( $post->ID, '_recipe_preparation', true );

    // Output HTML and dynamically insert the saved value using PHP
    ?>
    <textarea name="recipe_preparation" rows="5" style="width:100%;"><?php echo esc_textarea( $preparation ); ?></textarea>
    <?php
}

//Save functionality of metabox values into DB.
function recipe_delight_save_meta_boxes( $post_id ) {
    // Check if it's an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

    // Check if the user has permission to save
    if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;

    // Save ingredients
    if ( isset( $_POST['recipe_ingredients'] ) ) {
        update_post_meta( $post_id, '_recipe_ingredients', sanitize_textarea_field( $_POST['recipe_ingredients'] ) );
    }

    // Save preparation steps
    if ( isset( $_POST['recipe_preparation'] ) ) {
        update_post_meta( $post_id, '_recipe_preparation', sanitize_textarea_field( $_POST['recipe_preparation'] ) );
    }
}
add_action( 'save_post', 'recipe_delight_save_meta_boxes' );

/**
 * Added Shortcode for Recepie Grid Listing
 */
add_shortcode( 'recepie_listing',  'recipe_listing_shortcode_callback' );

function recipe_listing_shortcode_callback() { 
    ob_start(); ?>
        <div class="recipes_universal_container"></div>
    <?php return ob_get_clean();
}

/**
 * Ajax functionality for recipe posts listing with numeric pagination.
 */
add_action( 'wp_ajax_recipe_listing_ajax',  'recipe_listing_ajax_callback' );
add_action( 'wp_ajax_nopriv_recipe_listing_ajax',  'recipe_listing_ajax_callback' );

function recipe_listing_ajax_callback() { ?>
    <div class="recipe_listing">
        <?php
        // Sanitize and validate the page number
        $page = isset($_POST['page']) ? absint($_POST['page']) : 1;            $page = sanitize_text_field($_POST['page']);
        $cur_page = $page;
        $page -= 1;
        $per_page = 9;
        $start = $page * $per_page;

        // Pagination handling
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $recipes = new WP_Query(array(
            'post_type'      => 'recipe',
            'post_status'    => 'publish',
            'orderby'        => 'DATE',
            'order'          => 'DESC',
            'posts_per_page' => $per_page,
            'offset'         => $start,
        ));

        if ($recipes->have_posts()) : ?>
            <div class="row">
                <?php while ($recipes->have_posts()) : $recipes->the_post(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url(get_recipe_featured_image(get_the_ID(), 'medium')); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="no-content">
                <p class="alert alert-warning"><?php esc_html_e('No recipes found.', 'recipe-delight'); ?></p>
            </div>
        <?php endif; ?>

        <?php
        // Pagination logic
        $no_of_paginations = ceil($recipes->found_posts / $per_page);
        if ($no_of_paginations > 1) :
            $pages_to_show = 10; // Number of pages to display at once
            $start_page = max(1, $cur_page - floor($pages_to_show / 2));
            $end_page = min($no_of_paginations, $start_page + $pages_to_show - 1);

            // Ensure correct pagination window
            if ($end_page - $start_page < $pages_to_show - 1) {
                $start_page = max(1, $end_page - $pages_to_show + 1);
            }
        ?>

            <div class='recipes-universal-pagination'>
                <ul>
                    <?php if ($cur_page > 1) : ?>
                        <li p='<?php echo esc_attr($cur_page - 1); ?>' class='active'>
                            <?php esc_html_e('Previous', 'recipe-delight'); ?>
                        </li>
                    <?php else : ?>
                        <li class='inactive'><?php esc_html_e('Previous', 'recipe-delight'); ?></li>
                    <?php endif; ?>

                    <?php if ($start_page > 1) : ?>
                        <li p='1' class='active'>1</li>
                        <?php if ($start_page > 2) : ?>
                            <li class='inactive'>...</li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                        <li p='<?php echo esc_attr($i); ?>' class='<?php echo ((int) $cur_page === (int) $i) ? "selected" : "active"; ?>'>
                            <?php echo esc_html($i); ?>
                        </li>
                    <?php endfor; ?>

                    <?php if ($end_page < $no_of_paginations) : ?>
                        <?php if ($end_page < $no_of_paginations - 1) : ?>
                            <li class='inactive'>...</li>
                        <?php endif; ?>
                        <li p='<?php echo esc_attr($no_of_paginations); ?>' class='active'>
                            <?php echo esc_html($no_of_paginations); ?>
                        </li>
                    <?php endif; ?>

                    <?php if ($cur_page < $no_of_paginations) : ?>
                        <li p='<?php echo esc_attr($cur_page + 1); ?>' class='active'>
                            <?php esc_html_e('Next', 'recipe-delight'); ?>
                        </li>
                    <?php else : ?>
                        <li class='inactive'><?php esc_html_e('Next', 'recipe-delight'); ?></li>
                    <?php endif; ?>
                </ul>
            </div>

        <?php endif; ?>
    </div>
    <?php exit();
}

/**
 * Global function for post featured image is set or not
 */
function get_recipe_featured_image($post_id, $size = 'medium') {
    // Path to the dummy image inside your theme assets
    $dummy_image = get_template_directory_uri() . '/assets/images/dummy-image.jpg';

    // Return featured image if available, otherwise return the dummy image
    return has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, $size) : $dummy_image;
}