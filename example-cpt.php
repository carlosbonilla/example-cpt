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

defined('ABSPATH') or die('Nope, Sorry not here.');

class Example_CPT
{

  function __construct()
  {
    add_action('init', array($this, 'register_example_post_type'));
    add_action('admin_init', array($this, 'add_role_capabilities'), 999);
  }

  /**
   * Anything that need to be run when the plugin is Activated
   */
  function activate()
  {
    $this->create_role();
    flush_rewrite_rules();
  }

  /**
   * Anything that need to be run when the plugin is Deactivated
   */
  function deactivate()
  {
    $this->remove_role();
    flush_rewrite_rules();
  }

  /**
   * Create a new post type called "Example CPT" and register it with WordPress
   */
  function register_example_post_type()
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

  /**
   * Creates new role called "Example CPT" with the ability to create, 
   * edit, and delete Example Custom Posts
   */
  function create_role()
  {
    $capabilities = array(
      'edit_post' => true,
      'read_post' => true,
      'delete_post' => true,
      'edit_posts' => true,
      'edit_others_posts' => true,
      'publish_posts' => true,
      'read_private_posts' => true,
      'read' => true,
      'delete_posts' => true,
      'delete_private_posts' => true,
      'delete_published_posts' => true,
      'delete_others_posts' => true,
      'edit_private_posts' => true,
      'edit_published_posts' => true,
      'create_posts' => true,
    );

    add_role('example_cpt_role', 'Example CPT', $capabilities);
  }


  /**
   * Removes the role 'example_cpt_role'
   */
  function remove_role()
  {
    remove_role('example_cpt_role');
  }

  /**
   * Adds the capabilities to the role
   */
  function add_role_capabilities()
  {
    $roles = array('example_cpt_role', 'administrator');

    foreach ($roles as $each_role) {
      $role = get_role($each_role);
      $role->add_cap('read');
      $role->add_cap('read_example_cpts');
      $role->add_cap('read_private_example_cpts');
      $role->add_cap('edit_example_cpts');
      $role->add_cap('edit_example_cpts');
      $role->add_cap('edit_others_example_cpts');
      $role->add_cap('edit_published_example_cpts');
      $role->add_cap('publish_example_cpts');
      $role->add_cap('delete_others_example_cpts');
      $role->add_cap('delete_private_example_cpts');
      $role->add_cap('delete_published_example_cpts');
    }
  }
}

if (class_exists('Example_CPT')) {
  $example_custom_post_type = new Example_CPT();

  register_activation_hook(__FILE__, array($example_custom_post_type, 'activate'));
  register_deactivation_hook(__FILE__, array($example_custom_post_type, 'deactivate'));
}
