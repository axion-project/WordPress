<?php
// Created by Michael Morales
// Full-Site Editing Template Example with Advanced PHP Logic

// Register a custom template for the homepage
function custom_register_homepage_template() {
$template = array(
'title' => 'Homepage Template',
'slug' => 'homepage-template',
'content' => '<!-- wp:group {"align":"full"} -->
<div class="custom-homepage-group">
<!-- wp:heading --> <h1>Welcome to Our
Site</h1> <!-- /wp:heading -->
<!-- wp:paragraph --> <p>Explore our amazing
content!</p> <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->'
);

// Register the template
if ( ! get_page_by_path( 'homepage-template' ) ) {
wp_insert_post(array(
'post_title' => $template['title'],
'post_content' => $template['content'],
'post_name' => $template['slug'],
'post_status' => 'publish',
'post_type' => 'page',
));
}
}
add_action( 'after_setup_theme', 'custom_register_homepage_template' );