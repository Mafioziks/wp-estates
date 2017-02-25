<?php

/**
 * Plugin Name: Estates
 * Author: Toms Teteris
 * Author email: toms.teteris@inbox.eu
 * Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
 * Version: 3.3
 * Author URI: http://tomsteteris.id.lv/
 * Text Domain: estates
 */

function addEstatePostType() {
	register_post_type('tt_estate',
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
                       ]
    );
}

// register_activation_hook( __FILE__, 'addEstatePostType' );

add_action('init', 'addEstatePostType');
 
// Estate_type
// Price
// Room count
// Floor
// Address
// Serie

function admin_init(){
  add_meta_box("info-meta", _("Information"), "price", "tt_estate", "side", "low");
  add_meta_box("coordinates-meta", _("Coordinates"), "coordinates", "tt_estate", "side", "low");
  add_meta_box("address_meta", _("Location"), "address_meta", "tt_estate", "normal", "low");
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
	  <input name="roomCount" value="<?php echo $roomCount; ?>" />
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


function wan_load_textdomain() {
	load_plugin_textdomain( 'tt_estate', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}

add_action('plugins_loaded', 'wan_load_textdomain');