<?php
/*
Plugin Name: Example CPT 
Plugin URI: https://github.com/carlosbonilla/example-cpt
Description: A plugin that registers a Custom Post Type and exposes it through the wp-json/wp/v2 rest API.
Version: 1.0
Author: Carlos Bonilla
Author URI: https://www.isboli.com/
Text Domain: example-cpt
*/

defined('ABSPATH') or die('Nope, Sorry not here.');

class Example_CPT
{

  function __construct()
  {
    add_action('init', array($this, 'register_example_post_type'));
    add_action('admin_init', array($this, 'add_role_capabilities'), 999);
    add_action('add_meta_boxes', array($this, 'create_meta_box'));
    add_action('save_post', array($this, 'save_meta_box'));
  }

  /**
   * Anything that need to be run when the plugin is Activated
   */
  function activate()
  {
    $this->create_role();
    $this->register_example_meta_field();
  }

  /**
   * Anything that need to be run when the plugin is Deactivated
   */
  function deactivate()
  {
    $this->remove_role();
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
        'name'               => __('Example CPTs', 'example-cpt'),
        'singular_name'      => __('Example CPT', 'example-cpt'),
        'add_new'            => __('Add New', 'example-cpt'),
        'add_new_item'       => __('Add New Example CPT', 'example-cpt'),
        'edit'               => __('Edit', 'example-cpt'),
        'edit_item'          => __('Edit Example CPT', 'example-cpt'),
        'new_item'           => __('New Example CPT', 'example-cpt'),
        'view'               => __('View Example CPT', 'example-cpt'),
        'view_item'          => __('View Example CPT', 'example-cpt'),
        'search_items'       => __('Search Example CPT', 'example-cpt'),
        'not_found'          => __('No Example CPTs found', 'example-cpt'),
        'not_found_in_trash' => __('No Example CPTs found in Trash', 'example-cpt'),
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

  /**
   * Register the Example Meta Custom Field
   */
  function register_example_meta_field()
  {
    $example_meta_field_args = array(
      'type' => 'string',
      'description' => 'A Example meta field for Example CPT',
      'default' => '',
      'show_in_rest' => true
    );

    register_post_meta('example-cpt', '_example_meta', $example_meta_field_args);
  }

  /**
   * Creates the meta box on the edit page for Example CPT
   */
  function create_meta_box()
  {
    add_meta_box('example_meta_field_box', 'Example Meta', array($this, 'meta_box_html'), array('example-cpt'));
  }

  /**
   * The HTML content fof the Meta Box
   */
  function meta_box_html($post)
  {
    $value = get_post_meta($post->ID, '_example_meta', true);
?>
    <label class="screen-reader-text" for=" example_meta_field"">
      <?php __('Meta Example', 'example-cpt') ?>
    </label>
    <input type=" text" id="example_meta_field" name="example_meta_field" value="<?php echo esc_attr($value) ?>">
  <?php
  }

  /**
   * Capture the Extra Meta field and stores the value on the datadase
   */
  function save_meta_box($post_id)
  {
    if (!isset($_POST['example_meta_field'])) {
      return $post_id;
    }

    $example_meta_data_value = sanitize_text_field($_POST['example_meta_field']);

    update_post_meta($post_id, '_example_meta', $example_meta_data_value);
  }
}



if (class_exists('Example_CPT')) {
  $example_custom_post_type = new Example_CPT();

  register_activation_hook(__FILE__, array($example_custom_post_type, 'activate'));
  register_deactivation_hook(__FILE__, array($example_custom_post_type, 'deactivate'));
}
