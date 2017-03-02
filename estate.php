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
            'taxonomies'    => array('category', 'post_tag'),
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
}

// register_activation_hook( __FILE__, 'addEstatePostType' );

add_action('init', 'addEstatePostType');

// Add metadata boxes

function admin_init(){
  add_meta_box("info-meta", __("Information", 'estate'), "price", "estate", "side", "low");
  add_meta_box("coordinates-meta", __("Coordinates", 'estate'), "coordinates", "estate", "side", "low");
  add_meta_box("address_meta", __("Location", 'estate'), "address_meta", "estate", "normal", "low");
}
 
function price(){
  global $post;
  $custom = get_post_custom($post->ID);
  $price = $custom["price"][0];
  $roomCount = $custom["room_count"][0];
  $floor = $custom["floor"][0];
  ?>
  	<div>
	  <label><?php _e("Price"); ?>:</label><br>
	  <input name="price" value="<?php echo $price; ?>" />
	</div>
	<div>
	  <label><?php _e("Room count"); ?>:</label><br>
	  <input name="room_count" value="<?php echo $roomCount; ?>" />
	</div>	
	<div>
	  <label><?php _e("Floor"); ?>:</label><br>
	  <input name="floor" value="<?php echo $floor; ?>" />
	</div>	
  <?php
}

function coordinates() {
	global $post;
	$custom = get_post_custom($post->ID);
	$longitude = $custom["longitude"][0];
	$latitude = $custom["latitude"][0];
	?>
	<div>
		<label><?php _e("Longitude"); ?>:</label><br/>
		<input name="longitude" value="<?php echo $longitude; ?>"/>
	</div>
	<div>
		<label><?php _e("Latitude"); ?>:</label><br/>
		<input name="latitude" value="<?php echo $latitude; ?>" />
	</div>
	<?php
}
 
function address_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $country = $custom["country"][0];
  $city = $custom["city"][0];
  $street = $custom["street"][0];
?>
  <p><label><?php _e("Country"); ?>:</label><br />
  <input name="country" style="width: 100%;" value="<?php echo $country; ?>"></p>
  <p><label><?php _e("City"); ?>:</label><br />
  <input name="city" style="width: 100%;" value="<?php echo $city; ?>"></p>
  <p><label><?php _e("Street"); ?>:</label><br />
  <input name="street" style="width: 100%;" value="<?php echo $street; ?>"></p>
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

add_action('widgets_init', "register_search");
