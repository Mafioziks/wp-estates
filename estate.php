<?php

/**
 * Plugin Name: Estates
 * Author: Toms Teteris
 * Author email: toms.teteris@inbox.eu
 * Description: New post type - estates.
 * Version: 1.0
 * Author URI: http://tomsteteris.id.lv/
 * Text Domain: estates
 */

include "EstateSearchWidget.php";

// Add estate post type

function addEstatePostType() {

    register_post_type('estate',
        [
            'labels'      => [
                'name'          => __('Estates', 'estate'),
                'singular_name' => __('Estate', 'estate'),
            ],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'estates'],
            'supports'    => array( 'title', 'thumbnail', 'editor' ),
            'menu_icon'   => 'dashicons-store',
            'taxonomies'    => array(),
            'capability_type' => 'post',
        ]
    );
        
    // Add new taxonomy - serie
	$labels_serie = array(
			'name'              => _x( 'Estate Series', 'taxonomy general name', 'estate' ),
			'singular_name'     => _x( 'Estate Serie', 'taxonomy singular name', 'estate' ),
			'search_items'      => __( 'Search Estate Series', 'estate' ),
			'all_items'         => __( 'All Estate Series', 'estate' ),
			'parent_item'       => __( 'Parent Estate Serie', 'estate' ),
			'parent_item_colon' => __( 'Parent Estate Serie:', 'estate' ),
			'edit_item'         => __( 'Edit Estate Serie', 'estate' ),
			'update_item'       => __( 'Update Estate Serie', 'estate' ),
			'add_new_item'      => __( 'Add New Estate Serie', 'estate' ),
			'new_item_name'     => __( 'New Estate Serie Name', 'estate' ),
			'menu_name'         => __( 'Estate Serie', 'estate' ),
	);
	
	$args_serie = array(
			'hierarchical'      => true,
			'labels'            => $labels_serie,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'estate_serie' ),
	);
	
	register_taxonomy( 'estate_serie', array( 'estate' ), $args_serie );
	
	// Add new taxonomy - type
	$labels_type = array(
			'name'              => _x( 'Estate Types', 'taxonomy general name', 'estate' ),
			'singular_name'     => _x( 'Estate Type', 'taxonomy singular name', 'estate' ),
			'search_items'      => __( 'Search Estate Types', 'estate' ),
			'all_items'         => __( 'All Estate Types', 'estate' ),
			'parent_item'       => __( 'Parent Estate Type', 'estate' ),
			'parent_item_colon' => __( 'Parent Estate Type:', 'estate' ),
			'edit_item'         => __( 'Edit Estate Type', 'estate' ),
			'update_item'       => __( 'Update Estate Type', 'estate' ),
			'add_new_item'      => __( 'Add New Estate Type', 'estate' ),
			'new_item_name'     => __( 'New Estate Type Name', 'estate' ),
			'menu_name'         => __( 'Estate Type', 'estate' ),
	);
	
	$args_type = array(
			'hierarchical'      => true,
			'labels'            => $labels_type,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'estate_type' ),
	);
	
	register_taxonomy( 'estate_type', array( 'estate' ), $args_type );
	
	// Add new taxonomy - City
	$labels_city = array(
			'name'              => _x( 'Cities/Regions', 'taxonomy general name', 'estate' ),
			'singular_name'     => _x( 'City/Region', 'taxonomy singular name', 'estate' ),
			'search_items'      => __( 'Search cities/regions', 'estate' ),
			'all_items'         => __( 'All cities/regions', 'estate' ),
			'parent_item'       => __( 'Parent city/region', 'estate' ),
			'parent_item_colon' => __( 'Parent city/region:', 'estate' ),
			'edit_item'         => __( 'Edit city/region', 'estate' ),
			'update_item'       => __( 'Update city/region', 'estate' ),
			'add_new_item'      => __( 'Add New city/region', 'estate' ),
			'new_item_name'     => __( 'New city/region', 'estate' ),
			'menu_name'         => __( 'City/Region', 'estate' ),
	);
	
	$args_city = array(
			'hierarchical'      => true,
			'labels'            => $labels_city,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'region' ),
	);
	
	register_taxonomy( 'region', array( 'estate' ), $args_city );
	
	// Add new taxonomy - residental
	$labels_residental = array(
			'name'              => _x( 'Residental complex', 'taxonomy general name', 'estate' ),
			'singular_name'     => _x( 'Residental complex', 'taxonomy singular name', 'estate' ),
			'search_items'      => __( 'Search residental complex', 'estate' ),
			'all_items'         => __( 'All residental complexes', 'estate' ),
			'parent_item'       => __( 'Parent residental complex', 'estate' ),
			'parent_item_colon' => __( 'Parent residental complex:', 'estate' ),
			'edit_item'         => __( 'Edit residental complex', 'estate' ),
			'update_item'       => __( 'Update residental complex', 'estate' ),
			'add_new_item'      => __( 'Add New residental complex', 'estate' ),
			'new_item_name'     => __( 'New residental complex', 'estate' ),
			'menu_name'         => __( 'Residental complex', 'estate' ),
	);
	
	$args_residental = array(
			'hierarchical'      => true,
			'labels'            => $labels_residental,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'residental' ),
	);
	
	register_taxonomy( 'residental', array( 'estate' ), $args_residental );
	
	// Add new taxonomy - action
	$labels_action = array(
			'name'              => _x( 'Action', 'taxonomy general name', 'estate' ),
			'singular_name'     => _x( 'Action', 'taxonomy singular name', 'estate' ),
			'search_items'      => __( 'Search actions', 'estate' ),
			'all_items'         => __( 'All actions', 'estate' ),
			'parent_item'       => __( 'Parent action', 'estate' ),
			'parent_item_colon' => __( 'Parent action:', 'estate' ),
			'edit_item'         => __( 'Edit action', 'estate' ),
			'update_item'       => __( 'Update action', 'estate' ),
			'add_new_item'      => __( 'Add New action', 'estate' ),
			'new_item_name'     => __( 'New action', 'estate' ),
			'menu_name'         => __( 'Action', 'estate' ),
	);
	
	$args_action = array(
			'hierarchical'      => true,
			'labels'            => $labels_action,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'action' ),
	);
	
	register_taxonomy( 'action', array( 'estate' ), $args_action );
}

