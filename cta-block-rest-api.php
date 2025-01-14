<?php
// Created by Michael Morales
// Register the block and expose custom REST API endpoints.
function custom_register_cta_block() {
    register_block_type(
        'custom/cta-block',
        array(
            'editor_script' => 'cta-block-editor-script',
        )
    );

    // REST API route for saving CTA analytics
    register_rest_route(
        'custom/v1',
        '/cta-click',
        array(
            'methods' => 'POST',
            'callback' => 'custom_handle_cta_click',
            'permission_callback' => '__return_true', // Publicly accessible for this example.
        )
    );
}
add_action('init', 'custom_register_cta_block');

// Enqueue editor script.
function custom_enqueue_cta_block_scripts() {
    wp_register_script(
        'cta-block-editor-script',
        plugins_url('/js/cta-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor'),
        '1.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'custom_enqueue_cta_block_scripts');

// Handle REST API request.
function custom_handle_cta_click($request) {
    $data = $request->get_json_params();
    $cta_id = sanitize_text_field($data['cta_id']);
    $click_count = get_option("cta_click_count_$cta_id", 0) + 1;
    update_option("cta_click_count_$cta_id", $click_count);

    return rest_ensure_response(array('status' => 'success', 'click_count' => $click_count));
}
