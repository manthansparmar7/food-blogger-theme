jQuery(document).ready(function($) {

    //Declare ajax function to load recipe posts
	function recipe_load_all_posts(page){
        $.ajax({
            type: 'POST',
            url: ajax_object.url, // The localized AJAX URL
            data: {
                page: page, 
                action: 'recipe_listing_ajax', // The action hook
            },
            success: function (result) {
				jQuery(".recipes_universal_container").show();                      									
				jQuery(".recipes_universal_container").html(result);
			}, 
        });

    }

    //Call the recipe posts load ajax function
    recipe_load_all_posts(1);

    //Pagination click event of recipe posts load ajax function
    jQuery(document).on("click", ".recipes-universal-pagination li.active", function (e) {
        e.preventDefault(); // Prevents the default action (jumping to top)
        
        var page = jQuery(this).attr('p');
        
        recipe_load_all_posts(page); // Load new posts via AJAX
        
        // Smooth scroll to the top of the recipes grid (optional)
        jQuery('html, body').animate({
            scrollTop: jQuery(".recipe_listing").offset().top - 30 // Adjust offset if needed
        }, 500);
    });
});