// Register post type

add_action('init', 'addEstatePostType');

// Add metadata boxes

function admin_init(){
  add_meta_box("address_meta", __("Location", 'estate'), "address_meta", "estate", "normal", "low");
}

function address_meta() {
	?>
	<div style="display: inline-block;">
		<?= creatInputField('street', __('Street', 'estate')) ?>
		<?= creatInputField('longitude', __('Longitude', 'estate'), "number") ?>
		<?= creatInputField('latitude', __('Latitude', 'estate'), "number") ?>
	</div>
	<div style="display: inline-block;">
		<?= creatInputField('price', __('Price', 'estate'), "number") ?>
		<?= creatInputField('rooms', __('Room count', 'estate'), "number") ?>
		<?= creatInputField('floor', __('Floor', 'estate'), "number") ?>
		<?= creatInputField('area', __('Area', 'estate'), "number") ?>
	</div>
    <?php 
}

/**
 * Create simple input field
 * 
 * @param string $name
 * @param string $title
 * @param string $type
 */
function creatInputField($name, $title, $type = "text") {
	global $post;
	$value = get_post_custom($post->ID)[$name][0];
	?>
	<div>
		<label><?= $title ?>:</label><br/>
		<input type="<?= $type ?>" step="any" name="<?= $name ?>" value="<?= $value ?>"/>
	</div>
	<?php
}
add_action("admin_init", "admin_init");


// Load language

function wan_load_textdomain() {
	load_plugin_textdomain( 'estate', false, '/lang/' );
}

add_action('plugins_loaded', 'wan_load_textdomain');


// Saving estate data

function save_details(){
	global $post;

	update_post_meta($post->ID, "type", $_POST["type"]);
	update_post_meta($post->ID, "room_count", $_POST["room_count"]);
	update_post_meta($post->ID, "price", $_POST["price"]);
	update_post_meta($post->ID, "serie", $_POST["serie"]);
	update_post_meta($post->ID, "floor", $_POST["floor"]);
	update_post_meta($post->ID, "area", $_POST["area"]);
	update_post_meta($post->ID, "country", $_POST["country"]);
	update_post_meta($post->ID, "city", $_POST["city"]);
	update_post_meta($post->ID, "street", $_POST["street"]);
	update_post_meta($post->ID, "longitude", $_POST["longitude"]);
	update_post_meta($post->ID, "latitude", $_POST["latitude"]);
}

add_action('save_post', 'save_details');

// Design in post list for admin

function estate_edit_columns($columns){
	$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Estate Title",
			"description" => "Description",
			"city" => "City",
			"price" => "Price",
	);

	return $columns;
}
function estate_custom_columns($column){
	global $post;

	switch ($column) {
		case "description":
			the_excerpt();
			break;
		case "city":
			$custom = get_post_custom();
			echo $custom["city"][0];
			break;
		case "price":
			$custom = get_post_custom();
			echo $custom["price"][0];
			break;
	}
}

add_action("manage_posts_custom_column",  "estate_custom_columns");

add_filter("manage_edit-estate_columns", "estate_edit_columns");

function register_search(){
	register_widget("EstateSearchWidget");
}

add_action('widgets_init', 'register_search');

add_action('pre_get_posts', array('EstateSearchWidget','setSearchQuery'));


