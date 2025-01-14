<?php
// Created by Michael Morales
class PortfolioCPTTest extends WP_UnitTestCase {
    public function test_portfolio_post_type_registered() {
        $this->assertTrue(post_type_exists('portfolio'));
    }

    public function test_acf_fields_exist() {
        $this->assertNotNull(get_field_object('client_name'));
        $this->assertNotNull(get_field_object('project_date'));
    }

    public function test_acf_field_values() {
        // Create a portfolio post
        $post_id = $this->factory->post->create(array('post_type' => 'portfolio'));
        update_field('client_name', 'Acme Corp', $post_id);
        update_field('project_date', '2025-01-01', $post_id);

        $client_name = get_field('client_name', $post_id);
        $project_date = get_field('project_date', $post_id);

        $this->assertEquals('Acme Corp', $client_name);
        $this->assertEquals('2025-01-01', $project_date);
    }
}
