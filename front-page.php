<?php
/*
* This is a Homepage template file that Display a grid of all recipes
* with their featured images and titles with Sidebar showcasing recipe categories.
*/
get_header();
?>
<div class="container mt-4"> 
    <div class="row">
        <!-- Grid of all recipes  -->
        <div class="col-md-8">
            <?php echo do_shortcode('[recepie_listing]'); ?>
        </div>
        <!-- Sidebar -->
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php
get_footer();
?>