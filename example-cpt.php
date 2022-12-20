<?php
/*
Plugin Name: Example CPT 
Plugin URI: https://github.com/carlosbonilla/example-cpt
Description: A plugin that registers a Custom Post Type and exposes it through the wp-json/wp/v2 rest API.
Version: 1.0
Author: Carlos Bonilla
Author URI: https://www.isboli.com/
Text Domain: cb-example-cpt
*/


if (!class_exists('cb_example_cpt')) {
  class cb_example_cpt
  {

    function __construct()
    {
      add_action('init', array($this, 'cb_register_example_post_type'));
    }

    /**
     * We're creating a new post type called "Example CPT" 
     * and registering it with WordPress
     */
    public function cb_register_example_post_type()
    {
      // Arguments need it for register the Custom Post Type
      $example_post_type_args = array(
        'label' => 'Example CPT',
        'labels' => array(
          'name'               => __('Example CPTs', 'cb-example-cpt'),
          'singular_name'      => __('Example CPT', 'cb-example-cpt'),
          'add_new'            => __('Add New', 'cb-example-cpt'),
          'add_new_item'       => __('Add New Example CPT', 'cb-example-cpt'),
          'edit'               => __('Edit', 'cb-example-cpt'),
          'edit_item'          => __('Edit Example CPT', 'cb-example-cpt'),
          'new_item'           => __('New Example CPT', 'cb-example-cpt'),
          'view'               => __('View Example CPT', 'cb-example-cpt'),
          'view_item'          => __('View Example CPT', 'cb-example-cpt'),
          'search_items'       => __('Search Example CPT', 'cb-example-cpt'),
          'not_found'          => __('No Example CPTs found', 'cb-example-cpt'),
          'not_found_in_trash' => __('No Example CPTs found in Trash', 'cb-example-cpt'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array(
          'slug' => 'example-cpt'
        )
      );

      register_post_type('example-cpt', $example_post_type_args);
    }
  }

  $example_custom_post_type = new cb_example_cpt();
}
