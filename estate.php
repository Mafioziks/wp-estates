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

// Add estate post type

function addEstatePostType() {
	register_post_type('estate',
                       [
                           'labels'      => [
                               'name'          => _('Estates'),
                               'singular_name' => _('Estate'),
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
}

// register_activation_hook( __FILE__, 'addEstatePostType' );

add_action('init', 'addEstatePostType');

// Add metadata boxes

function admin_init(){
  add_meta_box("info-meta", _("Information"), "price", "estate", "side", "low");
  add_meta_box("coordinates-meta", _("Coordinates"), "coordinates", "estate", "side", "low");
  add_meta_box("address_meta", _("Location"), "address_meta", "estate", "normal", "low");
}
 
function price(){
  global $post;
  $custom = get_post_custom($post->ID);
  $type = $custom["type"][0];
  $price = $custom["price"][0];
  $roomCount = $custom["room_count"][0];
  $floor = $custom["floor"][0];
  $serie = $custom["serie"][0];
  ?>
  	<div>
	  <label><?php _e("Type"); ?>:</label><br>
	  <input name="type" value="<?php echo $type; ?>" />
	</div>
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
	<div>
	  <label><?php _e("Serie"); ?>:</label><br>
	  <input name="serie" value="<?php echo $serie; ?>" />
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
	load_plugin_textdomain( 'estate', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
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