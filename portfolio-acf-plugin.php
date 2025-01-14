<?php
// Created by Michael Morales
// Plugin for Custom Post Type with ACF Integration

// Register Portfolio Custom Post Type
function custom_register_portfolio_post_type() {
    $args = array(
        'public' => true,
        'label' => 'Portfolios',
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    register_post_type('portfolio', $args);
}
add_action('init', 'custom_register_portfolio_post_type');

// ACF Fields Integration (assuming ACF is installed)
function custom_acf_register_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_portfolio',
            'title' => 'Portfolio Details',
            'fields' => array(
                array(
                    'key' => 'field_client_name',
                    'label' => 'Client Name',
                    'name' => 'client_name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_project_date',
                    'label' => 'Project Date',
                    'name' => 'project_date',
                    'type' => 'date_picker',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'portfolio',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'custom_acf_register_fields');

// Display ACF Fields in Portfolio
function custom_display_portfolio_acf_fields($content) {
    if (is_singular('portfolio')) {
        $client_name = get_field('client_name');
        $project_date = get_field('project_date');
        $content .= "<p><strong>Client Name:</strong> $client_name</p>";
        $content .= "<p><strong>Project Date:</strong> $project_date</p>";
    }
    return $content;
}
add_filter('the_content', 'custom_display_portfolio_acf_fields');
