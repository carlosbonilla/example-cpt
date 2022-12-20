<?php
/*
Plugin Name: Example CPT 
Plugin URI: https://github.com/carlosbonilla/example-cpt
Description: A plugin that registers a Custom Post Type and exposes it through the wp-json/wp/v2 rest API.
Version: 1.0
Author: Carlos Bonilla
Author URI: https://www.isboli.com/
*/

if ( ! class_exists( 'cb_example_cpt' ) ) 
{
  class cb_example_cpt
  {
    function __construct()
    {
      add_action( 'init', array( $this, 'register_example_post_type' ) );
    }

    public function register_example_post_type()
    {
      $example_post_type_args = array(
                                  'label' => 'Example CPT',
                                  'labels' => array(
                                    'name' => __( 'Example CPT' ),
                                    'singular_name' => __( 'Example CPT' ),
                                    'add_new'=>'Add Example CPT',
                                    'add_new_item'=>'Add New Example CPT',
                                    'edit_item'=>'Edit Example CPT',
                                    'new_item'=>'New Example CPT',
                                    'view_item'=>'View Example CPT',
                                    'search_items'=>'Search Example CPT',
                                  ),
                                  'public' => true,
                                  'has_archive' => false,
                                  'rewrite' => array(
                                      'slug' => 'example-cpt'
                                  ),
                                );

      register_post_type( 'example-cpt', $example_post_type_args );
    }
  }

  new cb_example_cpt();
}